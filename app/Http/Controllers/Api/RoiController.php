<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoiRequest;
use App\Http\Requests\UpdateRoiRequest;
use App\Models\Roi;
use Illuminate\Http\Request;

class RoiController extends Controller
{
    public function index()
    {
        //
    }

    public function store(StoreRoiRequest $request)
    {
        //
    }

    public function show(Request $request)
    {
        $R_ROIname = $request->query('R_ROIname');

        $roi = Roi::query()
            ->select([
                'R_ROIname',
                'R_ID',
                'R_ContactName',
                'R_ContactEmail',
                'R_Address',
                'R_City',
                'R_State',
                'R_Zip',
                'R_Phone',
                'R_PhoneExt',
                'R_Fax',
                'R_Note',
                'R_UpdateDate',
                'R_UpdateBy',
            ])
            ->where('R_ROIname', $R_ROIname)
            ->first();

        return $roi;
    }

    public function update(UpdateRoiRequest $request, Roi $roi)
    {
        //
    }

    public function destroy(Roi $roi)
    {
        //
    }
}
