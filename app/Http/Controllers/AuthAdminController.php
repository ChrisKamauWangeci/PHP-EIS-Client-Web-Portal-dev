<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Mail\IpconfirmadminEmail;
use App\Models\ContractorAdmin;
use App\Models\Contractorlogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthAdminController extends Controller
{
    public function login()
    {
        return view('authadmin.login');
    }

    public function in(Request $request)
    {
        $request->validate([
            'C_Name' => 'required|string|min:1|max:50',
            'C_Password' => 'required|string|min:4|max:50',
        ]);

        $C_Name = preg_replace('/[^a-zA-Z0-9 ]/', '', $request->get('C_Name'));

        $contractor = ContractorAdmin::query()
            ->where('C_Name', $C_Name)
            ->where('C_Password', '>', '')
            ->where('C_UserCompany', 'EIS')
            ->where('C_SysAdmin', 1)
            ->where('is_active', 1)
            ->first();

        if (! $contractor || $contractor->C_Password !== $request->C_Password) {
            return back()
                ->withInput($request->except('C_Password'))
                ->with('danger', 'The provided credentials do not match our records.');
        }

        $currentDate = now()->toDateString();

        $contractor->C_LastLogin = $currentDate;
        $contractor->timestamps = false;
        $contractor->save();

        $contractorlogin = new Contractorlogin();
        $contractorlogin->contractor_id = $contractor->id;
        $contractorlogin->contractor = $contractor->C_Name;
        $contractorlogin->ip_address = $request->ip();
        $contractorlogin->page_views = 0;
        $contractorlogin->uploads = 0;
        $contractorlogin->downloads = 0;
        $contractorlogin->time_on_site = 0;
        $contractorlogin->remote_host = gethostbyaddr($request->ip());
        $contractorlogin->save();

        $ap['subdomain'] = $this->subdomain();
        $ap['domain'] = $this->subdomain();

        $code = random_int(1000, 9999);

        $ap['code'] = $code;

        $ap['login'] = 1;
        $ap['logindate'] = $currentDate;
        $ap['pageloadtime'] = $currentDate;
        $ap['loginvaliduntildate'] = now()->addMinutes(30)->toDateString();
        $ap['loginvaliduntil'] = time() + 1800;
        $ap['debug'] = false;
        $ap['contractor'] = $contractor->toArray();
        unset($ap['contractor']['C_Password']);
        unset($ap['contractor']['row_version']);

        session(['admin' => $ap]);
        Auth::guard('admin')->login($contractor);

        if (! $ap['login']) {
            $data['from'] = 'info@expressimagingservices.com';
            $data['subject'] = 'Login Verification Code';
            $data['code'] = $code;
            $data['subdomain'] = $this->subdomain();
            $data['contractor'] = $contractor;
            $data['view'] = 'emails.ipconfirmadmin';
            Mail::mailer('smtp')->to($contractor->C_Email)->send(new IpconfirmadminEmail($data));

            return redirect()
                ->route('authadmin.ipconfirm');
        }

        return redirect()
            ->route('admin.contractorlogins.index');
    }

    public function ipconfirm(Request $request)
    {
        $code = $request->query('code');

        if ($code == session('admin.code')) {
            session(['admin.login' => 1]);

            return redirect()
                ->route('admin.contractorlogins.index');
        }

        return view('authadmin.ipconfirm');
    }

    public function ipconfirmin(Request $request)
    {
        $code = preg_replace('/[^0-9]/', '', $request->input('code'));
        if ($code == session('admin.code')) {
            session(['admin.login' => 1]);

            return redirect()
                ->route('admin.contractorlogins.index');
        }

        return back()->withInput()->with('danger', 'The provided code is invalid');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect()
            ->away('/');
    }
}
