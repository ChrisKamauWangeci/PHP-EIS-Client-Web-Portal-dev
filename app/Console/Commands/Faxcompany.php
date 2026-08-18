<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Fax;
use App\Models\Workorder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Faxcompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:faxcompany {database?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update company names in faxes table from workorders';

    public function handle()
    {

        $database = $this->argument('database') ?? 'eisuat';

        $workorderIds = Fax::query()
            ->where('product', 'eis')
            ->where('client', $database)
            ->whereNull('company')
            ->whereDate('created_at', '>=', now()->subDays(365))
            ->inRandomOrder()
            ->limit(300)
            ->pluck('workorder')
            ->toArray();

        $workorders = Workorder::on($database)
            ->select([
                'Workorder.W_WorkOrder',
                'Requestor.R_Company',
            ])
            ->join('Requestor', 'Requestor.R_Name', '=', 'Workorder.W_Requestor')
            ->whereIn('W_WorkOrder', $workorderIds)
            ->get();

        foreach ($workorders as $workorder) {

            dump($workorder->W_WorkOrder . ' => ' . $workorder->R_Company);

            $fax = Fax::query()
                ->select('id')
                ->where('workorder', $workorder->W_WorkOrder)
                ->where('product', 'eis')
                ->where('client', $database)
                ->whereNull('company')
                ->first();

            $fax->timestamps = false;
            $fax->company = $workorder->R_Company;
            $a = $fax->save();

            // DB::connection('mysql_fax')
            //     ->table('faxes')
            //     ->where('product', 'eis')
            //     ->where('client', $database)
            //     ->where('workorder', $workorder->W_WorkOrder)
            //     ->update([
            //         'company' => $workorder->R_Company,
            //     ]);
        }
    }
}
