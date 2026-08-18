<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CompanyController extends Controller
{
    public function __construct()
    {
        Gate::authorize('admin.companies.index');
    }

    public function index(Request $request)
    {
        Gate::authorize('admin.companies.index');

        $validated = $request->validate([
            'C_Name' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9- ]*$/',
            'sort_field' => 'nullable|string',
            'sort_direction' => 'nullable|string|in:asc,desc',
        ]);

        $query = Company::query()
            ->when($validated['C_Name'] ?? null, fn ($q, $v) => $q->where('C_Name', 'LIKE', "%$v%"));

        $sort_field = $request->query('sort_field', 'C_Name');
        $sort_direction = $request->query('sort_direction', 'asc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $companies = $query->paginate(500);

        return view('admin.companies.index', compact('companies', 'sort_direction'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(StoreCompanyRequest $request)
    {
        $company = new Company($request->validated());
        $company->created_by = session('admin.contractor.C_Name');
        $company->save();

        return redirect()
            ->route('admin.companies.show', $company->id)
            ->with('success', 'Data has been saved');
    }

    public function show(Company $company)
    {
        return view('admin.companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->update($request->validated());

        return redirect()
            ->route('admin.companies.show', $company->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(Company $company)
    {
        //
    }
}
