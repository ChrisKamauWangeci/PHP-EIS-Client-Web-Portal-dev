<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Ehrstatustrigger;
use App\Models\Ehrworkorder;
use App\Models\Seqsterorder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class Seqsterorderprovider extends Command
{
    protected $signature = 'app:seqsterorderprovider';

    protected $description = 'Seqster Order - Provider';

    public function handle()
    {
        $this->info('start');
        $this->step1();
        $this->info('end');
    }

    public function step1()
    {
        $seqsterorders = Seqsterorder::query()
            ->where('seqster_at', '<', now()->subHours(24))
            ->where('seqster_at', '>', now()->subHours(72))
            ->whereNull('statusapi')
            ->whereNotNull('uuid')
            ->whereNotNull('access_token')
            ->whereNotNull('seqster_at')
            ->orderBy('seqster_at', 'asc')
            ->limit(50)
            ->get();

        $i = 0;

        foreach ($seqsterorders as $seqsterorder) {
            $i++;
            $this->info("Processing seqster order: {$seqsterorder->id} - {$seqsterorder->workorder_id} - {$i}/{$seqsterorders->count()}");
            $this->providers($seqsterorder);
            sleep(3);
        }
    }

    protected function resolveProviderUrl(Seqsterorder $order): ?string
    {
        $urls = [
            'USAA' => 'https://eis-usaa.seqster.com/api/partner/providers/connected/ehr',
            'EIS' => 'https://eis.seqster.com/api/partner/providers/connected/ehr',
            'NORTHWESTERN MUTUAL' => 'https://northwesternmutual.seqster.com/api/partner/providers/connected/ehr',
            'Prudential Insurance Company of America' => 'https://prudential.seqster.com/api/partner/providers/connected/ehr',
        ];

        return $urls[$order->company] ?? $urls[$order->project_title] ?? null;
    }

    public function providers(Seqsterorder $seqsterorder): void
    {
        $url = $this->resolveProviderUrl($seqsterorder);

        if (! $url) {
            $this->error("No provider URL for order {$seqsterorder->id}");

            return;
        }

        try {

            $response = Http::withToken($seqsterorder->access_token)->get($url);

            if ($response->failed()) {
                $this->error("API request failed for order {$seqsterorder->id}");

                return;
            }

            $data = $response->json();

            $directory = storage_path('persistent_logs/seqsterproviders/' . now()->format('Y-m-d'));
            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
            $file = $directory . '/seqsterprovider-' . now()->format('Ymd-His') . '-' . $seqsterorder->id . '-' . $seqsterorder->workorder_id . '.txt';
            $filedata = now()->format('Y-m-d H:i:s') . "\r\n" . print_r($data, true);
            @file_put_contents($file, $filedata);

            if (! isset($data['data']) || ! is_array($data['data'])) {
                $this->error("Invalid API response for order {$seqsterorder->id}");

                return;
            }

            $lines = [];

            foreach ($data['data'] as $d) {
                $displayName = $d['provider']['display_name'] ?? null;
                $integrationType = $d['integration_type'] ?? null;
                $lastImportRequestStatus = $d['last_import_request_status'] ?? null;

                if (! $displayName || ! $integrationType || ! $lastImportRequestStatus) {
                    continue;
                }

                $lines[] =
                    now()->format('m-d-Y') . ': 1003800773: ' .
                    $displayName .
                    ', integration type: ' . $integrationType .
                    ', status: ' . $lastImportRequestStatus .
                    ' (' . now()->format('g:i:s A') . ')';
            }

            $strfull = implode("\r\n", $lines);

            if ($strfull) {

                $ehrworkorder = Ehrworkorder::query()
                    ->where('W_WorkOrder', $seqsterorder->workorder_id)
                    ->first();

                if ($ehrworkorder) {
                    $ehrworkorder->W_Note = $ehrworkorder->W_Note . "\r\n" . $strfull;
                    $ehrworkorder->save();

                    // $statustrigger = new Ehrstatustrigger();
                    // $statustrigger->WorkOrderNo = $seqsterorder->workorder_id;
                    // $statustrigger->laststatus = $strfull;
                    // $statustrigger->Created = now();
                    // $statustrigger->statuscode = '1003800773';
                    // $statustrigger->CreatedBy = 'EHL Processing';
                    // $statustrigger->ChangeType = 'S';
                    // $statustrigger->save();

                }
            }

            $seqsterorder->statusapi = 'run1';
            $seqsterorder->seqster_providers_at = now();
            $seqsterorder->seqster_providers = $strfull;
            $seqsterorder->timestamps = false;
            $seqsterorder->save();
        } catch (\Throwable $th) {
            $seqsterorder->statusapi = 'run1';
            $seqsterorder->seqster_providers_at = now();
            $seqsterorder->timestamps = false;
            $seqsterorder->save();
        }
    }
}
