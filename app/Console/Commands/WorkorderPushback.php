<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Datachange;
use App\Models\Workorder;
use App\Models\Workorderreopen;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class WorkorderPushback extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:workorderpushback {database?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push back work orders to a previous state';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info(' - ');

        $database = $this->argument('database') ?? 'eisuat';
        config()->set('database.default', $database);

        $startOfLastMonth = Carbon::now()->subMonthNoOverflow()->startOfMonth()->format('Y-m-d H:i:s');
        $endOfLastMonth = Carbon::now()->subMonthNoOverflow()->endOfMonth()->format('Y-m-d H:i:s');

        // $startOfLastMonth = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        // $endOfLastMonth = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

        // dd($startOfLastMonth, $endOfLastMonth);

        $workordersreopen = Workorderreopen::query()
            ->select([
                'Mi_WorkOrder',
                'Mi_CompletedDate',
                'Mi_ReopenDate',
                'Mi_PageCount',
                'Mi_CompletionType',
                'Mi_UpdatedBy',
                'WorkOrder.W_WorkOrder as W_WorkOrder',
                'WorkOrder.W_Status as W_Status',
                'WorkOrder.W_ReceiveDate as W_ReceiveDate',
                'WorkOrder.W_CompletedDate as W_CompletedDate',
                'WorkOrder.W_CompletionType as W_CompletionType',
            ])
            ->where('WorkOrderReopen.Mi_CompletionType', 1)
            ->where('WorkOrder.W_CompletedDate', '!=', null)
            ->where('WorkOrder.W_CompletedDate', '>=', $startOfLastMonth)
            ->where('WorkOrder.W_CompletedDate', '<=', $endOfLastMonth)
            ->whereRaw('WorkOrderReopen.Mi_CompletedDate < WorkOrder.W_CompletedDate')
            ->orderBy('WorkOrder.W_CompletedDate', 'desc')
            ->join('WorkOrder', 'WorkOrder.W_WorkOrder', '=', 'WorkOrderReopen.Mi_WorkOrder')
            ->limit(500000)
            ->get();

        $output = [];

        $output[] = 'Workorder Pushback Report';
        $output[] = 'Date: ' . now()->format('Y-m-d H:i:s');
        $output[] = 'Database: ' . $database;
        $output[] = 'Start: ' . $startOfLastMonth;
        $output[] = 'End: ' . $endOfLastMonth;
        $output[] = 'Workordersreopen found: ' . $workordersreopen->count();
        $output[] = '';

        foreach ($output as $line) {
            $this->info($line);
        }

        $i = 0;

        foreach ($workordersreopen as $workorderreopen) {

            $workorder = Workorder::query()
                ->where('W_WorkOrder', $workorderreopen->W_WorkOrder)
                ->first();

            if ($workorder) {

                $data = "Previous Data:\r\n";
                $data .= 'Completed Date = ' . $workorder->W_CompletedDate . "\r\n";
                $data .= "\r\n";
                $data .= "Subsequent Data:\r\n";
                $data .= 'Completed Date = ' . $workorderreopen->Mi_CompletedDate . "\r\n";
                $data = rtrim($data);

                $datachange = new Datachange();
                $datachange->model = 'workorders';
                $datachange->foreign_key = $workorder->W_WorkOrder;
                $datachange->data = $data;
                $datachange->created_by = 'EIS Pushback';
                $datachange->save();
                // dump($datachange);

                $workorder->W_CompletedDate = $workorderreopen->Mi_CompletedDate;
                $workorder->save();
                // dump($workorder);

            }

            $this->info(
                $i++ .
                    ' W_WorkOrder: ' . $workorderreopen->W_WorkOrder .
                    ' W_ReceiveDate: ' . $workorderreopen->W_ReceiveDate?->format('Y-m-d') .
                    ' W_CompletedDate: ' . $workorderreopen->W_CompletedDate?->format('Y-m-d') .
                    ' Mi_CompletedDate: ' . $workorderreopen->Mi_CompletedDate?->format('Y-m-d') .
                    ' W_Status: ' . $workorderreopen->W_Status
            );
            $output[] =
                'W_WorkOrder: ' . $workorderreopen->W_WorkOrder .
                ' W_ReceiveDate: ' . $workorderreopen->W_ReceiveDate?->format('Y-m-d') .
                ' W_CompletedDate: ' . $workorderreopen->W_CompletedDate?->format('Y-m-d') .
                ' Mi_CompletedDate: ' . $workorderreopen->Mi_CompletedDate?->format('Y-m-d') .
                ' W_Status: ' . $workorderreopen->W_Status;
        }

        $this->info(' - ');

        Mail::raw(implode("\n", $output), function ($message) use ($database, $startOfLastMonth, $endOfLastMonth) {
            $message->from('no-reply@expressimagingservices.com', 'Express Imaging Services')
                ->to('andras@expressimagingservices.com')
                ->subject('Workorder Pushback Report ' . $database . ' ' . $startOfLastMonth . ' - ' . $endOfLastMonth);
        });
    }
}
