<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Contractorloginip;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ContractorLoginIpSeeder extends Seeder
{
    public function run()
    {
        Contractorloginip::create([
            'contractor_first' => 'JOHN DOE',
            'contractor_last' => 'JOHN DOE',
            'ip_address' => '127.0.0.1',
            'ip_range' => '127.0.0',
            'remote_host' => 'localhost',
            'login_count' => 1,
            'login_last' => Carbon::now(),
        ]);

        $this->command->info('Localhost IP (127.0.0.1) successfully whitelisted!');
    }
}
