<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GenerateSkeletonSchema extends Command
{
    protected $signature = 'app:generate-skeleton';

    protected $description = 'Generate baseline tables for missing enterprise DBs';

    public function handle()
    {
        $schemaMap = [
            'eis' => ['Docusigndocument', 'Docusignevent', 'EpicOrganization', 'Facilityform', 'IncomingApsConfig', 'IncomingApsLog', 'Over60DaysNoticeConfig', 'Prefill', 'PurgeConfig', 'ReportConfig', 'ReportConfigName', 'ReportConfigType', 'RequestorPasswordChange', 'Seqsterorder', 'Shelteragent', 'Smartaccesstheme', 'Ticket', 'Ticketcomment'],
            'ehr' => ['StatusTrigger', 'WorkOrder', 'HospitalRaw'],
            'mysql_fax' => ['faxes'],
            'eisprocesses' => ['NorthWesternMutual'],
            'apsstagingdata' => ['vwAPSCancellations', 'vwAPSOrders', 'vwSynodexTransmission'],
            'eisuat' => ['Accountmanager', 'addonorders', 'Agents', 'AlternatePayment', 'Bankstatement', 'BillingFeeEIS', 'BillToPickList', 'CIOXSiteID', 'Company', 'Contractor', 'Copyservice', 'CreditCardInfo', 'DrFeeUpdateHst', 'eisweborder', 'ExamRequest', 'Hospital', 'InsAgencyException', 'InsCompany', 'NorthWesternMutualAgents', 'Requestor', 'RequestorFollowup', 'ROI', 'StatusList', 'Underwriter', 'WO_INS', 'Workorderduplicates', 'WorkOrderReopen'],
        ];

        foreach ($schemaMap as $connection => $tables) {
            $this->info("Building tables for connection: {$connection}");

            foreach ($tables as $table) {
                if (! Schema::connection($connection)->hasTable($table)) {
                    Schema::connection($connection)->create($table, function (Blueprint $table) {
                        $table->id();
                        $table->timestamps();
                    });
                    $this->line("Created table/view simulation: {$table}");
                }
            }
        }
        $this->info('Skeleton schema generated successfully!');
    }
}
