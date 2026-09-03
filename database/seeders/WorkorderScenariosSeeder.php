<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WorkorderScenariosSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Parent Companies
        $companies = [
            'NORTHWESTERN MUTUAL',
            'PRUDENTIAL INSURANCE COMPANY OF AMERICA',
            'USAA',
            'NATIONWIDE LIFE UNDERWRITING',
            'BESTOW AGENCY LLC',
            'MASSMUTUAL',
            'PLICO-WCL',
            'FFR'
        ];
        foreach ($companies as $c) {
            DB::table('Company')->updateOrInsert(['C_Name' => $c], ['C_Name' => $c]);
        }

        // 2. Map Requestors
        $requestorMap = [
            'REQ_NWM'        => 'NORTHWESTERN MUTUAL',
            'REQ_PRUDENTIAL' => 'PRUDENTIAL INSURANCE COMPANY OF AMERICA',
            'REQ_USAA'       => 'USAA',
            'REQ_NATIONWIDE' => 'NATIONWIDE LIFE UNDERWRITING',
            'REQ_BESTOW'     => 'BESTOW AGENCY LLC',
            'REQ_MASSMUTUAL' => 'MASSMUTUAL',
            'REQ_PLICO'      => 'PLICO-WCL',
            'REQ_FFR'        => 'FFR',
        ];
        foreach ($requestorMap as $reqName => $compName) {
            DB::table('Requestor')->updateOrInsert(
                ['R_Name' => $reqName],
                ['R_Company' => $compName, 'R_Email' => strtolower($reqName) . '@expressimagingservices.com']
            );
        }

        // 3. Seed Hospitals with Diverse Configurations
        $hospitals = [
            ['H_Hospital' => 'General Medical Center',     'H_SendMethod' => 1, 'H_Docusign' => 'docusign-form-1', 'H_ResponseTime' => 3, 'H_TurnOverDays' => 5],
            ['H_Hospital' => 'Mercy Health Hospital',      'H_SendMethod' => 5, 'H_SpecialAuth' => 1,            'H_ResponseTime' => 5, 'H_TurnOverDays' => 10],
            ['H_Hospital' => 'USAA Veterans Hospital',    'H_SendMethod' => 3, 'H_ResponseTime' => 7,            'H_TurnOverDays' => 14],
            ['H_Hospital' => 'Nationwide Care Center',     'H_SendMethod' => 1, 'H_ResponseTime' => 2,            'H_TurnOverDays' => 4],
            ['H_Hospital' => 'SmartOffice Medical Group',  'H_SendMethod' => 2, 'H_ResponseTime' => 4,            'H_TurnOverDays' => 7],
            ['H_Hospital' => 'St. Jude Childrens Hospital', 'H_SendMethod' => 1, 'H_PayAdvance' => 1,            'H_ResponseTime' => 5, 'H_TurnOverDays' => 10],
            ['H_Hospital' => 'PLICO Medical Annex',        'H_SendMethod' => 4, 'H_Note' => 'Call back only on Tuesdays and Thursdays.', 'H_ResponseTime' => 5, 'H_TurnOverDays' => 7],
            ['H_Hospital' => 'FFR Community Clinic',       'H_SendMethod' => 1, 'H_CopyService' => 'ACTON COPY',  'H_ROI' => 'STANDARD ROI', 'H_ResponseTime' => 3, 'H_TurnOverDays' => 5],
            ['H_Hospital' => 'Northwestern Memorial',      'H_SendMethod' => 1, 'H_ResponseTime' => 3,            'H_TurnOverDays' => 5],
            ['H_Hospital' => 'Central Health Institute',   'H_SendMethod' => 1, 'H_ResponseTime' => 4,            'H_TurnOverDays' => 8],
        ];
        foreach ($hospitals as $h) {
            DB::table('Hospital')->updateOrInsert(['H_Hospital' => $h['H_Hospital']], $h);
        }

        // 4. Assign Varied Data Scenarios Across the 10 Work Orders
        $scenarios = [
            2192893 => ['REQ_NWM',        'General Medical Center',      0,  'Incomplete', 'NORTHWESTERN MUTUAL'],
            2192894 => ['REQ_PRUDENTIAL', 'Mercy Health Hospital',       0,  'Incomplete', 'PRUDENTIAL'],
            2192888 => ['REQ_USAA',       'USAA Veterans Hospital',     88, 'Incomplete', 'USAA LIFE'],
            2192189 => ['REQ_NATIONWIDE', 'Nationwide Care Center',      69, 'Incomplete', 'NATIONWIDE'],
            2192892 => ['REQ_BESTOW',     'SmartOffice Medical Group',   10, 'Incomplete', 'BESTOW'],
            2192880 => ['REQ_MASSMUTUAL', 'St. Jude Childrens Hospital', 0,  'Incomplete', 'MASSMUTUAL'],
            2192889 => ['REQ_PLICO',      'PLICO Medical Annex',         0,  'Incomplete', 'PLICO-WCL'],
            2192882 => ['REQ_FFR',        'FFR Community Clinic',        0,  'Incomplete', 'FFR INSURANCE'],
            2192884 => ['REQ_NWM',        'Northwestern Memorial',       0,  'Complete',   'NORTHWESTERN MUTUAL'],
            2192886 => ['REQ_NWM',        'Central Health Institute',    0,  'Incomplete', 'NORTHWESTERN MUTUAL'],
        ];

        foreach ($scenarios as $woId => $d) {
            DB::table('WorkOrder')->where('W_WorkOrder', $woId)->update([
                'W_Requestor'  => $d[0],
                'W_Hospital'   => $d[1],
                'W_HospitalID' => $d[2],
                'W_Status'     => $d[3],
                'W_InsCompany' => $d[4],
                'W_UpdUser'    => 'SEEDER',
                'W_UpdDate'    => now(),
            ]);
        }

        // 5. Trigger an Active Hold Banner for 2192886
        if (Schema::hasTable('workorderholdtimes')) {
            DB::table('workorderholdtimes')->updateOrInsert(
                ['workorder_id' => 2192886, 'date_end' => null],
                [
                    'date_start' => now()->subDays(2),
                    'reason'     => 'Special Authorization Prefill',
                    'created_by' => 'SEEDER',
                ]
            );
        }
    }
}