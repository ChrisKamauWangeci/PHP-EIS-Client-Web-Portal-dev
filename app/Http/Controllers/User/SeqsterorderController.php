<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeqsterorderRequest;
use App\Http\Requests\UpdateSeqsterorderRequest;
use App\Models\Seqsterorder;
use App\Services\SeqsterEmailService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeqsterorderController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'project_title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'workorder_id' => 'nullable|integer',
            'patient_id' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'createdfrom' => 'nullable|date_format:Y-m-d',
            'createdto' => 'nullable|date_format:Y-m-d',
        ]);

        $query = Seqsterorder::query()
            ->when($validated['project_title'] ?? null, fn ($q, $v) => $q->where('project_title', 'LIKE', "%{$v}%"))
            ->when($validated['company'] ?? null, fn ($q, $v) => $q->where('company', $v))
            ->when($validated['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', $v))
            ->when($validated['patient_id'] ?? null, fn ($q, $v) => $q->where('patient_id', $v))
            ->when($validated['status'] ?? null, fn ($q, $v) => $q->where('status', 'LIKE', "%{$v}%"))
            ->when($validated['first_name'] ?? null, fn ($q, $v) => $q->where('first_name', 'LIKE', "%{$v}%"))
            ->when($validated['last_name'] ?? null, fn ($q, $v) => $q->where('last_name', 'LIKE', "%{$v}%"))
            ->when($validated['email'] ?? null, fn ($q, $v) => $q->where('email', 'LIKE', "%{$v}%"))
            ->when($validated['createdfrom'] ?? null, fn ($q, $v) => $q->where('created', '>=', Carbon::parse($v)->startOfDay()))
            ->when($validated['createdto'] ?? null, fn ($q, $v) => $q->where('created', '<', Carbon::parse($v)->addDay()->startOfDay()));

        $sort_field = $request->query('sort_field', 'created');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $seqsterorders = $query->paginate(500);

        return view('user.seqsterorders.index', compact('seqsterorders', 'sort_direction'));
    }

    public function sendemail(int $id, SeqsterEmailService $seqsteremailservice)
    {
        $result = $seqsteremailservice->sendById($id);

        return redirect()
            ->route('user.seqsterorders.show', $id)
            ->with('success', 'Data has been saved');

    }

    public function stats(Request $request)
    {
        $seqsterorders = Seqsterorder::select(DB::raw('count(*) as counter'), DB::raw('DATEPART(year, created) as year'), DB::raw('DATEPART(month, created) as month'))
            ->groupby(DB::raw('DATEPART(year, created)'), DB::raw('DATEPART(month, created)'))
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return view('user.seqsterorders.stats', compact('seqsterorders'));
    }

    public function create()
    {
        return view('user.seqsterorders.create');
    }

    public function store(StoreSeqsterorderRequest $request)
    {
        $seqsterorder = new Seqsterorder($request->validated());
        $seqsterorder->save();

        return redirect()
            ->route('user.seqsterorders.show', $seqsterorder->id)
            ->with('success', 'Data has been saved');
    }

    public function show(Seqsterorder $seqsterorder)
    {
        return view('user.seqsterorders.show', compact('seqsterorder'));
    }

    public function edit(Seqsterorder $seqsterorder)
    {
        return view('user.seqsterorders.edit', compact('seqsterorder'));
    }

    public function update(UpdateSeqsterorderRequest $request, Seqsterorder $seqsterorder)
    {
        $seqsterorder->update($request->validated());

        return redirect()
            ->route('user.seqsterorders.show', $seqsterorder->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(Seqsterorder $seqsterorder)
    {
        //
    }
}
