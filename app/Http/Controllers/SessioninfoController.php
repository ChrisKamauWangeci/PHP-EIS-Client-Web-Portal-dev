<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class SessioninfoController extends Controller
{
    public function index()
    {
        echo '<pre>';
        print_r($_SESSION);
        print_r(session()->all());
        echo '</pre>';
        exit;
    }

    public function debug()
    {
        session(['user.debug' => ! session('user.debug')]);

        return back();
    }

    public function admindebug()
    {
        session(['admin.debug' => ! session('admin.debug')]);

        return back();
    }
}
