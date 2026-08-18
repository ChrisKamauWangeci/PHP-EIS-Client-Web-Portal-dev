<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Helper\Helper;
use App\Models\Hospital;
use Illuminate\Console\Command;

class Hospitaltimezoneupdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hospitaltimezoneupdate {database?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update timezone_offset for hospitals where it is null';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $database = $this->argument('database') ?? 'eisuat';
        config()->set('database.default', $database);

        echo Hospital::query()
            ->whereNull('timezone_offset')
            ->count();

        $hospitals = Hospital::query()
            ->whereNull('timezone_offset')
            ->whereNotNull('H_State')
            ->orderBy('H_Created', 'desc')
            ->limit(1000)
            ->get();

        foreach ($hospitals as $hospital) {

            dump($hospital);

            $hospital->timezone_offset = Helper::timezones($hospital->H_State);
            $hospital->timestamps = false;
            $hospital->save();
        }

        echo Hospital::query()
            ->whereNull('timezone_offset')
            ->count();
    }
}
