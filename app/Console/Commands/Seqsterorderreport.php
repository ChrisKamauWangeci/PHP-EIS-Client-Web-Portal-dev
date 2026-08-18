<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\SeqsterorderreportEmail;
use App\Models\Seqsterorder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class Seqsterorderreport extends Command
{
    protected $signature = 'app:seqsterorderreport';

    protected $description = 'Seqster Order - report of orders created in the last 24 hours';

    public function handle()
    {
        $seqsterorders = Seqsterorder::query()
            ->where('created', '>', now()->subDay(1))
            ->orderBy('created', 'asc')
            ->limit('500')
            ->get();

        $data['subject'] = 'Seqster report';
        $data['seqsterorders'] = $seqsterorders;

        Mail::to('andras@expressimagingservices.com')
            ->send(new SeqsterorderreportEmail($data));
    }
}
