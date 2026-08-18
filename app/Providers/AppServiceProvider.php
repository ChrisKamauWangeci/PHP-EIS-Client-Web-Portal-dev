<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        $request = app()->runningInConsole() ? null : request();

        if ($request && $request->is('user/*')) {

            View::composer('*', function ($view) {
                $view->with('usersession', session('user'));
            });

            DB::listen(function ($query) {
                if ($query->time > 1000) {
                    File::append(
                        storage_path('logs/query-user-' . date('Y-m-d') . '.log'),
                        '[' . date('Y-m-d H:i:s') . '][' . $query->time / 1000 . '][' . $query->sql . ']' . '[' . session('user.contractor.C_Name') . ']' . PHP_EOL
                    );
                }
            });
        }

        if ($request && $request->is('admin/*')) {

            View::composer('*', function ($view) {
                $view->with('adminsession', session('admin'));
            });

            Gate::before(function ($contractor, $ability) {
                if ($contractor->hasRole('superadmin')) {
                    return true;
                }
            });

            DB::listen(function ($query) {
                if ($query->time > 1) {
                    File::append(
                        storage_path('logs/query-admin-' . date('Y-m-d') . '.log'),
                        '[' . date('Y-m-d H:i:s') . '][' . $query->time / 1000 . '][' . $query->sql . ']' . '[' . session('admin.contractor.C_Name') . ']' . PHP_EOL
                    );
                }
            });

        }

        $hostname = $_SERVER['HTTP_HOST'] ?? 'eis.expressimagingservices.net';
        $domain_parts = explode('.', $hostname);
        $domain = $domain_parts[0];
        $domain = preg_replace('/[^a-z]/', '', $domain);

        view()->share('subdomain', $domain);
        view()->share('domain', $domain);
    }
}
