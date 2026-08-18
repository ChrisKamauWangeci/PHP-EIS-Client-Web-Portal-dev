<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHospitalRequest;
use App\Http\Requests\UpdateHospitalRequest;
use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $hospitals = Hospital::query()
            ->when($filters['H_ID'] ?? null, fn ($q, $v) => $q->where('H_ID', $v))
            ->when($filters['H_Hospital'] ?? null, fn ($q, $v) => $q->where('H_Hospital', 'LIKE', '%' . $v . '%'))
            ->when($filters['H_Hospital2'] ?? null, fn ($q, $v) => $q->where('H_Hospital2', 'LIKE', '%' . $v . '%'))
            ->when($filters['H_Address'] ?? null, fn ($q, $v) => $q->where('H_Address', 'LIKE', '%' . $v . '%'))
            ->when($filters['H_City'] ?? null, fn ($q, $v) => $q->where('H_City', 'LIKE', '%' . $v . '%'))
            ->when($filters['H_State'] ?? null, fn ($q, $v) => $q->where('H_State', $v))
            ->when($filters['H_Zip'] ?? null, fn ($q, $v) => $q->where('H_Zip', $v))
            ->when($filters['H_Phone'] ?? null, fn ($q, $v) => $q->where('H_Phone', 'LIKE', '%' . $v . '%'))
            ->when($filters['H_Fax'] ?? null, fn ($q, $v) => $q->where('H_Fax', 'LIKE', '%' . $v . '%'))
            ->limit(30)
            ->get();

        foreach ($hospitals as $hospital) {
            $hospital->H_Note = nl2br($hospital->H_Note ?? '');
        }

        return $hospitals;
    }

    public function store(StoreHospitalRequest $request)
    {
        //
    }

    public function show(Hospital $hospital)
    {
        return $hospital;
    }

    public function update(UpdateHospitalRequest $request, Hospital $hospital)
    {
        //
    }

    public function destroy(Hospital $hospital)
    {
        //
    }
}
