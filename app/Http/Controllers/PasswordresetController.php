<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Mail\PasswordresetEmail;
use App\Models\Contractor;
use App\Models\Passwordreset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PasswordresetController extends Controller
{
    public function index()
    {
        return view('passwordresets.index');
    }

    public function store(Request $request)
    {

        $C_Email = preg_replace('/[^a-zA-Z0-9.@_]/', '', $request->input('C_Email'));

        $contractor = Contractor::query()
            ->where('C_Email', $C_Email)
            ->where('C_Password', '>', '')
            ->where('C_UserCompany', 'EIS')
            ->where('is_active', 1)
            ->first();

        if ($contractor && $contractor->C_Email === $C_Email) {

            $token = hash('sha256', $contractor->C_Email . time());

            $passwordreset = new Passwordreset();
            $passwordreset->token = $token;
            $passwordreset->email = $contractor->C_Email;
            $passwordreset->active = 1;
            $passwordreset->ip_address = $_SERVER['REMOTE_ADDR'];
            $passwordreset->remote_host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $passwordreset->save();

            $data['subject'] = 'password reset ' . $this->subdomain();
            $data['contractor'] = $contractor;
            $data['token'] = $token;
            $data['subdomain'] = $this->subdomain();

            Mail::to('andras@expressimagingservices.com')->send(new PasswordresetEmail($data));
            Mail::to($contractor->C_Email)->send(new PasswordresetEmail($data));

            $request->session()->flash('success', 'We have emailed your password reset link!');

            return back();
        }

        $request->session()->flash('danger', 'User not found.');

        return back();
    }

    public function create(Request $request)
    {
        $token = $request->get('token');

        $passwordreset = Passwordreset::query()->where('token', $token)->firstOrFail();

        return view('passwordresets.create', compact('passwordreset'));
    }

    public function update(Request $request)
    {
        $token = $request->get('token');

        $passwordreset = Passwordreset::query()
            ->where('token', $token)
            ->where('active', 1)
            ->firstOrFail();

        $contractor = Contractor::query()
            ->where('C_Email', $passwordreset->email)
            ->where('C_Password', '>', '')
            ->where('C_UserCompany', 'EIS')
            ->where('is_active', 1)
            ->firstOrFail();

        $contractor->C_Password = $request->get('C_Password');
        $saved = $contractor->save();

        if ($saved) {
            $passwordreset->active = 0;
            $passwordreset->save();
            $request->session()->flash('success', 'Password was updated.');

            return redirect()
                ->away('/');
        }

        $request->session()->flash('danger', 'User not found.');

        return back();
    }
}
