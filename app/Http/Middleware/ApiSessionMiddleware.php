<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Session\Middleware\StartSession;

class ApiSessionMiddleware
{
    public function handle($request, Closure $next)
    {
        $encrypt = app()->make(EncryptCookies::class);
        $addCookies = app()->make(AddQueuedCookiesToResponse::class);
        $start = app()->make(StartSession::class);

        return $encrypt->handle($request, function ($request) use ($addCookies, $start, $next) {

            return $addCookies->handle($request, function ($request) use ($start, $next) {

                // Start the session
                return $start->handle($request, $next);
            });
        });
    }
}
