<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Mail\IpconfirmuserEmail;
use App\Models\Contractor;
use App\Models\Contractorlogin;
use App\Models\Contractorloginattempt;
use App\Models\Contractorloginip;
use GeoIp2\Database\Reader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthUserController extends Controller
{
    public function login()
    {
        return view('authuser.login');
    }

    public function in(Request $request)
    {
        $request->validate([
            'C_Name' => 'required|string|max:50|regex:/^[a-zA-Z0-9 ]+$/',
            'C_Password' => 'required|string|max:50',
        ]);

        $contractor = Contractor::query()
            ->where('C_Name', $request->input('C_Name'))
            ->where('C_Password', '>', '')
            ->where('C_UserCompany', 'EIS')
            ->where('is_active', 1)
            ->first();

        $ip_address = request()->ip();
        $ip_range = Str::beforeLast($ip_address, '.');

        if ($contractor && $contractor->C_Password == $request->get('C_Password')) {

            try {
                $reader = new Reader(storage_path('app/GeoLite2-City.mmdb'));
                $record = $reader->city($ip_address);

                $philippines_ips = [
                    '115.146.218.227',
                    '115.146.218.209',
                    '121.58.242.222',
                    '210.4.114.4.179',
                ];

                file_put_contents(
                    storage_path('persistent_logs/contractorlogins.txt'),
                    date('Y-m-d H:i:s') . ',' .
                        ($record->country->name ?? 'UNKNOWN') . ',' .
                        ($record->city->name ?? 'UNKNOWN') . ',' .
                        $ip_address . ',' .
                        $request->input('C_Name') . ',' .
                        $contractor->C_Location . "\n",
                    FILE_APPEND
                );

                // if ($record && $record->country->name === 'Philippines' && !in_array($ip_address, $philippines_ips)) {
                //     $request->session()->flash('danger', 'Access from this Philippines IP Address is not allowed.');

                //     file_put_contents(
                //         storage_path('persistent_logs/ipblocked.txt'),
                //         date('Y-m-d H:i:s') .
                //             ",IP BLOCKED," .
                //             ($record->country->name ?? 'UNKNOWN') . "," .
                //             ($record->city->name ?? 'UNKNOWN') . "," .
                //             $ip_address . "," .
                //             $request->input('C_Name'). "," .
                //             $contractor->C_Location . "\n",
                //         FILE_APPEND
                //     );

                //     return back()->withInput($request->except('C_Password'));
                // }

                // dd($record);
            } catch (\Exception $e) {
                file_put_contents(
                    storage_path('persistent_logs/geoip_error.txt'),
                    date('Y-m-d H:i:s') . ',GEOIP ERROR,' . $ip_address . ',' . $e->getMessage() . "\n",
                    FILE_APPEND
                );
            } finally {
                if (isset($reader)) {
                    $reader->close();
                }
            }

            $contractor->C_LastLogin = now();
            $contractor->timestamps = false;
            $contractor->save();

            $contractorlogin = new Contractorlogin();
            $contractorlogin->contractor_id = $contractor->id;
            $contractorlogin->contractor = $contractor->C_Name;
            $contractorlogin->ip_address = $ip_address;
            $contractorlogin->page_views = 0;
            $contractorlogin->uploads = 0;
            $contractorlogin->downloads = 0;
            $contractorlogin->time_on_site = 0;
            $contractorlogin->remote_host = gethostbyaddr($ip_address);
            $contractorlogin->save();

            $ap['subdomain'] = $this->subdomain();
            $ap['domain'] = $this->subdomain();

            $code = random_int(1000, 9999);
            $ap['code'] = $code;

            $ap['login'] = 1;
            $ap['logindate'] = now()->toDateTimeString();
            $ap['pageloadtime'] = now()->toDateTimeString();
            $ap['loginvaliduntildate'] = now()->addMinutes(30)->toDateTimeString();
            $ap['loginvaliduntil'] = now()->addMinutes(30)->timestamp;
            $ap['debug'] = false;
            $ap['contractor'] = $contractor->toArray();
            unset($ap['contractor']['C_Password']);
            unset($ap['contractor']['row_version']);

            $ap['contractorlogin']['id'] = $contractorlogin->id;

            session(['user' => $ap]);

            $contractorloginip = Contractorloginip::query()
                ->where('ip_address', $ip_address)
                ->first();

            if (! $contractorloginip) {
                session(['user.login' => 0]);
                session(['user.ipconfirmed' => 0]);
                $data['from'] = 'info@expressimagingservices.com';
                $data['subject'] = 'EIS NEW IP Confirm: ' . $code;
                $data['code'] = $code;
                $data['subdomain'] = $this->subdomain();
                $data['session'] = $ap;
                Mail::mailer('smtp')->to($contractor->C_Email)->send(new IpconfirmuserEmail($data));
                Mail::mailer('smtp')->to('andras@expressimagingservices.com')->send(new IpconfirmuserEmail($data));

                return redirect()
                    ->route('authuser.ipconfirm');
            }

            if ($contractor->access_mfa) {
                session(['user.login' => 0]);
                $data['from'] = 'info@expressimagingservices.com';
                $data['subject'] = 'EIS MFA IP Confirm: ' . $code;
                $data['code'] = $code;
                $data['subdomain'] = $this->subdomain();
                $data['session'] = $ap;
                Mail::mailer('smtp')->to($contractor->C_Email)->send(new IpconfirmuserEmail($data));

                return redirect()
                    ->route('authuser.ipconfirm');
            }

            try {
                if ($contractorloginip) {
                    $contractorloginip->contractor_last = $contractor->C_Name;
                    $contractorloginip->login_count = $contractorloginip->login_count + 1;
                    $contractorloginip->login_last = now();
                    $contractorloginip->save();
                } else {
                    $contractorloginip = new Contractorloginip();
                    $contractorloginip->contractor_first = $ap['contractor']['C_Name'];
                    $contractorloginip->contractor_last = $ap['contractor']['C_Name'];
                    $contractorloginip->ip_address = $ip_address;
                    $contractorloginip->ip_range = $ip_range;
                    $contractorloginip->remote_host = gethostbyaddr($ip_address);
                    $contractorloginip->login_last = now();
                    $contractorloginip->login_count = 1;
                    $contractorloginip->save();
                }
            } catch (\Throwable $th) {
            }

            session(['user.ipconfirmed' => 1]);

            return redirect()
                ->route('user.workorders.index');
        }

        if (! $contractor || $contractor->C_Password != $request->input('password')) {
            $contractorloginattempt = new Contractorloginattempt();
            $contractorloginattempt->username = $request->input('C_Name');
            $contractorloginattempt->ip_address = $ip_address;
            $contractorloginattempt->remote_host = gethostbyaddr($ip_address);
            $contractorloginattempt->save();
        }

        $request->session()->flash('danger', 'The provided credentials do not match our records.');

        return back()->withInput($request->except('password'));
    }

    public function ipconfirm(Request $request)
    {
        $code = $request->query('code');

        return view('authuser.ipconfirm', compact('code'));
    }

    public function ipconfirmin(Request $request)
    {
        $code = preg_replace('/[^0-9]/', '', $request->input('code')) ?? '';

        $userSession = session('user');
        $sessionCode = $userSession['code'] ?? null;

        if ($code == $sessionCode) {

            $ip_address = request()->ip();
            $ip_range = Str::beforeLast($ip_address, '.');

            $contractorloginip = Contractorloginip::query()
                ->where('ip_address', $ip_address)
                ->first();

            try {
                if ($contractorloginip) {
                    $contractorloginip->contractor_last = session('user.contractor.C_Name');
                    $contractorloginip->login_count = $contractorloginip->login_count + 1;
                    $contractorloginip->login_last = now();
                    $contractorloginip->save();
                } else {
                    $contractorloginip = new Contractorloginip();
                    $contractorloginip->contractor_first = session('user.contractor.C_Name');
                    $contractorloginip->contractor_last = session('user.contractor.C_Name');
                    $contractorloginip->ip_address = $ip_address;
                    $contractorloginip->ip_range = $ip_range;
                    $contractorloginip->remote_host = gethostbyaddr($ip_address);
                    $contractorloginip->login_last = now();
                    $contractorloginip->login_count = 1;
                    $contractorloginip->save();
                }
            } catch (\Throwable $th) {
            }

            session(['user.login' => 1]);
            session(['user.ipconfirmed' => 1]);

            return redirect()
                ->route('user.workorders.index');
        }

        return back()->withInput()->with('danger', 'The provided code is invalid');
    }

    public function ip(Request $request)
    {
        $usersession = session('user');

        if (! $usersession['ip_code'] && ! $usersession['contractor']['C_Name']) {
            $request->session()->flash('danger', 'Invalid request. Please, try again');

            return redirect('/contractors/login');
        }

        $code = $request->query('code');

        return view('authuser.ip', compact('code'));
    }

    public function logout(Request $request)
    {
        unset($_SESSION['user']);
        session_destroy();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
