<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInsurancecompanyRequest;
use App\Http\Requests\UpdateInsurancecompanyRequest;
use App\Models\Insurancecompany;
use Illuminate\Http\Request;

class InsurancecompanyController extends Controller
{
    public function index(Request $request)
    {
        $postname = trim($request->query('postname') ?? '') ?? null;

        $filters = $request->query();

        $query = Insurancecompany::query()
            ->when($filters['I_Name'] ?? null, fn ($q, $v) => $q->where('I_Name', 'LIKE', '%' . $v . '%'));

        $sort_field = $request->query('sort_field', 'I_Name');
        $sort_direction = $request->query('sort_direction', 'asc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $insurancecompanies = $query->paginate(300);

        return view('user.insurancecompanies.index', compact('insurancecompanies', 'sort_direction', 'postname'));
    }

    // public function create()
    // {
    //     return view('user.insurancecompanies.create');
    // }

    // public function store(StoreInsurancecompanyRequest $request)
    // {
    //     $insurancecompany = new Insurancecompany($request->validated());
    //     $insurancecompany->A_UpdateBy = session('user.contractor.C_Name');
    //     $insurancecompany->save();
    //     return redirect()
    //         ->route('user.insurancecompanies.show', $insurancecompany->A_ID)
    //         ->with('success', 'Data has been saved');
    // }

    public function show(Insurancecompany $insurancecompany)
    {
        return view('user.insurancecompanies.show', compact('insurancecompany'));
    }

    // public function edit(Insurancecompany $insurancecompany)
    // {
    //     return view('user.insurancecompanies.edit', compact('insurancecompany'));
    // }

    // public function update(UpdateInsurancecompanyRequest $request, Insurancecompany $insurancecompany)
    // {
    //     $insurancecompany->update($request->validated() + [
    //         'A_UpdateBy' => session('user.contractor.C_Name'),
    //     ]);
    //     return redirect()
    //         ->route('user.insurancecompanies.show', $insurancecompany->A_ID)
    //         ->with('success', 'Data has been saved');
    // }

    // public function destroy(Insurancecompany $insurancecompany)
    // {
    //     //
    // }
}
