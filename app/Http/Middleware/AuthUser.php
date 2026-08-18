<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Contractorlogin;
use Closure;
use Illuminate\Support\Facades\DB;

class AuthUser
{
    public function handle($request, Closure $next, $guard = null)
    {
        $usersession = session('user');

        if (! isset($usersession)) {
            return redirect('/contractors/login')->with('danger', 'invalid user');
        }

        if (! isset($usersession['login']) && ! isset($usersession['contractor'])) {
            return redirect('/contractors/login')->with('danger', 'invalid user');
        }

        if (! ($usersession['login'])) {
            return redirect('/contractors/ipconfirm')->with('danger', 'mfa not verified user');
        }

        $now = time();

        if (isset($usersession['loginvaliduntil']) && $now > $usersession['loginvaliduntil']) {
            return redirect('/contractors/login');
        }

        session(['user.pageloadtime' => date('Y-m-d H:i:s')]);
        session(['user.loginvaliduntil' => $now + 1800]);
        session(['user.loginvaliduntildate' => date('Y-m-d H:i:s', strtotime('+30 minutes'))]);

        try {
            $datetime = date('Y-m-d H:i:s');
            Contractorlogin::where('id', $usersession['contractorlogin']['id'])
                ->update([
                    'page_views' => DB::raw('page_views + 1'),
                    'time_on_site' => DB::raw("DATEDIFF(second, created_at, '$datetime')"),
                    'updated_at' => DB::raw("'$datetime'"),
                ]);
        } catch (\Throwable $th) {
        }

        // $hostname = $_SERVER['HTTP_HOST'] ?? 'eis.expressimagingservices.net';
        // $domain_parts = explode('.', $hostname);
        // $domain = $domain_parts[0];
        // $domain = preg_replace('/[^a-z0-9]/', '', $domain);

        return $next($request);

        // if($request->session()->has('login')){
        //     return $next($request);
        // }

        // return redirect('/login');

    }
}
