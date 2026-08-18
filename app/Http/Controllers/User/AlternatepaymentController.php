<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlternatepaymentRequest;
use App\Http\Requests\UpdateAlternatepaymentRequest;
use App\Models\Alternatepayment;
use App\Models\Hospital;
use Illuminate\Http\Request;

class AlternatepaymentController extends Controller
{
    public function index(Request $request)
    {
        $postname = trim($request->query('postname') ?? '') ?? null;

        $filters = $request->query();

        $query = Alternatepayment::query()
            ->when($filters['A_CopyService'] ?? null, fn ($q, $v) => $q->where('A_CopyService', 'LIKE', '%' . $v . '%'))
            ->when($filters['A_City'] ?? null, fn ($q, $v) => $q->where('A_City', 'LIKE', '%' . $v . '%'))
            ->when($filters['A_Zip'] ?? null, fn ($q, $v) => $q->where('A_Zip', 'LIKE', '%' . $v . '%'))
            ->when($filters['A_Phone'] ?? null, fn ($q, $v) => $q->where('A_Phone', 'LIKE', '%' . $v . '%'))
            ->when($filters['A_Fax'] ?? null, fn ($q, $v) => $q->where('A_Fax', 'LIKE', '%' . $v . '%'));

        $sort_field = $request->query('sort_field', 'A_CopyService');
        $sort_direction = $request->query('sort_direction', 'asc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $alternatepayments = $query->paginate(100);

        return view('user.alternatepayments.index', compact('alternatepayments', 'sort_direction', 'postname'));
    }

    public function create()
    {
        return view('user.alternatepayments.create');
    }

    public function store(StoreAlternatepaymentRequest $request)
    {
        $alternatepayment = new Alternatepayment($request->validated());
        $alternatepayment->A_UpdateBy = session('user.contractor.C_Name');
        $alternatepayment->save();

        return redirect()
            ->route('user.alternatepayments.show', $alternatepayment->A_ID)
            ->with('success', 'Data has been saved');
    }

    public function show(Alternatepayment $alternatepayment)
    {
        // $hospitals = Hospital::where('H_AlternatePayment', $alternatepayment->A_CopyService)->limit(100)->get();
        $hospitals = [];

        return view('user.alternatepayments.show', compact('alternatepayment', 'hospitals'));
    }

    public function edit(Alternatepayment $alternatepayment)
    {
        return view('user.alternatepayments.edit', compact('alternatepayment'));
    }

    public function update(UpdateAlternatepaymentRequest $request, Alternatepayment $alternatepayment)
    {
        $alternatepayment->update($request->validated() + [
            'A_UpdateBy' => session('user.contractor.C_Name'),
        ]);

        return redirect()
            ->route('user.alternatepayments.show', $alternatepayment->A_ID)
            ->with('success', 'Data has been saved');
    }

    public function destroy(Alternatepayment $alternatepayment)
    {
        //
    }
}
