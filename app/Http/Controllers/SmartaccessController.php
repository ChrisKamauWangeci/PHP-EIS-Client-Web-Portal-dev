<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Ehrorder;
use Illuminate\Http\Request;

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
