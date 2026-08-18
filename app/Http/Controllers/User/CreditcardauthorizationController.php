<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Creditcard;
use App\Models\Hospital;
use App\Models\Workorder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreditcardauthorizationController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $workorder_id = $request->query('workorder_id') ?? null;
        $workorder = Workorder::query()
            ->where('W_WorkOrder', $workorder_id)
            ->firstOrFail();

        $creditcards1 = Creditcard::query()
            ->select(
                DB::raw("CONCAT(CC_No, ' - ', ExpDate, ' - ', CC_Name) AS name"),
                'id'
            )
            ->orderBy('CC_Name', 'ASC')
            ->get();
        $creditcards = $creditcards1->pluck('name', 'id');

        return view('user.creditcardauthorizations.create', compact('workorder', 'creditcards'));
    }

    public function store(Request $request)
    {
        $workorder_id = intval($request->input('workorder_id'));
        $workorder = Workorder::query()
            ->where('W_WorkOrder', $workorder_id)
            ->firstOrFail();
        // dump($workorder);

        $hospital = Hospital::query()
            ->where('H_Hospital', $workorder->W_Hospital)
            ->firstOrFail();

        $dr_fee = $request->input('dr_fee') ?? 0;
        $dr_fee = sprintf('%0.2f', $dr_fee);

        $card = intval($request->input('card'));
        $creditcard = Creditcard::findOrFail($card);
        // dump($creditcard);
        // dd();

        $filename = $workorder_id . '-' . date('Ymd-Hi') . '-creditcardauthorization.pdf';

        $file = '\\\\ftpserver\\ftpserver\\NoteFile\\additionalrequests\\' . $this->subdomain() . '\\' . $filename;

        // dd($file);

        $data = [
            'workorder' => $workorder,
            'hospital' => $hospital,
            'creditcard' => $creditcard,
            'dr_fee' => $dr_fee,
            'userinfo' => session('user'),
        ];

        $pdf = Pdf::loadView('user/creditcardauthorizations/pdf/creditcardauthorization', $data);
        // return $pdf->stream(basename($file));
        $pdf->save($file);

        return redirect()
            ->route('user.workorderfiles.show', $workorder->W_WorkOrder)
            ->with('success', 'Data has been saved');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, Workorder $workorder)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
