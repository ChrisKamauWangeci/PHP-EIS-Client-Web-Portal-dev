<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contractorloginip;
use Illuminate\Http\Request;

class ContractorloginipController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Contractorloginip::query()
            ->when($filters['ip_address'] ?? null, fn ($q, $v) => $q->where('ip_address', $v))
            ->when($filters['contractor_first'] ?? null, fn ($q, $v) => $q->where('contractor_first', $v))
            ->when($filters['contractor_last'] ?? null, fn ($q, $v) => $q->where('contractor_last', $v));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $contractorloginips = $query->paginate(200);

        return view('admin.contractorloginips.index', compact('contractorloginips', 'sort_direction'));
    }
}
