<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\DailyStatEmail;
use App\Services\DailyStatService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DailyStatReport extends Command
{
    protected $signature = 'app:dailystatreport {start?} {end?}';

    protected $description = 'Send Daily Stat Email';

    public function handle(DailyStatService $dailyStatService): void
    {
        config()->set('database.default', 'eis');

        $start = $this->argument('start') ? now()->parse($this->argument('start')) : now()->subDay()->startOfDay();
        $end = $this->argument('end') ? now()->parse($this->argument('end')) : now()->subDay()->endOfDay();

        $counts = $dailyStatService->calculateCounts($start->toDateString(), $end->toDateString());

        Mail::to('andras@expressimagingservices.com')->send(
            new DailyStatEmail($counts, $start->format('M d, Y (l)'), $end->format('M d, Y (l)'))
        );
    }
}
