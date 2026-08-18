<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContractorRequest;
use App\Http\Requests\UpdateContractorRequest;
use App\Models\Contractor;
use App\Models\Contractorlogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractorController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Contractor::query()
            ->when($filters['C_Name'] ?? null, fn ($q, $v) => $q->where('C_Name', 'LIKE', '%' . $v . '%'))
            ->when($filters['C_Email'] ?? null, fn ($q, $v) => $q->where('C_Email', 'LIKE', '%' . $v . '%'));

        $sort_field = $request->query('sort_field', 'C_Name');
        $sort_direction = $request->query('sort_direction', 'asc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $contractors = $query->paginate(200);

        return view('user.contractors.index', compact('contractors', 'sort_direction'));
    }

    public function create()
    {
        //
    }

    public function store(StoreContractorRequest $request)
    {
        //
    }

    public function show(Contractor $contractor)
    {
        return view('user.contractors.show', compact('contractor'));
    }

    public function edit(Request $request, Contractor $contractor)
    {

        if ($contractor->id != session('user.contractor.id')) {
            $request->session()->flash('danger', 'Invalid request');

            return redirect()
                ->route('user.contractors.index');
        }

        return view('user.contractors.edit', compact('contractor'));
    }

    public function update(UpdateContractorRequest $request, Contractor $contractor)
    {
        $contractor->update($request->validated());

        return redirect()
            ->route('user.contractors.show', $contractor->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(Contractor $contractor)
    {
        //
    }

    public function logout(Request $request)
    {
        $now = now();

        Contractorlogin::where('id', session('user.contractorlogin.id'))
            ->update([
                'time_on_site' => DB::raw("DATEDIFF(second, created_at, '{$now}')"),
                'logout_at' => $now,
                'updated_at' => $now,
            ]);

        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
