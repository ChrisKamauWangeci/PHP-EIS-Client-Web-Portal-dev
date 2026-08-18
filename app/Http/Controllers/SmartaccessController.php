<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ehrorder;

class SmartaccessController extends Controller
{
    public function index(Request $request)
    {
        $ehrorder = Ehrorder::query()
            ->where('service_provider', 'fasten_health')
            ->inRandomOrder()
            ->first();

        return view('emails.smartaccess', ['ehrorder' => $ehrorder]);
    }
}
