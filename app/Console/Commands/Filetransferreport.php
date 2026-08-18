<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\FiletransferEmail;
use App\Models\Filetransfer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class Filetransferreport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:filetransferreport {database?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a report of file transfers created in the last 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $database = $this->argument('database') ?? 'eisuat';
        config()->set('database.default', $database);

        $filetransfers = Filetransfer::query()
            ->where('created_at', '>', now()->subDay(1))
            ->orderBy('contractor', 'ASC')
            ->orderBy('ip_address', 'ASC')
            ->orderBy('created_at', 'ASC')
            ->limit('5000')
            ->get();

        $data['subject'] = 'Filetransfers report ' . $database;
        $data['filetransfers'] = $filetransfers;

        Mail::to('andras@expressimagingservices.com')->send(new FiletransferEmail($data));
    }
}
