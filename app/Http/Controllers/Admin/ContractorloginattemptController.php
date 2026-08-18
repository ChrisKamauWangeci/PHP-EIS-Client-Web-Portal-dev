<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contractorloginattempt;
use Illuminate\Http\Request;

class ContractorloginattemptController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Contractorloginattempt::query()
            ->when($filters['username'] ?? null, fn ($q, $v) => $q->where('username', 'LIKE', "%{$v}%"))
            ->when($filters['ip_address'] ?? null, fn ($q, $v) => $q->where('ip_address', 'LIKE', "%{$v}%"));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $contractorloginattempts = $query->paginate(200);

        return view('admin.contractorloginattempts.index', compact('contractorloginattempts', 'sort_direction'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Company $company)
    {
        //
    }

    public function edit(Company $company)
    {
        //
    }

    public function update(Company $company)
    {
        //
    }

    public function destroy(Company $company)
    {
        //
    }
}
