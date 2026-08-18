<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\DailyStatEmail;
use App\Services\DailyStatService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DailyStatRecord extends Command
{
    protected $signature = 'app:dailystatrecord {start?} {end?}';

    protected $description = 'Record daily stats; supports backfill for a date or range of dates';

    public function handle(DailyStatService $dailyStatService): void
    {
        config()->set('database.default', 'eis');

        $start = $this->argument('start') ? Carbon::parse($this->argument('start')) : now()->subDay();
        $end = $this->argument('end') ? Carbon::parse($this->argument('end')) : $start;

        $period = CarbonPeriod::create($start, $end);

        foreach ($period as $date) {
            $dateString = $date->toDateString();

            $counts = $dailyStatService->recordDailyMetrics($dateString);

            Mail::to('andras@expressimagingservices.com')->send(
                new DailyStatEmail($counts, $dateString, $dateString)
            );

            $this->info("Recorded daily stats for {$dateString}");
        }
    }
}
