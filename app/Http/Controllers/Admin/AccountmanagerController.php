<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accountmanager;
use Illuminate\Http\Request;

class AccountmanagerController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'Acc_Company' => 'nullable|string|max:50',
            'Acc_Manager' => 'nullable|string|max:50',
            'sort_field' => 'nullable|string',
            'sort_direction' => 'nullable|string|in:asc,desc',
        ]);

        $query = Accountmanager::query()
            ->when($validated['Acc_Company'] ?? null, fn ($q, $v) => $q->where('Acc_Company', 'LIKE', "%$v%"))
            ->when($validated['Acc_Manager'] ?? null, fn ($q, $v) => $q->where('Acc_Manager', 'LIKE', "%$v%"));

        $sort_field = $request->query('sort_field', 'Acc_Company');
        $sort_direction = $request->query('sort_direction', 'asc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $accountmanagers = $query->paginate(200);

        return view('admin.accountmanagers.index', compact('accountmanagers', 'sort_direction'));
    }

    public function create()
    {
        return view('admin.accountmanagers.create');
    }

    public function store(StoreAccountmanagerRequest $request)
    {
        $accountmanager = Accountmanager::create($request->validated());

        return redirect()
            ->route('admin.accountmanagers.show', $accountmanager->id)
            ->with('success', 'Data has been saved');
    }

    public function show(Accountmanager $accountmanager)
    {
        return view('admin.accountmanagers.show', compact('accountmanager'));
    }

    public function edit(Accountmanager $accountmanager)
    {
        return view('admin.accountmanagers.edit', compact('accountmanager'));
    }

    public function update(UpdateAccountmanagerRequest $request, Accountmanager $accountmanager)
    {
        $accountmanager->update($request->validated());

        return redirect()
            ->route('admin.accountmanagers.show', $accountmanager->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(Accountmanager $accountmanager)
    {
        //
    }
}
