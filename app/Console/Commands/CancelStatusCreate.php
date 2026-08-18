<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Apscancellation;
use App\Models\Statustrigger;
use App\Models\Workorder;
use Illuminate\Console\Command;

class CancelStatusCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancelstatuscreate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancellation requests to statustrigger';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apscancellations = Apscancellation::query()
            ->where('Inserted', '>=', now()->subMinutes(30))
            ->orderBy('Inserted', 'desc')
            ->get();

        $counter = 0;

        foreach ($apscancellations as $apscancellation) {

            $counter++;

            $this->info("{$counter}");
            $this->info("Cancellation: {$apscancellation->EISWorkOrderID} - {$apscancellation->Inserted}");

            $connections = [
                'eis' => '036',
                'usaa' => '1003800773',
                'nyl' => '036',
                'ehr' => '036',
            ];

            foreach ($connections as $connection => $statusCode) {
                $workorder = Workorder::on($connection)
                    ->select([
                        'W_WorkOrder',
                        'W_FirstName',
                        'W_LastName',
                    ])
                    ->where('W_WorkOrder', $apscancellation->EISWorkOrderID)
                    ->first();

                if ($workorder) {
                    $this->info("Database: {$connection}");
                    $this->info("Workorder: {$workorder->W_WorkOrder} - {$workorder->W_FirstName} {$workorder->W_LastName}");

                    $statustriggerExists = Statustrigger::on($connection)
                        ->where('WorkOrderNo', $workorder->W_WorkOrder)
                        ->where('ChangeType', 'S')
                        ->where('laststatus', 'like', "%{$statusCode}: Cancellation request received%")
                        ->first();

                    if (! $statustriggerExists) {
                        $statustrigger = new Statustrigger();
                        $statustrigger->setConnection($connection);
                        $statustrigger->WorkOrderNo = $workorder->W_WorkOrder;
                        $statustrigger->statuscode = $statusCode;
                        $statustrigger->laststatus = $statusCode . ': Cancellation request received (' . $apscancellation->Inserted->format('g:i:s A') . ')';
                        $statustrigger->Created = $apscancellation->Inserted;
                        $statustrigger->CreatedBy = 'EIS Process';
                        $statustrigger->ChangeType = 'S';
                        $statustrigger->save();

                        $this->warn("STATUS SAVED: {$workorder->W_WorkOrder} - {$statustrigger->laststatus}");

                    }
                    break;
                }
            }

            $this->line(str_repeat('=', 40));
        }
    }
}
