<?php

declare(strict_types=1);

namespace App\Services;

use GeoIp2\Database\Reader;
use Illuminate\Support\Facades\Log;

class GeoIpService
{
    private ?Reader $reader = null;

    private function getReader(): Reader
    {
        return $this->reader ??= new Reader(storage_path('app/GeoLite2-City.mmdb'));
    }

    public function lookup(?string $ipAddress): ?array
    {
        if (! $ipAddress || ! filter_var($ipAddress, FILTER_VALIDATE_IP)) {
            return null;
        }

        try {
            $record = $this->getReader()->city($ipAddress);

            return [
                'city' => $record->city->name ?? null,
                'region_iso' => $record->mostSpecificSubdivision->isoCode ?? null,
                'country_iso' => $record->country->isoCode ?? null,
            ];
        } catch (\Exception $e) {
            // Log::warning('GeoIP lookup failed', [
            //     'ip' => $ipAddress,
            //     'error' => $e->getMessage()
            // ]);
            return null;
        }
    }
}
