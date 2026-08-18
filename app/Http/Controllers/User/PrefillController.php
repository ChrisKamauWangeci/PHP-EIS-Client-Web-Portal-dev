<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Facilityform;
use App\Models\Prefill;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrefillController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Prefill::query()
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', $v))
            ->when($filters['slug'] ?? null, fn ($q, $v) => $q->where('slug', $v))
            ->when($filters['applicant'] ?? null, fn ($q, $v) => $q->where('applicant', 'LIKE', '%' . $v . '%'))
            ->when($filters['username'] ?? null, fn ($q, $v) => $q->where('username', 'LIKE', '%' . $v . '%'))
            ->when($filters['created_at_from'] ?? null, fn ($q, $v) => $q->where('created_at', '>=', Carbon::parse($v)->startOfDay()))
            ->when($filters['created_at_to'] ?? null, fn ($q, $v) => $q->where('created_at', '<', Carbon::parse($v)->addDay()->startOfDay()));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $prefills = $query->paginate(100);

        return view('user.prefills.index', compact('prefills', 'sort_direction'));
    }

    public function stats(Request $request)
    {
        $prefills = Prefill::query()
            ->select(DB::raw('count(*) as counter'), DB::raw('DATEPART(year, created_at) as year'), DB::raw('DATEPART(month, created_at) as month'))
            ->groupby(DB::raw('DATEPART(year, created_at)'), DB::raw('DATEPART(month, created_at)'))
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $prefillforms = Prefill::query()
            ->select(DB::raw('count(*) as counter'), 'slug')
            ->groupby('slug')
            ->orderBy('counter', 'desc')
            ->limit(200)
            ->get();

        // foreach ($prefillforms as $prefillform) {
        //     $facilityform = Facilityform::where('slug', $prefillform->slug)->first();
        //     if($facilityform) {
        //         $facilityform->usage_count = $prefillform->counter;
        //         $facilityform->save();
        //     }
        // }

        return view('user.prefills.stats', compact('prefills', 'prefillforms'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Prefill $prefill)
    {
        return view('user.prefills.show', compact('prefill'));
    }

    public function edit(Prefill $prefill)
    {
        //
    }

    public function update(Request $request, Prefill $prefill)
    {
        //
    }

    public function destroy(Prefill $prefill)
    {
        //
    }
}
