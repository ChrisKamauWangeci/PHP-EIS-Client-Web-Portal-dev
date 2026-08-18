<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    public function index(Request $request)
    {

        \Debugbar::disable();

        // header("Content-Type: image/png");

        // dd($request);
        $value = $request->query('value') ?? 11111;

        $data = QrCode::size(100)
            ->backgroundColor(255, 255, 255)
            ->color(0, 0, 0)
            ->margin(0)
            ->generate(
                $value
            );

        // dd($data);

        return response($data)
            ->header('Content-type', 'image/svg+xml');
    }
}
