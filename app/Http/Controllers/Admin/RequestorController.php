<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequestorRequest;
use App\Http\Requests\UpdateRequestorRequest;
use App\Models\Company;
use App\Models\Requestor;
use App\Models\Requestorrole;
use App\Models\Websiteconfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RequestorController extends Controller
{
    public function __construct()
    {
        Gate::authorize('admin.requestors.index');
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'R_Company' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9- ]*$/',
            'R_Name' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9- ]*$/',
            'R_LoginEmail' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9 ]*$/',
            'R_Email' => 'nullable|email|max:50',
            'R_SuperUser' => 'nullable|in:0,1',
            'R_Active' => 'nullable|in:0,1',
            'sort_field' => 'nullable|string',
            'sort_direction' => 'nullable|string|in:asc,desc',
        ]);

        $query = Requestor::query()
            ->when($validated['R_Company'] ?? null, fn ($q, $v) => $q->where('R_Company', "{$v}"))
            ->when($validated['R_Name'] ?? null, fn ($q, $v) => $q->where('R_Name', 'like', "%{$v}%"))
            ->when($validated['R_LoginEmail'] ?? null, fn ($q, $v) => $q->where('R_LoginEmail', 'like', "%{$v}%"))
            ->when($validated['R_Email'] ?? null, fn ($q, $v) => $q->where('R_Email', 'like', "%{$v}%"))
            ->when(! is_null($validated['R_SuperUser'] ?? null), fn ($q) => $q->where('R_SuperUser', (int) $validated['R_SuperUser']))
            ->when(! is_null($validated['R_Active'] ?? null), fn ($q) => $q->where('R_Active', (int) $validated['R_Active']));

        $sort_field = $request->query('sort_field', 'R_Name');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $query->with('requestorrole');
        $query->with('websiteconfig');

        $requestors = $query->paginate(500);

        return view('admin.requestors.index', compact('requestors', 'sort_direction'));
    }

    public function create()
    {
        $companies = Company::query()
            ->orderBy('C_Name', 'asc')
            ->pluck('C_Name', 'C_Name')
            ->toArray();

        return view('admin.requestors.create', compact('companies'));
    }

    public function store(StoreRequestorRequest $request)
    {
        $requestor = new Requestor($request->validated());
        $requestor->save();

        return redirect()
            ->route('admin.requestors.show', $requestor->R_ID)
            ->with('success', 'Data has been saved');
    }

    public function show(Requestor $requestor)
    {
        return view('admin.requestors.show', compact('requestor'));
    }

    public function edit(Requestor $requestor)
    {
        $requestorroles = Requestorrole::query()
            ->where('company', $requestor->R_Company)
            ->pluck('name', 'id');
        $websiteconfigs = Websiteconfig::query()
            ->pluck('name', 'id');

        return view('admin.requestors.edit', compact('requestor', 'requestorroles', 'websiteconfigs'));
    }

    public function update(UpdateRequestorRequest $request, Requestor $requestor)
    {
        $requestor->update($request->validated());

        return redirect()
            ->route('admin.requestors.show', $requestor->R_ID)
            ->with('success', 'Data has been saved');
    }

    public function password(Request $request, Requestor $requestor)
    {
        if (! $requestor) {
            return redirect()
                ->route('admin.requestors.index')
                ->with('danger', 'Invalid Requestor');
        }

        return view('admin.requestors.password', compact('requestor'));
    }

    public function passwordupdate(Request $request, Requestor $requestor)
    {
        $request->validate([
            'R_ID' => 'required|integer|exists:Requestor,R_ID',
        ]);

        $requestor = Requestor::query()
            ->where('R_ID', $request->input('R_ID'))
            ->firstOrFail();

        $request->validate([
            'password' => [
                'required',
                'min:8',
                'max:20',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#\$%&*\?]).+$/',
                function ($attribute, $value, $fail) use ($requestor) {
                    if ($requestor && $value === $requestor->R_Password) {
                        $fail('The new password must be different from your current password.');
                    }
                },
                function ($attribute, $value, $fail) use ($requestor) {
                    if ($requestor && $value === $requestor->R_LastPW) {
                        $fail('The new password must be different from your previous password.');
                    }
                },
            ],
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number digit, and one special character (!@#$%&*?)',
        ]);

        if ($requestor) {
            $requestor->R_LastPW = $requestor->R_Password;
            $requestor->R_Password = $request->input('password');
            $requestor->R_PWDate = now();
            $requestor->save();

            return redirect()
                ->route('admin.requestors.show', $requestor->R_ID)
                ->with('success', 'The password has been changed successfully');
        }
    }

    public function destroy(Requestor $requestor)
    {
        //
    }
}
