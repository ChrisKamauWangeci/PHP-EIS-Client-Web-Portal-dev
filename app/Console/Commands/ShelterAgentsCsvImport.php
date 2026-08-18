<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ShelterAgentsCsvImport extends Command
{
    protected $signature = 'app:shelteragentscsvimport {connection=eisuat}';

    protected $description = '';

    public function handle()
    {
        $connection = $this->argument('connection') ?? 'eisuat';

        $this->info("Shelter Agents CSV Import using connection: {$connection}");

        // Ensure DB queries run on this connection
        DB::setDefaultConnection($connection);

        $handle = fopen(storage_path('app/shelteragents.csv'), 'r');

        fgetcsv($handle);

        $i = 0;

        $batch = [];

        $now = now();

        while (($row = fgetcsv($handle, 100, ',')) !== false) {

            echo $i . ' ' . $row[0] . ' ' . $row[1] . ' ' . $row[2] . "\n";
            $i++;

            $batch[] = [
                'name' => $row[0],
                'sdl_district_number' => $row[1],
                'email' => $row[2],
                'agent_code' => $row[3],
                'role' => $row[4],
                'login_count' => 0,
                'is_active' => 1,
                'created_by' => 'EIS',
                'updated_by' => 'EIS',
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (count($batch) >= 100) {
                DB::table('shelteragents')->insert($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            DB::table('shelteragents')->insert($batch);
        }

        fclose($handle);
    }
}
