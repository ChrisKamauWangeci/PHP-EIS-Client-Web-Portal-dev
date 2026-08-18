<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getConnectionName()
    {
        $host = Request::getHost();
        $parts = explode('.', $host);
        $subdomain = count($parts) > 1 ? $parts[0] : $host;

        if ($subdomain == 'www' || $subdomain == 'eis' || $subdomain == 'usaa' || $subdomain == 'nyl') {
            return 'eis';
        }

        return 'eisuat';
    }
}
