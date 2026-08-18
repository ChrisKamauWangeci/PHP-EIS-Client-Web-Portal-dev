<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Docusigndocument;
use App\Services\DocusignService;
use Illuminate\Console\Command;

class Docusigndownload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:docusigndownload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'DocuSign - Download documents';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $docusignService = new DocusignService();

        $time30minutesago = now()->subMinutes(30)->format('Y-m-d H:i:s');

        $docusigndocuments = Docusigndocument::query()
            ->where('signingtype', 'embedded')
            ->where('status', 'envelope-delivered')
            ->where('created_at', '>', $time30minutesago)
            ->whereNotNull('envelopeid')
            ->whereNull('downloaded_at')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($docusigndocuments as $docusigndocument) {
            $docusigndocument = $docusignService->download($docusigndocument);
            sleep(3);
        }

        $docusigndocuments = Docusigndocument::query()
            ->where('signingtype', 'email')
            ->where('status', 'envelope-completed')
            ->where('signed_at', '>', $time30minutesago)
            ->whereNotNull('envelopeid')
            ->whereNull('downloaded_at')
            ->orderBy('signed_at', 'desc')
            ->get();

        foreach ($docusigndocuments as $docusigndocument) {
            $docusigndocument = $docusignService->download($docusigndocument);
            sleep(3);
        }

    }
}
