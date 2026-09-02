<?php

namespace Database\Seeders;

use App\Models\Statustrigger;
use App\Models\Workorder;
use Illuminate\Database\Seeder;

class TestNotesSeeder extends Seeder
{
    public function run()
    {
        $workorders = Workorder::where('W_Owner', 'JOHN DOE')->get();

        if ($workorders->isEmpty()) {
            $this->command->info("No workorders found for JOHN DOE.");
            return;
        }

        foreach ($workorders as $workorder) {
            // 1. Populate the "Old Status Notes" (W_Note in Workorder)
            $workorder->W_Note = "--- SEEDED OLD NOTE ---\nTesting old status notes for John Doe.\nUpdated: " . now()->format('Y-m-d H:i:s');
            $workorder->timestamps = false;
            $workorder->save();

            // 2. Populate "New Status Notes" (Statustrigger) - Record 1
            $trigger1 = new Statustrigger();
            $trigger1->WorkOrderNo = $workorder->W_WorkOrder;
            $trigger1->statuscode  = '100';
            $trigger1->laststatus  = '100: Initial testing status generated via Seeder (' . now()->format('g:i:s A') . ')';
            $trigger1->Created     = now()->subDays(2);
            $trigger1->CreatedBy   = 'JOHN DOE';
            $trigger1->ChangeType  = 'S';
            $trigger1->save();

            // 3. Populate "New Status Notes" (Statustrigger) - Record 2
            $trigger2 = new Statustrigger();
            $trigger2->WorkOrderNo = $workorder->W_WorkOrder;
            $trigger2->statuscode  = '101';
            $trigger2->laststatus  = '101: Follow-up testing status generated via Seeder (' . now()->format('g:i:s A') . ')';
            $trigger2->Created     = now();
            $trigger2->CreatedBy   = 'JOHN DOE';
            $trigger2->ChangeType  = 'S';
            $trigger2->save();

            $this->command->info("Populated Workorder: {$workorder->W_WorkOrder}");
        }

        $this->command->info("Seeding complete.");
    }
}
