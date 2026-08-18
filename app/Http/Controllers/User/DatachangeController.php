<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Datachange;
use Carbon\Carbon;
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
            ->when($filters['data'] ?? null, fn ($q, $v) => $q->where('data', 'LIKE', '%' . $v . '%'))
            ->when($filters['created_by'] ?? null, fn ($q, $v) => $q->where('created_by', $v))
            ->when($filters['created_at_from'] ?? null, fn ($q, $v) => $q->where('created_at', '>=', Carbon::parse($v)->startOfDay()))
            ->when($filters['created_at_to'] ?? null, fn ($q, $v) => $q->where('created_at', '<', Carbon::parse($v)->addDay()->startOfDay()));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $datachanges = $query->paginate(100);

        return view('user.datachanges.index', compact('datachanges', 'sort_direction'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Datachange $datachange)
    {
        return view('user.datachanges.show', compact('datachange'));
    }

    public function edit(Datachange $datachange)
    {
        //
    }

    public function update(Request $request, Datachange $datachange)
    {
        //
    }

    public function destroy(Datachange $datachange)
    {
        //
    }
}
