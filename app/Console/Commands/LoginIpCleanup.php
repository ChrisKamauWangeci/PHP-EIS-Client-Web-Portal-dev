<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Loginip;
use Illuminate\Console\Command;

class LoginIpCleanup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:loginipcleanup {database?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Login ip cleanup addresses';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $database = $this->argument('database') ?? 'eisuat';
        config()->set('database.default', $database);

        $date = now()->format('Y-m-d H:i:s');
        $date7 = now()->subDay(7)->format('Y-m-d H:i:s');

        $this->info($date . ' ' . $database . ' Loginips count: ' . Loginip::query()->where('company', 'EIS TEST')->count());

        Loginip::query()
            ->where('company', 'EIS TEST')
            ->where('login_last', '<', $date7)
            ->delete();

        $this->info($date . ' ' . $database . ' Loginips count: ' . Loginip::query()->where('company', 'EIS TEST')->count());
    }
}
