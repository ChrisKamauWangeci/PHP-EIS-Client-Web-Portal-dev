<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('Contractor')->insert([
            'C_Name' => 'Admin User',
            'C_Password' => 'Secret123!',
            'C_Email' => 'admin@example.com',
            'C_Location' => 'US Remote',
            'C_SysAdmin' => 1,
            'is_active' => 1,
            'C_UserCompany' => 'EIS',
        ]);
    }
}
