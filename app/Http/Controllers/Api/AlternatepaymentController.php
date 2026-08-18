<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlternatepaymentRequest;
use App\Http\Requests\UpdateAlternatepaymentRequest;
use App\Models\Alternatepayment;
use Illuminate\Http\Request;

class AlternatepaymentController extends Controller
{
    public function index()
    {
        //
    }

    public function store(StoreAlternatepaymentRequest $request)
    {
        //
    }

    public function show(Request $request)
    {
        $A_CopyService = $request->query('A_CopyService');

        $alternatepayment = Alternatepayment::query()
            ->select([
                'A_CopyService',
                'A_ID',
                'A_ContactName',
                'A_ContactEmail',
                'A_Address',
                'A_City',
                'A_State',
                'A_Zip',
                'A_Phone',
                'A_PhoneExt',
                'A_Fax',
                'A_Note',
                'A_UpdateDate',
                'A_UpdateBy',
            ])
            ->where('A_CopyService', $A_CopyService)
            ->first();

        return $alternatepayment;
    }

    public function update(UpdateAlternatepaymentRequest $request, Alternatepayment $alternatepayment)
    {
        //
    }

    public function destroy(Alternatepayment $alternatepayment)
    {
        //
    }
}
