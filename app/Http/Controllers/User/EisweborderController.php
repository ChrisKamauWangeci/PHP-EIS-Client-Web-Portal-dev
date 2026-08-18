<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Eisweborder;
use Illuminate\Http\Request;

class EisweborderController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Eisweborder::query();

        $query->when($filters['2'] ?? null, fn ($q, $v) => $q->where('2', $v));
        $query->when($filters['3'] ?? null, fn ($q, $v) => $q->where('3', $v));
        $query->when($filters['6'] ?? null, fn ($q, $v) => $q->where('6', $v));
        $query->when($filters['7'] ?? null, fn ($q, $v) => $q->where('7', $v));
        $query->when($filters['23'] ?? null, fn ($q, $v) => $q->where('23', $v));

        $sort_field = $request->query('sort_field', 'ID');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $eisweborders = $query->paginate(500);

        return view('user.eisweborders.index', compact('eisweborders', 'sort_direction'));
    }

    public function create()
    {
        //
    }

    public function store(StoreCompanyRequest $request)
    {
        //
    }

    public function show(Eisweborder $eisweborder)
    {
        return view('user.eisweborders.show', compact('eisweborder'));
    }

    public function edit(Eisweborder $eisweborder)
    {
        //
    }

    public function update(Eisweborder $eisweborder)
    {
        //
    }

    public function destroy(Eisweborder $eisweborder)
    {
        //
    }
}
