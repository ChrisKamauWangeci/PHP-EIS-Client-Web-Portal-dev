<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\FaxEmail;
use App\Models\Fax;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class Faxreport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:faxreport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a report of faxes created in the last 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $faxes = Fax::query()
            ->whereBetween('created_at', [
                now()->subDays(1)->startOfDay(),
                now()->subDays(1)->endOfDay(),
            ])
            ->orderBy('created_at', 'ASC')
            ->limit('5000')
            ->get();

        $data = [
            'view' => 'emails.faxreport',
            'subject' => 'Fax report',
            'faxes' => $faxes,
        ];

        Mail::to('andras@expressimagingservices.com')
            ->send(new FaxEmail($data));
    }
}
