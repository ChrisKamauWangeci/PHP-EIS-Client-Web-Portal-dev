<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Statustrigger;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatustriggerController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Statustrigger::query()
            ->when($filters['WorkOrderNo'] ?? null, fn ($q, $v) => $q->where('WorkOrderNo', $v))
            ->when($filters['laststatus'] ?? null, fn ($q, $v) => $q->where('laststatus', 'LIKE', "%{$v}%"))
            ->when($filters['CreatedBy'] ?? null, fn ($q, $v) => $q->where('CreatedBy', $v))
            ->when($filters['createdfrom'] ?? null, fn ($q, $v) => $q->where('Created', '>=', Carbon::parse($v)->startOfDay()))
            ->when($filters['createdto'] ?? null, fn ($q, $v) => $q->where('Created', '<', Carbon::parse($v)->addDay()->startOfDay()));

        $sort_field = $request->query('sort_field', 'Created');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $statustriggers = $query->paginate(200);

        return view('user.statustriggers.index', compact('statustriggers', 'sort_direction'));
    }

    public function show(Statustrigger $statustrigger)
    {
        return view('user.statustriggers.show', compact('statustrigger'));
    }
}
