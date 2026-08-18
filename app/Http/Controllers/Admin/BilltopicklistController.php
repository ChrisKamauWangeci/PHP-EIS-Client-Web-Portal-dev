<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Billtopicklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BilltopicklistController extends Controller
{
    public function __construct()
    {
        Gate::authorize('admin.billtopicklists.index');
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'BL_BillTo' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9 ]*$/',
            'BL_InsCompany' => 'nullable|string|max:50',
            'sort_field' => 'nullable|string',
            'sort_direction' => 'nullable|string|in:asc,desc',
        ]);

        $query = Billtopicklist::query()
            ->when($validated['BL_BillTo'] ?? null, fn ($q, $v) => $q->where('BL_BillTo', 'LIKE', "%{$v}%"))
            ->when($validated['BL_InsCompany'] ?? null, fn ($q, $v) => $q->where('BL_InsCompany', 'LIKE', "%{$v}%"));

        $sort_field = $request->query('sort_field', 'BL_BillTo');
        $sort_direction = $request->query('sort_direction', 'asc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $billtopicklists = $query->paginate(200);

        return view('admin.billtopicklists.index', compact('billtopicklists', 'sort_direction'));
    }

    public function create()
    {
        return view('admin.billtopicklists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'BL_BillTo' => 'required|string|max:50|regex:/^[a-zA-Z0-9 ]*$/',
            'BL_InsCompany' => 'required|string|max:50',
            'BL_MaxAmt' => 'nullable|numeric|min:0|max:2000',
            'BL_AuthFee' => 'nullable|numeric|min:0|max:500',
            'epic_fee' => 'nullable|numeric|min:0|max:500',
            'veradigm_fee' => 'nullable|numeric|min:0|max:500',
        ], [
            'BL_BillTo.required' => 'The Bill To field is required.',
            'BL_BillTo.regex' => 'The Bill To field may only contain letters, numbers, and spaces.',
            'BL_InsCompany.required' => 'The Insurance Company field is required.',
            'BL_MaxAmt.numeric' => 'The Max Amount field must be a valid number.',
            'BL_MaxAmt.max' => 'The Max Amount field must be a value less than or equal to 2000.',
            'BL_AuthFee.numeric' => 'The Authorization Fee field must be a valid number.',
            'BL_AuthFee.max' => 'The Authorization Fee field must be a value less than or equal to 500.',
        ]);

        $billtopicklist = new Billtopicklist($validated);
        $billtopicklist->created_by = session('admin.contractor.C_Name');
        $billtopicklist->updated_by = session('admin.contractor.C_Name');
        $billtopicklist->save();

        return redirect()
            ->route('admin.billtopicklists.show', $billtopicklist->id)
            ->with('success', 'Data has been saved');
    }

    public function show(Billtopicklist $billtopicklist)
    {
        return view('admin.billtopicklists.show', compact('billtopicklist'));
    }

    public function edit(Billtopicklist $billtopicklist)
    {
        return view('admin.billtopicklists.edit', compact('billtopicklist'));
    }

    public function update(Request $request, Billtopicklist $billtopicklist)
    {
        $validated = $request->validate([
            'BL_BillTo' => 'required|string|max:50|regex:/^[a-zA-Z0-9 ]*$/',
            'BL_InsCompany' => 'required|string|max:50',
            'BL_MaxAmt' => 'nullable|numeric|min:0|max:2000',
            'BL_AuthFee' => 'nullable|numeric|min:0|max:500',
            'epic_fee' => 'nullable|numeric|min:0|max:500',
            'veradigm_fee' => 'nullable|numeric|min:0|max:500',
        ], [
            'BL_BillTo.required' => 'The Bill To field is required.',
            'BL_BillTo.regex' => 'The Bill To field may only contain letters, numbers, and spaces.',
            'BL_InsCompany.required' => 'The Insurance Company field is required.',
            'BL_MaxAmt.numeric' => 'The Max Amount field must be a valid number.',
            'BL_MaxAmt.max' => 'The Max Amount field must be a value less than or equal to 2000.',
            'BL_AuthFee.numeric' => 'The Authorization Fee field must be a valid number.',
            'BL_AuthFee.max' => 'The Authorization Fee field must be a value less than or equal to 500.',
        ]);

        $billtopicklist->update(array_merge($validated, [
            'updated_by' => session('admin.contractor.C_Name'),
        ]));

        return redirect()
            ->route('admin.billtopicklists.show', $billtopicklist->id)
            ->with('success', 'Data has been saved');
    }

    // public function destroy(Billtopicklist $billtopicklist)
    // {
    //     $billtopicklist->delete();
    //     return redirect()
    //         ->route('admin.billtopicklists.index')
    //         ->with('success', 'Record has been deleted');
    // }
}
