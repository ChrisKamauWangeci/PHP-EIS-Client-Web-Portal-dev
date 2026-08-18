<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCopyserviceRequest;
use App\Http\Requests\UpdateCopyserviceRequest;
use App\Models\Copyservice;
use Illuminate\Http\Request;

class CopyserviceController extends Controller
{
    public function index()
    {
        //
    }

    public function store(StoreCopyserviceRequest $request)
    {
        //
    }

    public function show(Request $request)
    {
        $C_CopyService = $request->query('C_CopyService');
        $copyservice = Copyservice::query()
            ->where('C_CopyService', $C_CopyService)
            ->first();

        return $copyservice;
    }

    public function update(UpdateCopyserviceRequest $request, Copyservice $copyservice)
    {
        //
    }

    public function destroy(Copyservice $copyservice)
    {
        //
    }
}
