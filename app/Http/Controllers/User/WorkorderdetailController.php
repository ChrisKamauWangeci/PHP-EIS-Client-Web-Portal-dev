<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Requestorrole;
use App\Models\Workorder;
use App\Models\Workorderdetail;
use Illuminate\Http\Request;

class WorkorderdetailController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Workorderdetail::query()
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', $v));

        $sort_field = $request->query('sort_field', 'id');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $workorderdetails = $query->paginate(100);
        // dd($workorderdetails);

        return view('user.workorderdetails.index', compact('workorderdetails', 'sort_direction'));
    }

    public function create()
    {
        $validated = request()->validate([
            'workorder_id' => 'required|integer|min:1|max:99999999',
        ]);

        $workorder = Workorder::query()
            ->select('Workorder.*', 'Requestor.R_Company as requestor_company')
            ->where('W_WorkOrder', $validated['workorder_id'])
            ->join('Requestor', 'Workorder.W_Requestor', 'Requestor.R_Name')
            ->first();

        if (! $workorder) {
            return redirect()
                ->route('user.workorders.index')
                ->with('danger', 'Workorder not found.');
        }

        $requestorroles = Requestorrole::query()
            ->where('company', $workorder->requestor_company)
            ->orderBy('name', 'asc')
            ->pluck('name', 'role');

        $workorderdetails = Workorderdetail::query()
            ->where('workorder_id', $workorder->W_WorkOrder)
            ->get();

        return view('user.workorderdetails.create', compact('workorder', 'workorderdetails', 'requestorroles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'workorder_id' => 'required|exists:WorkOrder,W_WorkOrder',
            'requestorrole' => 'required|string',
        ]);

        $workorderdetail = Workorderdetail::create($data);

        return redirect()
            ->route('user.workorders.show', $workorderdetail->workorder_id);
    }

    public function show(Workorderdetail $workorderdetail)
    {
        return view('user.workorderdetails.show', compact('workorderdetail'));
    }

    public function edit(Workorderdetail $workorderdetail)
    {
        //
    }

    public function update(Request $request, Workorderdetail $workorderdetail)
    {
        //
    }

    public function destroy(Workorderdetail $workorderdetail)
    {
        //
    }
}
