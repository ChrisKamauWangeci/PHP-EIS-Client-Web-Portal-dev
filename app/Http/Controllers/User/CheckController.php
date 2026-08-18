<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Copyservice;
use App\Models\Hospital;
use App\Models\Workorder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function index(Request $request)
    {
        $workorder_id = $request->query('workorder_id') ?? '';
        $type = $request->query('type');

        if ($type == 'envelope') {

            $workorder = Workorder::where('W_WorkOrder', $workorder_id)->first();
            $hospital = Hospital::where('H_Hospital', $workorder->W_Hospital)->first();

            $data = [
                'workorder' => $workorder,
                'hospital' => $hospital,
            ];

            $pdf = Pdf::loadView('user/checks/pdf/envelope', $data)->setPaper('commercial #10 envelope');

            return $pdf->stream($workorder->W_WorkOrder . '-envelope.pdf');
        }

        if ($type == 'copyservice') {

            $workorder = Workorder::where('W_WorkOrder', $workorder_id)->first();
            $hospital = Hospital::where('H_Hospital', $workorder->W_Hospital)->first();
            $copyservice = Copyservice::where('C_CopyService', $hospital->H_CopyService)->first();

            $data = [
                'workorder' => $workorder,
                'hospital' => $hospital,
                'copyservice' => $copyservice,
            ];

            $pdf = Pdf::loadView('user/checks/pdf/copyservice', $data)->setPaper('commercial #10 envelope');

            return $pdf->stream($workorder->W_WorkOrder . '-copyservice.pdf');

        }

        if ($type == 'check') {

            $amount = $request->query('amount') ?? 9.95;

            $workorder = Workorder::where('W_WorkOrder', $workorder_id)->first();
            $hospital = Hospital::where('H_Hospital', $workorder->W_Hospital)->first();

            $data = [
                'workorder' => $workorder,
                'hospital' => $hospital,
                'amount' => $amount,
                'usersession' => session('user'),
            ];

            $pdf = Pdf::loadView('user/checks/pdf/check', $data)->setPaper('A4');

            return $pdf->stream($workorder->W_WorkOrder . '-check.pdf');

        }
    }
}
