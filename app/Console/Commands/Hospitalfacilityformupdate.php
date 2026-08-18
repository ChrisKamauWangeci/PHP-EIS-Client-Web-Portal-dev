<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Hospital;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Hospitalfacilityformupdate extends Command
{
    protected $signature = 'app:hospitalfacilityformupdate';

    protected $description = 'Update hospital facility forms';

    public function handle()
    {
        // $this->process('eisuat');
        $this->process('eis');
        $this->process('nyl');
        $this->process('usaa');
    }

    public function process($db = 'eisuat')
    {
        $this->info('database: ' . $db);

        DB::setDefaultConnection($db);

        $hospitals = Hospital::query()
            ->select([
                'H_ID',
                'H_Hospital',
                'H_Hospital2',
                'H_State',
                'H_Phone',
                'H_Fax',
                'H_Docusign',
                'H_SpecialAuthFile',
                'facilityform_update',
                'H_UpdUser',
                'H_Created',
                'H_UpdDate',
            ])
            ->whereNull('facilityform_update')
            ->whereNull('H_Docusign')
            ->where('H_Hospital2', '>', '')
            ->where('H_State', '>', '')
            ->where('H_UpdUser', '!=', 'BATCH MATCH')
            ->orderBy('H_Created', 'desc')
            ->limit(500)
            ->get();

        $this->info('hospital count: ' . $hospitals->count());

        $updated = 0;

        foreach ($hospitals as $hospital) {
            // $this->newLine();
            $this->info('hospital selected');
            dump($hospital->toArray());

            $hospitaltemp = Hospital::query()
                ->select([
                    'H_ID',
                    'H_Hospital',
                    'H_Hospital2',
                    'H_State',
                    'H_Phone',
                    'H_Fax',
                    'H_Docusign',
                    'H_SpecialAuthFile',
                    'facilityform_update',
                    'H_UpdUser',
                    'H_UpdDate',
                ])
                ->where('H_Docusign', '>', '')
                ->where('H_Hospital2', $hospital->H_Hospital2)
                ->where('H_State', $hospital->H_State)
                ->where('H_UpdUser', '!=', 'BATCH MATCH')
                ->first();

            if ($hospitaltemp) {
                $hospital->H_Docusign = $hospitaltemp->H_Docusign;
                $hospital->H_SpecialAuthFile = $hospitaltemp->H_SpecialAuthFile;
                $hospital->H_UpdUser = 'BATCH MATCH';
                $hospital->H_UpdDate = now();

                // $this->newLine();
                $this->info('hospital temp selected');
                dump($hospitaltemp->toArray());

                $this->info($updated++);
            }

            $hospital->facilityform_update = now();
            $hospital->save();

            // $this->newLine();
            $this->info('hospital updated');
            dump($hospital->toArray());
        }

        $this->info('database: ' . $db . ' - updated records: ' . $updated);
    }
}
