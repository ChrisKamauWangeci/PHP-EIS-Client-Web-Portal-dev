<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Contractorlogin;
use App\Models\Contractorloginattempt;
use App\Models\Contractorloginip;
use App\Models\Filetransfer;
use App\Models\Login;
use App\Models\Loginip;
use Illuminate\Console\Command;

class Datamaintenance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:datamaintenance {database?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Data maintenance for contractor logins, login attempts, login IPs, and file transfers.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $database = $this->argument('database') ?? 'eisuat';
        config()->set('database.default', $database);

        $date = now()->format('Y-m-d H:i:s');
        $date6 = now()->subMonths(6)->format('Y-m-d H:i:s');
        $date12 = now()->subMonths(12)->format('Y-m-d H:i:s');
        $date24 = now()->subMonths(24)->format('Y-m-d H:i:s');
        $date36 = now()->subMonths(36)->format('Y-m-d H:i:s');

        $this->newLine();
        $this->info($date . ' ' . $database . ' Contractorlogins count: ' . Contractorlogin::count());
        $this->info($date . ' ' . $database . ' Contractorlogins delete: ' . Contractorlogin::where('created_at', '<', $date36)->delete());
        $this->info($date . ' ' . $database . ' Contractorlogins count: ' . Contractorlogin::count());

        $this->newLine();
        $this->info($date . ' ' . $database . ' Contractorloginattempts count: ' . Contractorloginattempt::count());
        $this->info($date . ' ' . $database . ' Contractorloginattempts delete: ' . Contractorloginattempt::where('created_at', '<', $date24)->delete());
        $this->info($date . ' ' . $database . ' Contractorloginattempts count: ' . Contractorloginattempt::count());

        $this->newLine();
        $this->info($date . ' ' . $database . ' Contractorloginips count: ' . Contractorloginip::count());
        $this->info($date . ' ' . $database . ' Contractorloginips delete: ' . Contractorloginip::where('login_last', '<', $date12)->delete());
        $this->info($date . ' ' . $database . ' Contractorloginips count: ' . Contractorloginip::count());

        $this->newLine();
        $this->info($date . ' ' . $database . ' Logins count: ' . Login::count());
        $this->info($date . ' ' . $database . ' Logins delete: ' . Login::where('created', '<', $date24)->delete());
        $this->info($date . ' ' . $database . ' Logins count: ' . Login::count());

        $this->newLine();
        $this->info($date . ' ' . $database . ' Loginips count: ' . Loginip::count());
        $this->info($date . ' ' . $database . ' Loginips delete: ' . Loginip::where('login_last', '<', $date12)->delete());
        $this->info($date . ' ' . $database . ' Loginips count: ' . Loginip::count());

        $this->newLine();
        $this->info($date . ' ' . $database . ' Filetransfers count: ' . Filetransfer::count());
        $this->info($date . ' ' . $database . ' Filetransfers delete: ' . Filetransfer::where('created_at', '<', $date12)->delete());
        $this->info($date . ' ' . $database . ' Filetransfers count: ' . Filetransfer::count());

        $this->newLine();
        $this->info('////////////////////////////////////////////////////////////////////////////////');
        $this->newLine();

    }
}
