<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Workorderholdtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkorderholdtimeController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Workorderholdtime::query()
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', $v))
            ->when($filters['reason'] ?? null, fn ($q, $v) => $q->where('reason', 'LIKE', "%{$v}%"))
            ->when($filters['date_start'] ?? null, fn ($q, $v) => $q->where('date_start', '=', $v))
            ->when($filters['date_end'] ?? null, fn ($q, $v) => $q->where('date_end', '=', $v))
            ->when($filters['created_by'] ?? null, fn ($q, $v) => $q->where('created_by', 'LIKE', "%{$v}%"))
            ->when($filters['modified_by'] ?? null, fn ($q, $v) => $q->where('modified_by', 'LIKE', "%{$v}%"));

        $sort_field = $request->query('sort_field', 'created');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $workorderholdtimes = $query->paginate(100);

        return view('admin.workorderholdtimes.index', compact('workorderholdtimes', 'sort_direction'));
    }

    public function stats(Request $request)
    {
        $workorderholdtimes = Workorderholdtime::query()
            ->select(DB::raw('count(*) as counter'), DB::raw('DATEPART(year, created) as year'), DB::raw('DATEPART(month, created) as month'))
            ->groupby(DB::raw('DATEPART(year, created)'), DB::raw('DATEPART(month, created)'))
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // dd($workorderholdtimes);

        return view('admin.workorderholdtimes.stats', compact('workorderholdtimes'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Workorderholdtime $workorderholdtime, Request $request)
    {
        return view('admin.workorderholdtimes.show', compact('workorderholdtime'));
    }

    public function edit(Workorderholdtime $workorderholdtime)
    {
        //
    }

    public function update(Request $request, Workorderholdtime $workorderholdtime)
    {
        //
    }

    public function destroy(Workorderholdtime $workorderholdtime)
    {
        //
    }
}
