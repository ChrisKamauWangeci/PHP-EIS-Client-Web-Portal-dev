<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkorderpaymentRequest;
use App\Http\Requests\UpdateWorkorderpaymentRequest;
use App\Models\Workorder;
use App\Models\Workorderpayment;
use Illuminate\Http\Request;

class WorkorderpaymentController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Workorderpayment::query()
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', $v));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $workorderpayments = $query->paginate(100);

        return view('user.workorderpayments.index', compact('workorderpayments', 'sort_direction'));
    }

    public function create(Request $request)
    {
        $workorder_id = $request->query('workorder_id') ?? null;

        $workorder = Workorder::query()
            ->where('W_WorkOrder', $workorder_id)
            ->firstOrFail();

        return view('user.workorderpayments.create', compact('workorder'));
    }

    public function store(StoreWorkorderpaymentRequest $request)
    {
        $workorderpayment = new Workorderpayment($request->validated());
        $workorderpayment->created_by = session('user.contractor.C_Name');
        $workorderpayment->updated_by = session('user.contractor.C_Name');
        $workorderpayment->save();

        $totalamount = Workorderpayment::query()
            ->where('status', '!=', 'void')
            ->where('workorder_id', $workorderpayment->workorder_id)
            ->sum('amount');

        Workorder::query()
            ->where('W_WorkOrder', $workorderpayment->workorder_id)
            ->limit(1)
            ->update(['W_DrFee' => $totalamount]);

        return redirect()
            ->route('user.workorderpayments.index', ['workorder_id' => $workorderpayment->workorder_id])
            ->with('success', 'Data has been saved');
    }

    public function show(Workorderpayment $workorderpayment)
    {
        $workorder = Workorder::where('W_WorkOrder', $workorderpayment->workorder_id)->firstOrFail();

        return view('user.workorderpayments.show', compact('workorderpayment', 'workorder'));
    }

    public function edit(Workorderpayment $workorderpayment)
    {
        $workorder = Workorder::where('W_WorkOrder', $workorderpayment->workorder_id)->firstOrFail();

        return view('user.workorderpayments.edit', compact('workorderpayment', 'workorder'));
    }

    public function update(UpdateWorkorderpaymentRequest $request, Workorderpayment $workorderpayment)
    {
        $workorderpayment->update($request->validated() + [
            'updated_by' => session('user.contractor.C_Name'),
        ]);

        $totalamount = Workorderpayment::query()
            ->where('status', '!=', 'void')
            ->where('workorder_id', $workorderpayment->workorder_id)
            ->sum('amount');

        Workorder::query()
            ->where('W_WorkOrder', $workorderpayment->workorder_id)
            ->limit(1)
            ->update(['W_DrFee' => $totalamount]);

        return redirect()
            ->route('user.workorderpayments.show', $workorderpayment->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(Workorderpayment $workorderpayment)
    {
        //
    }
}
