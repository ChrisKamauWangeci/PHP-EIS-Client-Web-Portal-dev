<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Eisweborder;
use App\Models\Workorderagent;
use DB;
use Illuminate\Console\Command;

class ImportShelteragentcode extends Command
{
    protected $signature = 'app:importshelteragentcode {connection=eisuat}';

    protected $description = 'Import Shelter agents code into the system';

    public function handle()
    {
        $connection = $this->argument('connection') ?? 'eisuat';

        $this->info("Importing Shelter agents code using connection: {$connection}");

        // Ensure DB queries run on this connection
        DB::setDefaultConnection($connection);

        // Workorderagent::on($connection)->delete();
        // Workorderagent::on('ehr')->delete();

        $eisweborders = Eisweborder::on($connection)
            ->select([
                'ID',
                'agentid as agent_code',
                'NewWorkorder',
                'created_at',
            ])
            ->where('23', 'SHELTER LIFE INSURANCE COMPANY')
            ->whereNotNull('NewWorkorder')
            ->orderBy('ID', 'desc')
            ->limit(1000)
            ->get();

        foreach ($eisweborders as $eisweborder) {

            if (empty($eisweborder->agent_code) || strlen($eisweborder->agent_code) !== 4) {
                continue;
            }

            // dump($eisweborder);
            dump($eisweborder->agent_code);
            dump($eisweborder->NewWorkorder);

            // $workorder_id = str_replace('New WO# ', '', $eisweborder->NewWorkorder);
            preg_match_all('/\d+/', $eisweborder->NewWorkorder, $matches);

            $workorder_ids = $matches[0];

            $filteredApsWorders = array_filter($workorder_ids, function ($num) {
                return str_starts_with($num, '3');
            });

            dump($filteredApsWorders);

            foreach ($filteredApsWorders as $workorder_id) {
                $workorderagentaps = Workorderagent::on($connection)->firstOrCreate([
                    'workorder_id' => $workorder_id,
                    'agent_code' => $eisweborder->agent_code,
                    'created_at' => $eisweborder->created_at,
                ]);
                // dump($workorderagentaps);
            }

            $filteredEhrWorders = array_filter($workorder_ids, function ($num) {
                return str_starts_with($num, '2');
            });

            dump($filteredEhrWorders);

            foreach ($filteredEhrWorders as $workorder_id) {
                $workorderagentehr = Workorderagent::on('ehr')->firstOrCreate([
                    'workorder_id' => $workorder_id,
                    'agent_code' => $eisweborder->agent_code,
                    'created_at' => $eisweborder->created_at,
                ]);
                // dump($workorderagentehr);
            }

        }

        $this->info('Shelter agents import code completed successfully.');
    }
}
