<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $file = $request->query('file');
        $file = preg_replace('/[^a-zA-Z0-9-_ .\/\\\]/', '', $file);

        $download = (bool) $request->query('download');

        if (! is_file($file)) {
            $request->session()->flash('danger', 'Invalid request');

            return back();
        }

        if ($download) {
            return response()->download($file);
        }

        return response()->file($file);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Request $request)
    {
        return view('user.filetransfers.show', compact('filetransfer'));
    }

    public function edit(Request $request)
    {
        //
    }

    public function update(Request $request)
    {
        //
    }

    public function destroy(Filetransfer $filetransfer)
    {
        //
    }
}
