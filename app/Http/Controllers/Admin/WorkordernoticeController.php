<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkordernoticeRequest;
use App\Http\Requests\UpdateWorkordernoticeRequest;
use App\Models\Workordernotice;
use Illuminate\Http\Request;

class WorkordernoticeController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Workordernotice::query()
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', $v))
            ->when($filters['recipient'] ?? null, fn ($q, $v) => $q->where('recipient', 'LIKE', "%{$v}%"));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $workordernotices = $query->paginate(500);

        return view('admin.workordernotices.index', compact('workordernotices', 'sort_direction'));
    }

    public function create()
    {
        return view('admin.workordernotices.create');
    }

    public function store(StoreWorkordernoticeRequest $request)
    {
        $workordernotice = new Workordernotice($request->validated());
        $workordernotice->created_by = session('admin.contractor.C_Name');
        $workordernotice->updated_by = session('admin.contractor.C_Name');
        $workordernotice->save();

        return redirect()
            ->route('admin.workordernotices.show', $workordernotice->id)
            ->with('success', 'Data has been saved');
    }

    public function show(Workordernotice $workordernotice)
    {
        return view('admin.workordernotices.show', compact('workordernotice'));
    }

    public function edit(Workordernotice $workordernotice)
    {
        return view('admin.workordernotices.edit', compact('workordernotice'));
    }

    public function update(UpdateWorkordernoticeRequest $request, Workordernotice $workordernotice)
    {
        $workordernotice->update($request->validated());

        return redirect()
            ->route('admin.workordernotices.show', $workordernotice->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(Workordernotice $workordernotice)
    {
        //
    }
}
