<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Addonorder;
use App\Models\Workorder;
use Illuminate\Http\Request;

class AddonorderController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Addonorder::query()
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', $v));

        $sort_field = $request->query('sort_field', 'id');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $addonorders = $query->paginate(100);

        return view('user.addonorders.index', compact('addonorders', 'sort_direction'));
    }

    public function create()
    {
        $validated = request()->validate([
            'workorder_id' => 'required|integer|min:1|max:99999999',
        ]);

        $workorder = Workorder::query()
            ->where('W_WorkOrder', $validated['workorder_id'])
            ->first();

        if (! $workorder) {
            return redirect()
                ->route('user.workorders.index')
                ->with('danger', 'Workorder not found.');
        }

        $addonorders = Addonorder::query()
            ->where('workorder_id', $workorder->W_WorkOrder)
            ->get();

        return view('user.addonorders.create', compact('workorder', 'addonorders'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'workorder_id' => 'required|exists:WorkOrder,W_WorkOrder',
            'newordertype' => 'required|string',
            'gender' => 'nullable|string|in:M,F',
        ]);

        $workorder = Workorder::query()
            ->select([
                'Workorder.W_WorkOrder',
                'Workorder.W_FirstName',
                'Workorder.W_LastName',
                'Workorder.W_Gender',
                'Requestor.R_Company as requestor_company',
            ])
            ->join('Requestor', 'Requestor.R_Name', '=', 'Workorder.W_Requestor')
            ->where('W_WorkOrder', $data['workorder_id'])
            ->firstOrFail();

        $data['company'] = $workorder->requestor_company;
        $data['applicant'] = $workorder->W_LastName . ', ' . $workorder->W_FirstName;
        $data['requestor'] = session('user.contractor.C_Name');
        $data['created'] = now();

        $addonorder = Addonorder::create($data);

        return redirect()
            ->route('user.addonorders.show', $addonorder);
    }

    public function show(Addonorder $addonorder)
    {
        return view('user.addonorders.show', compact('addonorder'));
    }

    public function edit(Addonorder $addonorder)
    {
        //
    }

    public function update(Request $request, Addonorder $addonorder)
    {
        //
    }

    public function destroy(Addonorder $addonorder)
    {
        //
    }
}
