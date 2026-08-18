<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Shipment;
use App\Models\Workorder;
use Illuminate\Console\Command;

class Shipmentimportfromworkorder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:shipmentimportfromworkorder {database?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import shipments from work orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $database = $this->argument('database') ?? 'eisuat';
        config()->set('database.default', $database);

        $date6 = now()->subMonths(6)->toDateTimeString();
        $date12 = now()->subMonths(12)->toDateTimeString();

        $this->info('Workorder W_ShipFee1 count: ' . Workorder::query()->where('W_ShipFee1', '>', 0)->count());
        $this->info('Workorder W_W_ShipFee2 count: ' . Workorder::query()->where('W_ShipFee2', '>', 0)->count());
        $this->info('Workorder W_ShipFee count: ' . Workorder::query()->where('W_ShipFee', '>', 0)->count());
        $this->info('----------------------------------------');

        $workorders = Workorder::query()
            ->select([
                'W_WorkOrder',
                'W_ShipFee1',
                'W_ShipFee2',
                'W_ShipFee',
                'W_Tracking1',
                'W_Tracking2',
                'W_ReceiveDate',
            ])
            ->where('W_ShipFee1', '>', 0)
            ->orderBy('W_ReceiveDate', 'asc')
            ->get();

        foreach ($workorders as $workorder) {
            $this->info('W_WorkOrder: ' . $workorder->W_WorkOrder . ' - W_ShipFee1: ' . $workorder->W_ShipFee1 . ' - W_ShipFee2: ' . $workorder->W_ShipFee2 . ' - W_ShipFee: ' . $workorder->W_ShipFee . ' - W_Tracking1: ' . $workorder->W_Tracking1 . ' - W_Tracking2: ' . $workorder->W_Tracking2 . ' - W_ReceiveDate: ' . $workorder->W_ReceiveDate);

            $shipment = new Shipment();
            $shipment->workorder_id = $workorder->W_WorkOrder;
            $shipment->fee = $workorder->W_ShipFee1;
            $shipment->tracking_number = $workorder->W_Tracking1;
            $shipment->type = 'outgoing';
            $shipment->status = 'mailed';
            $shipment->created_by = 'import';
            $shipment->updated_by = 'import';
            $shipment->created_at = $workorder->W_ReceiveDate;
            $shipment->updated_at = $workorder->W_ReceiveDate;
            $shipment->save();
        }

        $workorders = Workorder::query()
            ->select([
                'W_WorkOrder',
                'W_ShipFee1',
                'W_ShipFee2',
                'W_ShipFee',
                'W_Tracking1',
                'W_Tracking2',
                'W_ReceiveDate',
            ])
            ->where('W_ShipFee2', '>', 0)
            ->orderBy('W_ReceiveDate', 'asc')
            ->get();

        foreach ($workorders as $workorder) {
            $this->info('W_WorkOrder: ' . $workorder->W_WorkOrder . ' - W_ShipFee1: ' . $workorder->W_ShipFee1 . ' - W_ShipFee2: ' . $workorder->W_ShipFee2 . ' - W_ShipFee: ' . $workorder->W_ShipFee . ' - W_Tracking1: ' . $workorder->W_Tracking1 . ' - W_Tracking2: ' . $workorder->W_Tracking2 . ' - W_ReceiveDate: ' . $workorder->W_ReceiveDate);

            $shipment = new Shipment();
            $shipment->workorder_id = $workorder->W_WorkOrder;
            $shipment->fee = $workorder->W_ShipFee2;
            $shipment->tracking_number = $workorder->W_Tracking2;
            $shipment->type = 'outgoing';
            $shipment->status = 'mailed';
            $shipment->created_by = 'import';
            $shipment->updated_by = 'import';
            $shipment->created_at = $workorder->W_ReceiveDate;
            $shipment->updated_at = $workorder->W_ReceiveDate;
            $shipment->save();
        }
    }
}
