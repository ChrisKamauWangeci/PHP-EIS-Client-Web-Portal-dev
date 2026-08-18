<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;

class AuthAdmin
{
    public function handle($request, Closure $next, $guard = null)
    {

        $adminsession = session('admin') ?? null;

        if (! isset($adminsession)) {
            return redirect('/authadmin/login')->with('error', 'invalid user');
        }

        if (! isset($adminsession['login']) && ! isset($adminsession['admin'])) {
            return redirect('/authadmin/login')->with('error', 'invalid user');
        }

        if (! ($adminsession['login'])) {
            return redirect('/authadmin/ipconfirm')->with('error', 'mfa not verified user');
        }

        return $next($request);

    }
}
