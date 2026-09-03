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

        // 5. Seed StatusList Options for both Type S (Status Notes) and Type F (Follow-Up Status)
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
            }
        }

        if (DB::connection('eisuat')->getSchemaBuilder()->hasTable('InsAgencyException')) {
            DB::connection('eisuat')->table('InsAgencyException')->updateOrInsert(
                ['CarrierName' => 'EXPRESS IMAGING SERVICES'],
                ['AgencyName' => 'DEFAULT AGENCY', 'ExceptionType' => 'Standard', 'created_at' => $now, 'updated_at' => $now]
            );
        }

        // 6. Seed 50 WorkOrders via Factory + Dependent Relations
        // IDENTITY_INSERT is per-statement/connection in SQL Server, and Laravel's
        // updateOrInsert() issues a SELECT then an INSERT as independent queries.
        // Over ODBC that session state can reset between Query Builder calls unless
        // everything runs inside one explicit transaction, so the ON/loop/OFF are
        // wrapped together here.
        DB::connection('eisuat')->transaction(function () use ($now) {
            // Enable IDENTITY_INSERT for WorkOrder
            DB::connection('eisuat')->statement('SET IDENTITY_INSERT WorkOrder ON');

            for ($i = 1; $i <= 50; $i++) {
                $woData = WorkorderFactory::new()->definition();

                DB::connection('eisuat')->table('WorkOrder')->updateOrInsert(
                    ['W_WorkOrder' => $i],
                    $woData
                );

                // Seed details table
                if (DB::connection('eisuat')->getSchemaBuilder()->hasTable('workorderdetails')) {
                    DB::connection('eisuat')->table('workorderdetails')->updateOrInsert(
                        ['workorder_id' => $i],
                        ['requestorrole' => 'Standard Requestor', 'created_at' => $now, 'updated_at' => $now]
                    );
                }

                // Seed Examrequest
                foreach (['ExamRequest', 'Examrequest'] as $table) {
                    if (DB::connection('eisuat')->getSchemaBuilder()->hasTable($table)) {
                        DB::connection('eisuat')->table($table)->updateOrInsert(
                            ['E_WorkOrder' => $i],
                            [
                                'E_Address' => rand(100, 999) . ' Main Street',
                                'E_City' => 'Los Angeles',
                                'E_State' => 'CA',
                                'E_Zip' => '90001',
                                'E_HomePhone' => '555-0199',
                                'E_CellPhone' => '555-0188',
                                'E_ApplicantEmail' => 'applicant' . $i . '@example.com',
                                'created_at' => $now,
                                'updated_at' => $now,
                            ]
                        );
                    }
                }

                // Seed StatusTrigger for "New Status Notes" feed
                foreach (['StatusTrigger', 'statustriggers'] as $table) {
                    if (DB::connection('eisuat')->getSchemaBuilder()->hasTable($table)) {
                        DB::connection('eisuat')->table($table)->updateOrInsert(
                            ['WorkOrderNo' => $i, 'statuscode' => '605'],
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
                }

                // Seed workorderholdtimes
                foreach (['workorderholdtimes', 'Workorderholdtime'] as $table) {
                    if (DB::connection('eisuat')->getSchemaBuilder()->hasTable($table)) {
                        DB::connection('eisuat')->table($table)->updateOrInsert(
                            ['workorder_id' => $i],
                            [
                                'hold_id' => 1,
                                'status_code' => '605',
                                'reason' => 'Additional Facility Information Needed',
                                'date_start' => $now->subDays(2),
                                'date_end' => null,
                                'created_by' => 'ANDRAS KENDE',
                                'modified_by' => 'ANDRAS KENDE',
                                'created_at' => $now,
                                'updated_at' => $now,
                            ]
                        );
                    }
                }

                // Seed incoming_aps_logs
                foreach (['incoming_aps_logs', 'IncomingApsLog'] as $table) {
                    if (DB::connection('eisuat')->getSchemaBuilder()->hasTable($table)) {
                        DB::connection('eisuat')->table($table)->updateOrInsert(
                            ['workorder' => $i],
                            [
                                'status' => 'Received',
                                'message' => 'APS Record payload successfully ingested.',
                                'payload' => json_encode(['workorder' => $i, 'status' => 'OK']),
                                'created_at' => $now,
                                'updated_at' => $now,
                            ]
                        );
                    }
                }

                // Seed Tickets
                foreach (['tickets', 'Ticket'] as $table) {
                    if (DB::connection('eisuat')->getSchemaBuilder()->hasTable($table)) {
                        DB::connection('eisuat')->table($table)->updateOrInsert(
                            ['workorder_id' => $i],
                            [
                                'subject' => "Follow-up inquiry for Work Order #{$i}",
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
            }

            // Disable IDENTITY_INSERT
            DB::connection('eisuat')->statement('SET IDENTITY_INSERT WorkOrder OFF');
        });

        // 7. Whitelist Local IP
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
