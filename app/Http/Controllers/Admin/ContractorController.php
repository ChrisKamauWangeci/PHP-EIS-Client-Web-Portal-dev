<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContractorRequest;
use App\Http\Requests\UpdateContractorRequest;
use App\Models\Contractor;
use App\Models\ContractorAdmin;
use App\Models\Workorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class ContractorController extends Controller
{
    public function __construct()
    {
        Gate::authorize('admin.contractors.index');
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'C_Name' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9 ]*$/',
            'C_Email' => 'nullable|string|max:50',
            'C_Location' => 'nullable|string|max:50',
            'C_SysAdmin' => 'nullable|in:0,1',
            'accesslevel' => 'nullable|in:0,1',
            'C_Caller' => 'nullable|in:0,1',
            'is_active' => 'nullable|in:0,1',
            'sort_field' => 'nullable|string',
            'sort_direction' => 'nullable|string|in:asc,desc',
        ]);

        $query = Contractor::query()
            ->when($validated['C_Name'] ?? null, fn ($q, $v) => $q->where('C_Name', 'LIKE', "%{$v}%"))
            ->when($validated['C_Email'] ?? null, fn ($q, $v) => $q->where('C_Email', 'LIKE', "%{$v}%"))
            ->when($validated['C_Location'] ?? null, fn ($q, $v) => $q->where('C_Location', 'LIKE', "%{$v}%"))
            ->when(! is_null($validated['C_SysAdmin'] ?? null), fn ($q) => $q->where('C_SysAdmin', (int) $validated['C_SysAdmin']))
            ->when(! is_null($validated['accesslevel'] ?? null), fn ($q) => $q->where('accesslevel', (int) $validated['accesslevel']))
            ->when(! is_null($validated['C_Caller'] ?? null), fn ($q) => $q->where('C_Caller', (int) $validated['C_Caller']))
            ->when(! is_null($validated['is_active'] ?? null), fn ($q) => $q->where('is_active', (int) $validated['is_active']));

        $sort_field = $request->query('sort_field', 'C_Name');
        $sort_direction = $request->query('sort_direction', 'asc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $contractors = $query->paginate(500);

        return view('admin.contractors.index', compact('contractors', 'sort_direction'));
    }

    public function create()
    {
        return view('admin.contractors.create');
    }

    public function store(StoreContractorRequest $request)
    {
        $contractor = new Contractor($request->validated());
        $contractor->save();

        return redirect()
            ->route('admin.contractors.show', $contractor->id)
            ->with('success', 'Data has been saved');
    }

    public function show(ContractorAdmin $contractor)
    {
        $workordersownercount = Workorder::query()
            ->where('W_Owner', $contractor->C_Name)
            ->count();
        $workorderscontractorcount = Workorder::query()
            ->where('W_Contractor', $contractor->C_Name)
            ->count();

        return view('admin.contractors.show', compact('contractor', 'workordersownercount', 'workorderscontractorcount'));
    }

    public function edit(ContractorAdmin $contractor)
    {
        $roles = Role::where('guard_name', 'admin')->get();

        return view('admin.contractors.edit', compact('contractor', 'roles'));
    }

    public function update(UpdateContractorRequest $request, ContractorAdmin $contractor)
    {
        $contractor->update($request->validated());

        if ($request->role) {
            $contractor->syncRoles([$request->role]);
        } else {
            $contractor->syncRoles([]);
        }

        return redirect()
            ->route('admin.contractors.show', $contractor->id)
            ->with('success', 'Data has been saved');
    }

    public function resetcompanyupdates()
    {
        Contractor::query()->update([
            'company_updates' => 1,
        ], ['timestamps' => false]);

        return redirect()
            ->route('admin.companyupdates.index')
            ->with('success', 'Data has been saved');
    }

    public function password(Request $request, Contractor $contractor)
    {
        if (! $contractor) {
            return redirect()
                ->route('admin.contractors.index')
                ->with('danger', 'Contractor not found');
        }

        return view('admin.contractors.password', compact('contractor'));
    }

    public function passwordupdate(Request $request, Contractor $contractor)
    {
        $request->validate([
            'id' => 'required|integer|exists:Contractor,id',
        ]);

        $contractor = Contractor::where('id', $request->input('id'))->firstOrFail();

        $request->validate([
            'password' => [
                'required',
                'min:8',
                'max:20',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#\$%&*\?]).+$/',
                function ($attribute, $value, $fail) use ($contractor) {
                    if ($contractor && $value === $contractor->C_Password) {
                        $fail('The new password must be different from your current password.');
                    }
                },
            ],
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number digit, and one special character (!@#$%&*?)',
        ]);

        if ($contractor) {
            $contractor->C_Password = $request->input('password');
            $contractor->password_changed = now();
            $contractor->save();

            return redirect()
                ->route('admin.contractors.show', $contractor->id)
                ->with('success', 'The password has been changed successfully');
        }
    }

    // public function destroy(Contractor $contractor)
    // {
    //     $workordersownercount = Workorder::query()
    //         ->where('W_Owner', $contractor->C_Name)
    //         ->count();
    //     $workorderscontractorcount = Workorder::query()
    //         ->where('W_Contractor', $contractor->C_Name)
    //         ->count();

    //     if ($workordersownercount || $workorderscontractorcount) {
    //         return back()
    //             ->with('danger', 'The data could not be saved. Please, try again');
    //     }

    //     $contractor->delete();

    //     return redirect()
    //         ->route('admin.contractors.index')
    //         ->with('success', 'Data has been deleted');
    // }
}
