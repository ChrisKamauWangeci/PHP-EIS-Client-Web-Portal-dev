<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Contractorloginattempt;
use App\Models\Contractorloginip;
use App\Models\RequestorPasswordChange;
use App\Services\GeoIpService;
use Illuminate\Console\Command;

class Iplookup extends Command
{
    protected $signature = 'app:iplookup {database?}';

    protected $description = 'Lookup IP addresses for requestor password changes';

    public function __construct(private GeoIpService $geoIpService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $database = $this->argument('database') ?? 'eisuat';

        $requestorPasswordChanges = RequestorPasswordChange::on($database)
            ->select('id', 'ip_address')
            ->where('created_at', '>=', now()->subHours(24))
            ->whereNull('country_iso')
            ->orderBy('created_at', 'desc')
            ->limit(200)
            ->get();

        foreach ($requestorPasswordChanges as $requestorPasswordChange) {
            $this->updateRequestorPasswordChange($requestorPasswordChange);
        }

        $contractorLoginAttempts = Contractorloginattempt::on($database)
            ->select('id', 'ip_address')
            ->where('created_at', '>=', now()->subHours(24))
            ->whereNull('country_code')
            ->orderBy('created_at', 'desc')
            ->limit(200)
            ->get();

        foreach ($contractorLoginAttempts as $contractorLoginAttempt) {
            $this->updateContractorLoginAttempt($contractorLoginAttempt);
        }

        $contractorLoginIps = Contractorloginip::on($database)
            ->select('id', 'ip_address')
            ->where('created_at', '>=', now()->subHours(24))
            ->whereNull('country_code')
            ->orderBy('created_at', 'desc')
            ->limit(200)
            ->get();

        foreach ($contractorLoginIps as $contractorLoginIp) {
            $this->updateContractorLoginIp($contractorLoginIp);
        }
    }

    protected function updateRequestorPasswordChange(RequestorPasswordChange $requestorPasswordChange): void
    {
        $geoData = $this->geoIpService->lookup($requestorPasswordChange->ip_address);

        if ($geoData) {
            $requestorPasswordChange->update([
                'city' => $geoData['city'] ?? null,
                'region_iso' => $geoData['region_iso'] ?? null,
                'country_iso' => $geoData['country_iso'] ?? null,
            ]);
        }
    }

    protected function updateContractorLoginAttempt(Contractorloginattempt $contractorLoginAttempt): void
    {
        $geoData = $this->geoIpService->lookup($contractorLoginAttempt->ip_address);

        if ($geoData) {
            $contractorLoginAttempt->update([
                'city' => $geoData['city'] ?? null,
                'region' => $geoData['region_iso'] ?? null,
                'country_code' => $geoData['country_iso'] ?? null,
            ]);
        }
    }

    protected function updateContractorLoginIp(Contractorloginip $contractorLoginIp): void
    {
        $geoData = $this->geoIpService->lookup($contractorLoginIp->ip_address);

        if ($geoData) {
            $contractorLoginIp->update([
                'city' => $geoData['city'] ?? null,
                'region' => $geoData['region_iso'] ?? null,
                'country_code' => $geoData['country_iso'] ?? null,
            ]);
        }
    }
}
