<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkorderTestSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // 1. Seed Dummy Hospitals
        $hospitals = [
            ['H_Hospital' => 'GENERAL HOSPITAL', 'H_City' => 'NEW YORK', 'H_State' => 'NY', 'H_Zip' => '10001', 'H_Phone' => '555-123-4567'],
            ['H_Hospital' => 'CITY CLINIC', 'H_City' => 'LOS ANGELES', 'H_State' => 'CA', 'H_Zip' => '90001', 'H_Phone' => '555-987-6543'],
            ['H_Hospital' => 'MERCY MEDICAL', 'H_City' => 'CHICAGO', 'H_State' => 'IL', 'H_Zip' => '60601', 'H_Phone' => '555-555-5555'],
        ];

        foreach ($hospitals as $hospital) {
            try {
                DB::table('Hospital')->insert($hospital);
            } catch (\Exception $e) {
                // Skip if already exists or schema mismatch
            }
        }

        // 2. Seed Dummy Requestors
        $requestors = [
            ['R_Name' => 'PRU_REQ_1', 'R_Company' => 'PRUDENTIAL INSURANCE COMPANY OF AMERICA', 'R_Active' => 1],
            ['R_Name' => 'NWM_REQ_1', 'R_Company' => 'NORTHWESTERN MUTUAL', 'R_Active' => 1],
            ['R_Name' => 'USAA_REQ_1', 'R_Company' => 'USAA', 'R_Active' => 1],
        ];

        foreach ($requestors as $requestor) {
            try {
                DB::table('Requestor')->insert($requestor);
            } catch (\Exception $e) {
                // Skip
            }
        }

        // 3. Seed 50 Dummy Workorders assigned to JOHN DOE
        $statuses = ['Incomplete', 'Complete', 'Cancel', 'Duplicate'];

        for ($i = 1; $i <= 50; $i++) {
            $randomDate = $now->copy()->subDays(rand(1, 60));
            $status = $statuses[array_rand($statuses)];

            try {
                DB::table('WorkOrder')->insert([
                    'W_WorkOrder' => rand(100000, 999999),
                    'W_Contractor' => 'JOHN DOE', // Assigned to the user you are logged in as
                    'W_Owner' => 'JOHN DOE',
                    'W_Status' => $status,
                    'W_Urgent' => rand(0, 1),
                    'W_FirstName' => 'PATIENT',
                    'W_LastName' => 'TESTER_' . $i,
                    'W_Hospital' => $hospitals[array_rand($hospitals)]['H_Hospital'],
                    'W_Requestor' => $requestors[array_rand($requestors)]['R_Name'],
                    'W_ReceiveDate' => $randomDate,
                    'W_CompletedDate' => $status === 'Complete' ? $randomDate->copy()->addDays(rand(1, 10)) : null,
                    'W_FollowUpStatus' => "Simulated Note entry for UI testing...\r\n",
                ]);
            } catch (\Exception $e) {
                // Skip
            }
        }

        $this->command->info('Workorders, Hospitals, and Requestors seeded successfully!');
    }
}
