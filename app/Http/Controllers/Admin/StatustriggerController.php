<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statustrigger;
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
            ->when($filters['createdfrom'] ?? null, fn ($q, $v) => $q->where('Created', '>=', $v . ' 00:00:00'))
            ->when($filters['createdto'] ?? null, fn ($q, $v) => $q->where('Created', '<=', $v . ' 23:59:59'));

        $sort_field = $request->query('sort_field', 'Created');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $statustriggers = $query->paginate(200);

        return view('admin.statustriggers.index', compact('statustriggers', 'sort_direction'));
    }

    public function show(Statustrigger $statustrigger)
    {
        return view('admin.statustriggers.show', compact('statustrigger'));
    }
}
