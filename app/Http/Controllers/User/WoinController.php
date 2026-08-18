<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Woin;
use Illuminate\Http\Request;

class WoinController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Woin::query()
            ->when($filters['WI_WorkOrder'] ?? null, fn ($q, $v) => $q->where('WI_WorkOrder', $v));

        $sort_field = $request->query('sort_field', 'WI_WorkOrder');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $woins = $query->paginate(100);

        return view('user.woins.index', compact('woins', 'sort_direction'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

    }

    public function show(Woin $woin)
    {
        return view('user.woins.show', compact('woin'));
    }

    public function edit(Woin $woin)
    {
        //
    }

    public function update(Request $request, Woin $woin)
    {
        //
    }

    public function destroy(Woin $woin)
    {
        //
    }
}
