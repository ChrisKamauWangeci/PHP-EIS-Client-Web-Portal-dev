<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyupdateRequest;
use App\Http\Requests\UpdateCompanyupdateRequest;
use App\Models\Companyupdate;
use Illuminate\Http\Request;

class CompanyupdateController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Companyupdate::query()
            ->when($filters['name'] ?? null, fn ($q, $v) => $q->where('name', 'LIKE', "%{$v}%"));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $companyupdates = $query->paginate(500);

        return view('admin.companyupdates.index', compact('companyupdates', 'sort_direction'));
    }

    public function create()
    {
        return view('admin.companyupdates.create');
    }

    public function store(StoreCompanyupdateRequest $request)
    {
        $companyupdate = new Companyupdate($request->validated());
        $companyupdate->save();

        return redirect()
            ->route('admin.companyupdates.show', $companyupdate->id)
            ->with('success', 'Data has been saved');
    }

    public function show(Companyupdate $companyupdate)
    {
        return view('admin.companyupdates.show', compact('companyupdate'));
    }

    public function edit(Companyupdate $companyupdate)
    {
        return view('admin.companyupdates.edit', compact('companyupdate'));
    }

    public function update(UpdateCompanyupdateRequest $request, Companyupdate $companyupdate)
    {
        $companyupdate->update($request->validated());

        return redirect()
            ->route('admin.companyupdates.show', $companyupdate->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(Companyupdate $companyupdate)
    {
        $companyupdate->contractor()->detach();
        $companyupdate->delete();

        return redirect()
            ->route('admin.companyupdates.index')
            ->with('success', 'Record has been deleted');
    }
}
