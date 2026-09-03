<?php

namespace Database\Seeders;

use Database\Factories\CompanyFactory;
use Database\Factories\ContractorFactory;
use Database\Factories\RequestorFactory;
use Database\Factories\WorkorderFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EisuatDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // 1. Primary Company Record (CompanyFactory, pinned to the fixed identity)
        DB::connection('eisuat')->table('Company')->updateOrInsert(
            ['C_Name' => 'EXPRESS IMAGING SERVICES'],
            array_merge(
                CompanyFactory::new()->definition(),
                [
                    'C_Name' => 'EXPRESS IMAGING SERVICES',
                    'C_Instruction' => 'Standard handling instructions for orders.',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            )
        );

        // 2. Primary Admin Contractor Record (ContractorFactory, forced to sysadmin)
        DB::connection('eisuat')->table('Contractor')->updateOrInsert(
            ['C_Name' => 'ANDRAS KENDE'],
            array_merge(
                ContractorFactory::new()->definition(),
                [
                    'C_Name' => 'ANDRAS KENDE',
                    'C_Email' => 'andras@expressimagingservices.com',
                    'C_SysAdmin' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            )
        );

        // 3. Primary Requestor Record (RequestorFactory, pinned to the fixed identity)
        DB::connection('eisuat')->table('Requestor')->updateOrInsert(
            ['R_Name' => 'REQ_ADMIN'],
            array_merge(
                RequestorFactory::new()->definition(),
                [
                    'R_Name' => 'REQ_ADMIN',
                    'R_Email' => 'info@expressimagingservices.com',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            )
        );

        // 4. Billing & Picklists
        DB::connection('eisuat')->table('BillToPickList')->updateOrInsert(
            ['BL_BillTo' => 'EXPRESS IMAGING SERVICES'],
            [
                'BL_InsCompany' => 'EXPRESS IMAGING SERVICES',
                'BL_MaxAmt' => 150.00,
                'BL_AuthFee' => 25.00,
                'created_by' => 'SYSTEM',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        foreach (['BillingFeeEIS', 'Billingfeeeis'] as $table) {
            if (DB::connection('eisuat')->getSchemaBuilder()->hasTable($table)) {
                DB::connection('eisuat')->table($table)->updateOrInsert(
                    ['B_Company' => 'EXPRESS IMAGING SERVICES'],
                    ['B_Fee' => 35.00, 'created_at' => $now, 'updated_at' => $now]
                );
            }
        }

        foreach (['requestorroles', 'Requestorrole'] as $table) {
            if (DB::connection('eisuat')->getSchemaBuilder()->hasTable($table)) {
                DB::connection('eisuat')->table($table)->updateOrInsert(
                    ['role' => 'Standard Requestor'],
                    ['company' => 'EXPRESS IMAGING SERVICES', 'name' => 'Standard Requestor Role', 'created_at' => $now, 'updated_at' => $now]
                );
            }
        }

        // 5. Seed WorkOrders natively
        $workOrderRows = [];
        for ($i = 1; $i <= 50; $i++) {
            $woData = WorkorderFactory::new()->definition();

            $workOrderId = DB::connection('eisuat')
                ->table('WorkOrder')
                ->insertGetId($woData, 'W_WorkOrder');

            $workOrderRows[$workOrderId] = $woData;
        }

        // 6. Check for Hospital ID 10 or 69
        $hasSpecialHospital = DB::connection('eisuat')
            ->table('WorkOrder')
            ->whereIn('W_HospitalID', [10, 69])
            ->exists();

        // 7. Seed StatusList Options
        foreach (['StatusList', 'statuslist'] as $table) {
            if (DB::connection('eisuat')->getSchemaBuilder()->hasTable($table)) {
                // Type S: Status Note Options
                $statusNotesOptions = [
                    '600' => '600 : Order Received',
                    '605' => '605 : Additional Facility Information Needed',
                    '610' => '610 : Request Sent To Facility',
                    '615' => '615 : Prepayment Required',
                    '620' => '620 : Special Authorization Required',
                    '630' => '630 : Follow Up Call Completed',
                ];

                foreach ($statusNotesOptions as $code => $label) {
                    DB::connection('eisuat')->table($table)->updateOrInsert(
                        ['statuscode' => $code, 'Type' => 'S'],
                        [
                            'Status' => $label,
                            'statusname' => substr($label, 6),
                            'description' => $label,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]
                    );
                }

                // Type F: Follow-Up Status Options
                $followUpOptions = [
                    '100' => '100 : Pending Facility Response',
                    '200' => '200 : Called Facility - Left Message',
                    '300' => '300 : Awaiting Prepayment Check',
                    '400' => '400 : Special Auth Form Mailed to Applicant',
                    '500' => '500 : Records Processing In Copy Center',
                ];

                foreach ($followUpOptions as $code => $label) {
                    DB::connection('eisuat')->table($table)->updateOrInsert(
                        ['statuscode' => $code, 'Type' => 'F'],
                        [
                            'Status' => $label,
                            'statusname' => substr($label, 6),
                            'description' => $label,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]
                    );
                }

                // Type G: Hospital G Options
                $hospitalGOptions = $hasSpecialHospital ? [
                    '101' => '101 : Status Option G',
                ] : [];

                foreach ($hospitalGOptions as $code => $label) {
                    DB::connection('eisuat')->table($table)->updateOrInsert(
                        ['statuscode' => $code, 'Type' => 'G'],
                        [
                            'Status' => $label,
                            'statusname' => trim(substr($label, strpos($label, ':') + 1)),
                            'description' => $label,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]
                    );
                }

                // Type N: Hospital N Options
                $hospitalNOptions = $hasSpecialHospital ? [
                    '201' => '201 : Status Option N',
                ] : [];

                foreach ($hospitalNOptions as $code => $label) {
                    DB::connection('eisuat')->table($table)->updateOrInsert(
                        ['statuscode' => $code, 'Type' => 'N'],
                        [
                            'Status' => $label,
                            'statusname' => trim(substr($label, strpos($label, ':') + 1)),
                            'description' => $label,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]
                    );
                }
            }
        }

        // 8. Resolve dependent table names
        $schema = DB::connection('eisuat')->getSchemaBuilder();

        $hasWorkorderDetails = $schema->hasTable('workorderdetails');
        $examTable = collect(['ExamRequest', 'Examrequest'])->first(fn($t) => $schema->hasTable($t));
        $statusTriggerTable = collect(['StatusTrigger', 'statustriggers'])->first(fn($t) => $schema->hasTable($t));
        $holdTimesTable = collect(['workorderholdtimes', 'Workorderholdtime'])->first(fn($t) => $schema->hasTable($t));
        $apsLogTable = collect(['incoming_aps_logs', 'IncomingApsLog'])->first(fn($t) => $schema->hasTable($t));
        $ticketsTable = collect(['tickets', 'Ticket'])->first(fn($t) => $schema->hasTable($t));

        if ($schema->hasTable('InsAgencyException')) {
            DB::connection('eisuat')->table('InsAgencyException')->updateOrInsert(
                ['CarrierName' => 'EXPRESS IMAGING SERVICES'],
                ['AgencyName' => 'DEFAULT AGENCY', 'ExceptionType' => 'Standard', 'created_at' => $now, 'updated_at' => $now]
            );
        }

        // 9. Seed dependent rows using generated work order IDs
        foreach ($workOrderRows as $workOrderId => $woData) {
            if ($hasWorkorderDetails) {
                DB::connection('eisuat')->table('workorderdetails')->updateOrInsert(
                    ['workorder_id' => $workOrderId],
                    ['requestorrole' => 'Standard Requestor', 'created_at' => $now, 'updated_at' => $now]
                );
            }

            if ($examTable) {
                DB::connection('eisuat')->table($examTable)->updateOrInsert(
                    ['E_WorkOrder' => $workOrderId],
                    [
                        'E_Address' => rand(100, 999) . ' Main Street',
                        'E_City' => 'Los Angeles',
                        'E_State' => 'CA',
                        'E_Zip' => '90001',
                        'E_HomePhone' => '555-0199',
                        'E_CellPhone' => '555-0188',
                        'E_ApplicantEmail' => 'applicant' . $workOrderId . '@example.com',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }

            if ($statusTriggerTable) {
                DB::connection('eisuat')->table($statusTriggerTable)->updateOrInsert(
                    ['WorkOrderNo' => $workOrderId, 'statuscode' => '605'],
                    [
                        'laststatus' => '605: ACTION REQUIRED: Additional Facility Information Needed - Standard Order Processing (' . $now->format('g:i:s A') . ')',
                        'ChangeType' => 'S',
                        'CreatedBy' => 'ANDRAS KENDE',
                        'Created' => $now,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }

            if ($holdTimesTable) {
                DB::connection('eisuat')->table($holdTimesTable)->updateOrInsert(
                    ['workorder_id' => $workOrderId],
                    [
                        'hold_id' => 1,
                        'status_code' => '605',
                        'reason' => 'Additional Facility Information Needed',
                        'date_start' => $now->copy()->subDays(2),
                        'date_end' => null,
                        'created_by' => 'ANDRAS KENDE',
                        'modified_by' => 'ANDRAS KENDE',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }

            if ($apsLogTable) {
                DB::connection('eisuat')->table($apsLogTable)->updateOrInsert(
                    ['workorder' => $workOrderId],
                    [
                        'status' => 'Received',
                        'message' => 'APS Record payload successfully ingested.',
                        'payload' => json_encode(['workorder' => $workOrderId, 'status' => 'OK']),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }

            if ($ticketsTable) {
                DB::connection('eisuat')->table($ticketsTable)->updateOrInsert(
                    ['workorder_id' => $workOrderId],
                    [
                        'subject' => "Follow-up inquiry for Work Order #{$workOrderId}",
                        'status' => 'open',
                        'priority' => 'medium',
                        'assigned_to' => 'ANDRAS KENDE',
                        'created_by' => 'ANDRAS KENDE',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        }

        // 10. Whitelist Local IP
        DB::connection('eisuat')->table('contractorloginips')->updateOrInsert(
            ['ip_address' => '127.0.0.1'],
            [
                'contractor_first' => 'ANDRAS KENDE',
                'contractor_last' => 'ANDRAS KENDE',
                'ip_range' => '127.0.0',
                'remote_host' => 'localhost',
                'login_last' => $now,
                'login_count' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }
}