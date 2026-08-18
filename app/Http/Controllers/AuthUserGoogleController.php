<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\Contractorlogin;
use App\Models\Contractorloginattempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthUserGoogleController extends Controller
{
    public function redirect(Request $request)
    {
        $request->validate([
            'prompt' => 'nullable|in:none,consent,select_account',
        ]);

        if ($this->subdomain() !== 'eisdev') {
            abort(403, 'Access denied');
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session(['google_oauth_state' => $state = bin2hex(random_bytes(16))]);

        $redirectUri = $request->getSchemeAndHttpHost() . config('services.google.redirect_path');

        $query = [
            'client_id' => config('services.google.client_id'),
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'hd' => 'expressimagingservices.com',
            'state' => $state,
        ];

        if ($request->filled('prompt')) {
            $query['prompt'] = $request->input('prompt');
        }

        return redirect('https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($query));
    }

    public function callback(Request $request)
    {
        if ($request->state !== session('google_oauth_state')) {
            abort(403, 'Invalid state');
        }

        if ($request->has('error')) {
            return redirect('/login')->with('danger', 'Google login failed');
        }

        $redirectUri = $request->getSchemeAndHttpHost() . config('services.google.redirect_path');

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'code' => $request->code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirectUri,
        ]);

        if ($response->failed()) {
            abort(500, 'Token request failed');
        }

        $tokenData = $response->json();
        // dump($tokenData);

        if (!isset($tokenData['access_token'])) {
            return redirect('/')->with('danger', 'Token failed');
        }

        $idToken = $tokenData['id_token'] ?? null;

        if (!$idToken) {
            abort(403, 'Missing id_token');
        }

        $parts = explode('.', $idToken);

        if (count($parts) !== 3) {
            abort(403, 'Invalid token format');
        }

        $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);

        if (empty($payload['sub'])) {
            abort(403, 'Invalid subject');
        }

        if (!$payload || !is_array($payload)) {
            abort(403, 'Invalid token payload');
        }

        if ($payload['aud'] !== config('services.google.client_id')) {
            abort(403, 'Invalid audience');
        }

        if (!in_array($payload['iss'], ['https://accounts.google.com', 'accounts.google.com'])) {
            abort(403, 'Invalid issuer');
        }

        if ($payload['exp'] < time() - 30) {
            abort(403, 'Token expired');
        }

        if (($payload['email_verified'] ?? false) !== true) {
            abort(403, 'Email not verified');
        }

        // dump($payload);

        $googleUser = [
            'email' => $payload['email'],
            'name' => $payload['name'] ?? '',
            'given_name' => $payload['given_name'] ?? '',
            'family_name' => $payload['family_name'] ?? '',
            'picture' => $payload['picture'] ?? '',
            'id' => $payload['sub'],
        ];
        // dd($googleUser);

        // if (!str_ends_with($googleUser['email'], '@expressimagingservices.com') && !str_ends_with($googleUser['email'], '@ircopy.com')) {
        //     return redirect('/')->with('danger', 'Unauthorized domain');
        // }

        $allowedDomains = ['expressimagingservices.com', 'ircopy.com'];

        $emailDomain = explode('@', $googleUser['email'])[1] ?? null;

        if (
            (!isset($payload['hd']) || !in_array($payload['hd'], $allowedDomains))
            && !in_array($emailDomain, $allowedDomains)
        ) {
            abort(403, 'Unauthorized domain');
        }

        $contractor = Contractor::query()
            ->where('C_Email', $googleUser['email'])
            ->whereNotNull('C_Password')
            ->where('C_Password', '!=', '')
            ->where('C_UserCompany', 'EIS')
            ->where('is_active', 1)
            ->first();

        $ip_address = request()->ip();

        $remoteHost = null;
        try {
            $remoteHost = gethostbyaddr($ip_address);
        } catch (\Throwable $e) {
            $remoteHost = null;
        }

        if ($contractor) {

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
            $contractorlogin->remote_host = $remoteHost;
            $contractorlogin->save();

            $ap['subdomain'] = $this->subdomain();

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

            session(['user.ipconfirmed' => 1]);

            $request->session()->regenerate();
            session()->forget('google_oauth_state');

            return redirect()
                ->route('user.workorders.index');
        }

        $contractorloginattempt = new Contractorloginattempt();
        $contractorloginattempt->username = $googleUser['email'];
        $contractorloginattempt->ip_address = $ip_address;
        $contractorloginattempt->remote_host = $remoteHost;
        $contractorloginattempt->save();

        return redirect('/')
            ->with('danger', 'No matching contractor found');
    }
}
