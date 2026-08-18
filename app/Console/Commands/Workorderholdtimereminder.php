<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\WorkorderholdtimereminderEmail;
use App\Models\Statustrigger;
use App\Models\Workorderholdtime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class Workorderholdtimereminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:workorderholdtimereminder {database?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for work order hold times';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info(' - ');

        $database = $this->argument('database') ?? 'eisuat';
        config()->set('database.default', $database);

        $companies = [
            // '0' => [
            //     'company' => 'PRUDENTIAL INSURANCE COMPANY OF AMERICA',
            //     'days' => '14,21,28',
            //     'email' => 'andras@expressimagingservices.com',
            // ],
            '1' => [
                'company' => 'NORTHWESTERN MUTUAL LTC',
                'days' => '14,21,28',
                'email' => 'andras@expressimagingservices.com',
            ],
            '2' => [
                'company' => 'USAA',
                'days' => '14,21,28',
                'email' => 'andras@expressimagingservices.com',
            ],
        ];

        foreach ($companies as $company) {
            $this->info('Processing company: ' . $company['company']);
            $this->info('Email: ' . $company['email']);

            if (isset($company['days'])) {
                $days = array_map('intval', explode(',', $company['days']));
                foreach ($days as $day) {
                    $this->sendForDays($company, (int) $day);
                }
            }
        }
    }

    private function sendForDays($company, $day)
    {
        $start = now()->subDays($day);
        $end = now()->subDays($day)->endOfDay();

        $workorderholdtimes = Workorderholdtime::query()
            ->select([
                'workorderholdtimes.*',
                'Company.C_Name as company_name',
                'Requestor.R_Name as requestor_name',
                'Contractor.C_Name as contractor_name',
                'Contractor.C_Email as contractor_email',
                'WorkOrder.W_FirstName as W_FirstName',
                'WorkOrder.W_LastName as W_LastName',
                'WorkOrder.W_Hospital as W_Hospital',
                'WorkOrder.W_ReceiveDate as W_ReceiveDate',
                'WorkOrder.W_CompletedDate as W_CompletedDate',
            ])
            ->join('WorkOrder', 'WorkOrder.W_WorkOrder', '=', 'workorderholdtimes.workorder_id')
            ->join('Contractor', 'Contractor.C_Name', '=', 'WorkOrder.W_Contractor')
            ->join('Requestor', 'Requestor.R_Name', '=', 'WorkOrder.W_Requestor')
            ->join('Company', 'Company.ID', '=', 'workorderholdtimes.company_id')
            ->where('WorkOrder.W_Status', 'Incomplete')
            ->where('Company.C_Name', $company['company'])
            ->whereBetween('workorderholdtimes.created', [$start, $end])
            ->whereNull('workorderholdtimes.date_end')
            ->whereNull('WorkOrder.W_CompletedDate')
            ->orderBy('workorderholdtimes.created', 'desc')
            ->limit(5)
            ->get();

        $output = [];

        $output[] = 'Workorder Hold Time Reminder';
        $output[] = 'Date: ' . now()->format('Y-m-d H:i:s');
        $output[] = 'Workorder Hold Time Created From: ' . $start->format('Y-m-d H:i:s');
        $output[] = 'Workorder Hold Time Created To: ' . $end->format('Y-m-d H:i:s');
        $output[] = 'Workorder Hold Times Found: ' . $workorderholdtimes->count();
        $output[] = '';

        foreach ($output as $line) {
            $this->info($line);
        }

        foreach ($workorderholdtimes as $workorderholdtime) {
            // dump($workorderholdtime->toArray());
            $this->info('Workorder ID: ' . $workorderholdtime->workorder_id);

            $statustrigger = Statustrigger::query()
                ->select([
                    'ID',
                    'WorkOrderNo',
                    'Created',
                    'CreatedBy',
                    'ChangeType',
                    'Updated',
                    'laststatus',
                    'statuscode',
                ])
                ->where('WorkOrderNo', $workorderholdtime->workorder_id)
                ->orderBy('Created', 'desc')
                ->first();

            $data['from'] = 'eis-completion@expressimagingservices.com';
            $data['subject'] = "ACTION REQUIRE: Inquiry follow-up for {$workorderholdtime->W_FirstName} {$workorderholdtime->W_LastName} (Work Order No: {$workorderholdtime->workorder_id})";

            $dt['company'] = $company['company'];
            $dt['workorderholdtime'] = $workorderholdtime->toArray();
            $dt['statustrigger'] = $statustrigger->toArray();
            $data['data'] = $dt;
            $data['view'] = 'emails.workorderholdtimereminder';

            // Mail::mailer('smtprelaygmail')
            //     ->to($company['email'])
            //     ->send(new WorkorderholdtimereminderEmail($data));

            Mail::to($company['email'])
                ->send(new WorkorderholdtimereminderEmail($data));

            sleep(1);

            // $statustrigger = new Statustrigger();
            // $statustrigger->WorkOrderNo = $workorderholdtime->workorder_id;
            // $statustrigger->statuscode = '';
            // $statustrigger->laststatus = '111 : Reminder: (' . now()->format('g:i:s A') . ')';
            // $statustrigger->Created = now();
            // $statustrigger->CreatedBy = 'AUTO TASKS';
            // $statustrigger->ChangeType = 'S';
            // $statustrigger->save();
        }
        $this->info('----------');
    }
}
