<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Workorder;
use App\Models\Workorderpayment;
use Illuminate\Console\Command;

class Workorderpaymentimportfromworkorder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:workorderpaymentimportfromworkorder {database?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import work order payments from work orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $database = $this->argument('database') ?? 'eisuat';
        config()->set('database.default', $database);

        $this->info('Workorder W_DrFee1 count: ' . Workorder::query()->where('W_DrFee1', '>', 0)->count());
        $this->info('Workorder W_DrFee2 count: ' . Workorder::query()->where('W_DrFee2', '>', 0)->count());
        $this->info('----------------------------------------');

        $workorders = Workorder::query()
            ->select([
                'W_WorkOrder',
                'W_DrFee1',
                'W_DrFee2',
                'W_DrCheckNo',
                'W_DrCheckNo2',
                'W_DrCheckDate',
                'W_DrCheckDate2',
                'W_ReceiveDate',
            ])
            ->where('W_DrFee1', '>', 0)
            ->orderBy('W_ReceiveDate', 'asc')
            ->get();

        foreach ($workorders as $workorder) {
            $this->info('W_WorkOrder: ' . $workorder->W_WorkOrder . ' - W_DrFee1: ' . $workorder->W_DrFee1 . ' - W_DrFee2: ' . $workorder->W_DrFee2 . ' - W_DrCheckNo: ' . $workorder->W_DrCheckNo . ' - W_DrCheckNo2: ' . $workorder->W_DrCheckNo2 . ' - W_DrCheckDate: ' . $workorder->W_DrCheckDate . ' - W_ReceiveDate: ' . $workorder->W_ReceiveDate);

            $workorderpayment = new Workorderpayment();
            $workorderpayment->workorder_id = $workorder->W_WorkOrder;
            $workorderpayment->amount = $workorder->W_DrFee1;
            $workorderpayment->check_number = $workorder->W_DrCheckNo;
            $workorderpayment->payment_date = $workorder->W_DrCheckDate;
            $workorderpayment->created_at = $workorder->W_ReceiveDate;
            $workorderpayment->created_by = 'import';
            $workorderpayment->updated_at = $workorder->W_ReceiveDate;
            $workorderpayment->updated_by = 'import';
            $workorderpayment->save();
        }

        $workorders = Workorder::query()
            ->select([
                'W_WorkOrder',
                'DrFee1',
                'DrFee2',
                'W_DrCheckNo',
                'W_DrCheckNo2',
                'W_DrCheckDate',
                'W_DrCheckDate2',
                'W_ReceiveDate',
            ])
            ->where('W_DrFee2', '>', 0)
            ->orderBy('W_ReceiveDate', 'asc')
            ->get();

        foreach ($workorders as $workorder) {
            $this->info('W_WorkOrder: ' . $workorder->W_WorkOrder . ' - W_DrFee1: ' . $workorder->W_DrFee1 . ' - W_DrFee2: ' . $workorder->W_DrFee2 . ' - W_DrCheckNo: ' . $workorder->W_DrCheckNo . ' - W_DrCheckNo2: ' . $workorder->W_DrCheckNo2 . ' - W_DrCheckDate: ' . $workorder->W_DrCheckDate . ' - W_ReceiveDate: ' . $workorder->W_ReceiveDate);

            $workorderpayment = new Workorderpayment();
            $workorderpayment->workorder_id = $workorder->W_WorkOrder;
            $workorderpayment->amount = $workorder->W_DrFee2;
            $workorderpayment->check_number = $workorder->W_DrCheckNo2;
            $workorderpayment->payment_date = $workorder->W_DrCheckDate2;
            $workorderpayment->created_at = $workorder->W_ReceiveDate;
            $workorderpayment->created_by = 'import';
            $workorderpayment->updated_at = $workorder->W_ReceiveDate;
            $workorderpayment->updated_by = 'import';
            $workorderpayment->save();
        }
    }
}
