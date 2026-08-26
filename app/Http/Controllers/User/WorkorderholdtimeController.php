<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Workorder;
use App\Models\Workorderholdtime;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkorderholdtimeController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Workorderholdtime::query()
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', $v))
            ->when($filters['reason'] ?? null, fn ($q, $v) => $q->where('reason', 'like', "%$v%"))
            ->when($filters['created_by'] ?? null, fn ($q, $v) => $q->where('created_by', $v))
            ->when($filters['date_start_from'] ?? null, fn ($q, $v) => $q->where('date_start', '>=', Carbon::parse($v)->startOfDay()))
            ->when($filters['date_start_to'] ?? null, fn ($q, $v) => $q->where('date_start', '<', Carbon::parse($v)->addDay()->startOfDay()))
            ->when($filters['date_end_from'] ?? null, fn ($q, $v) => $q->where('date_end', '>=', Carbon::parse($v)->startOfDay()))
            ->when($filters['date_end_to'] ?? null, fn ($q, $v) => $q->where('date_end', '<', Carbon::parse($v)->addDay()->startOfDay()));

        if (isset($filters['closed'])) {
            if ($filters['closed'] == '0') {
                $query->whereNull('date_end');
            } else {
                $query->whereNotNull('date_end');
            }
        }

        $sort_field = $request->query('sort_field', 'id');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $workorderholdtimes = $query->paginate(100);

        return view('user.workorderholdtimes.index', compact('workorderholdtimes', 'sort_direction'));
    }

    // public function create()
    // {
    //     //
    // }

    // public function store(Request $request)
    // {
    //     //
    // }

    public function detail(Request $request)
    {
        $request->validate([
            'workorder_id' => 'required|integer',
        ]);

        $workorder = Workorder::query()
            ->where('W_WorkOrder', $request->query('workorder_id'))
            ->firstOrFail();

        if ($request->ajax()) {
            view()->share('hideheader', true);
        }

        return view('user.workorderholdtimes.detail', compact('workorder'));
    }

    public function show(Workorderholdtime $workorderholdtime)
    {
        return view('user.workorderholdtimes.show', compact('workorderholdtime'));
    }

    // public function edit(Workorderholdtime $workorderholdtime)
    // {
    //     //
    // }

    // public function update(Request $request, Workorderholdtime $workorderholdtime)
    // {
    //     //
    // }

    // public function destroy(Workorderholdtime $workorderholdtime)
    // {
    //     //
    // }
}
