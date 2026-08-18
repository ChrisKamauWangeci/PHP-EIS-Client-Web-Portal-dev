<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHospitalrawRequest;
use App\Http\Requests\UpdateHospitalrawRequest;
use App\Models\Hospitalraw;

class HospitalrawController extends Controller
{
    public function index()
    {
        //
    }

    public function store(StoreHospitalrawRequest $request)
    {
        //
    }

    public function show(Hospitalraw $hospitalraw)
    {
        return $hospitalraw;
    }

    public function update(UpdateHospitalrawRequest $request, Hospitalraw $hospitalraw)
    {
        //
    }

    public function destroy(Hospitalraw $hospitalraw)
    {
        //
    }
}
