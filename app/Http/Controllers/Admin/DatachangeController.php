<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDatachangeRequest;
use App\Http\Requests\UpdateDatachangeRequest;
use App\Models\Datachange;
use Illuminate\Http\Request;

class DatachangeController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Datachange::query()
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', $v))
            ->when($filters['model'] ?? null, fn ($q, $v) => $q->where('model', $v))
            ->when($filters['foreign_key'] ?? null, fn ($q, $v) => $q->where('foreign_key', $v))
            ->when($filters['data'] ?? null, fn ($q, $v) => $q->where('data', 'LIKE', "%{$v}%"))
            ->when($filters['created_by'] ?? null, fn ($q, $v) => $q->where('created_by', $v))
            ->when($filters['created_at_from'] ?? null, fn ($q, $v) => $q->where('created_at', '>=', $v . ' 00:00:00'))
            ->when($filters['created_at_to'] ?? null, fn ($q, $v) => $q->where('created_at', '<=', $v . ' 23:59:59'));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $datachanges = $query->paginate(200);

        return view('admin.datachanges.index', compact('datachanges', 'sort_direction'));
    }

    // public function create()
    // {
    //     //
    // }

    // public function store(StoreDatachangeRequest $request)
    // {
    //     //
    // }

    public function show(Datachange $datachange)
    {
        return view('admin.datachanges.show', compact('datachange'));
    }

    public function edit(Datachange $datachange)
    {
        return view('admin.datachanges.edit', compact('datachange'));
    }

    public function update(UpdateDatachangeRequest $request, Datachange $datachange)
    {
        $datachange->update($request->validated());

        return redirect()
            ->route('admin.datachanges.show', $datachange->id)
            ->with('success', 'Data has been saved');
    }

    // public function destroy(Datachange $datachange)
    // {
    //     //
    // }
}
