<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractorLoginTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contractors = [
            ['C_Name' => 'JOHN DOE', 'C_Location' => 'Manila Night Shift', 'is_active' => 1],
            ['C_Name' => 'JANE SMITH', 'C_Location' => 'US Remote', 'is_active' => 1],
            ['C_Name' => 'ALEX JOHNSON', 'C_Location' => 'Pampanga Day Shift 1', 'is_active' => 1],
        ];

        $now = Carbon::now();

        foreach ($contractors as $cData) {

            // 1. Insert Contractor using raw DB::table to avoid Eloquent auto-timestamps
            try {
                $contractorId = DB::table('Contractor')->insertGetId(array_merge($cData, [
                    'C_UserCompany' => 'EIS',
                    'C_Password' => 'Secret123!'
                ]));
            } catch (\Exception $e) {
                $this->command->warn("Skipping contractor {$cData['C_Name']} due to schema mismatch.");
                continue;
            }

            // 2. Simulate 15 past logins per contractor
            for ($i = 0; $i < 15; $i++) {
                $randomDate = $now->copy()->subDays(rand(0, 30))->subMinutes(rand(10, 1000));

                try {
                    DB::table('contractorlogins')->insert([
                        'contractor_id' => $contractorId,
                        'contractor'    => $cData['C_Name'],
                        'ip_address'    => '192.168.1.' . rand(10, 250),
                        'page_views'    => rand(10, 150),
                        'uploads'       => rand(0, 20),
                        'downloads'     => rand(0, 50),
                        'time_on_site'  => rand(300, 28800),
                        'remote_host'   => 'localhost',
                        'created_at'    => $randomDate,
                        'updated_at'    => $randomDate->copy()->addMinutes(rand(10, 480)),
                    ]);
                } catch (\Exception $e) {
                    // Gracefully skip if missing
                }
            }

            // 3. Simulate Data Changes for the stats page
            for ($j = 0; $j < 10; $j++) {
                try {
                    DB::table('datachanges')->insert([
                        'model'       => 'workorders',
                        'foreign_key' => rand(10000, 99999),
                        'data'        => "Previous Data:\r\nStatus = Incomplete\r\n\r\nSubsequent Data:\r\nStatus = Complete",
                        'created_by'  => $cData['C_Name'],
                        'created_at'  => $now->copy()->subDays(rand(0, 30)),
                        'updated_at'  => $now->copy()->subDays(rand(0, 30)),
                    ]);
                } catch (\Exception $e) {
                    // Gracefully skip if missing
                }
            }

            // 4. Simulate Status Triggers for the stats page
            for ($k = 0; $k < 10; $k++) {
                try {
                    // Table name might be Statustrigger based on your code
                    DB::table('Statustrigger')->insert([
                        'WorkOrderNo' => rand(10000, 99999),
                        'statuscode'  => '605',
                        'laststatus'  => '605: ACTION REQUIRED START: Additional Facility Information Needed',
                        'CreatedBy'   => $cData['C_Name'],
                        'Created'     => $now->copy()->subDays(rand(0, 30)),
                        'ChangeType'  => 'S',
                    ]);
                } catch (\Exception $e) {
                    // Gracefully skip if missing
                }
            }
        }

        $this->command->info('Seeding completed! Any missing tables/columns were safely bypassed.');
    }
}
