<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Ehrorder;
use App\Services\EhrorderCoverpageService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class EhrorderGenerateCoverpage extends Command
{
    protected $signature = 'app:ehrordereneratecoverpage {database?}';

    protected $description = 'Generate coverpage/auth PDFs for recent EHR orders';

    public function handle(EhrorderCoverpageService $ehrorderCoverpageService): int
    {
        $database = $this->argument('database') ?? 'eisuat';
        config()->set('database.default', $database);

        $ehrorders = Ehrorder::query()
            ->where('service_provider', 'epic')
            ->whereNull('status')
            ->whereNull('submitted_at')
            ->where('created_at', '>=', now()->subMinutes(15))
            ->get();

        if ($ehrorders->isEmpty()) {
            $this->info('No recent ehrorders found.');

            return self::SUCCESS;
        }

        foreach ($ehrorders as $ehrorder) {

            $directory = '\\\\ftpserver2\\ftpserver\\eis\\coverpage_auth\\' . $ehrorder->created_at->format('Ymd') . '\\';
            $mergedPath = $directory . $ehrorder->id . '-coverpage_auth.pdf';

            if(is_file($mergedPath)) {
                $this->info('Merged PDF already exists for Ehrorder ID: ' . $ehrorder->id);
                continue;
            }

            try {
                $ehrorderCoverpageService->generate($ehrorder);

                $this->info(
                    'Generated PDF for Ehrorder ID: ' . $ehrorder->id
                );
            } catch (\Throwable $e) {
                $this->error(
                    'Failed for Ehrorder ID: '
                    . $ehrorder->id
                    . ' - '
                    . $e->getMessage()
                );
            }

            $ehrorder->status = 'coverpage_generated';
            $ehrorder->uuid = (string) Str::uuid();
            $ehrorder->save();

        }

        return self::SUCCESS;
    }
}