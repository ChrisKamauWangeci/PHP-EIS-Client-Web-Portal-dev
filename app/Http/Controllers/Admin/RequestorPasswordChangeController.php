<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestorPasswordChange;
use Illuminate\Http\Request;

class RequestorPasswordChangeController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'action' => 'nullable|string|in:change,reset',
            'company' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9 ]*$/',
            'requestor' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9 ]*$/',
            'username' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9 ]*$/',
            'email' => 'nullable|email|max:50',
            'ip_address' => 'nullable|string|max:50',
            'created_at_from' => 'nullable|date_format:Y-m-d',
            'created_at_to' => 'nullable|date_format:Y-m-d|after_or_equal:created_at_from',
            'sort_field' => 'nullable|string',
            'sort_direction' => 'nullable|string|in:asc,desc',
        ]);

        $query = RequestorPasswordChange::query()
            ->when($validated['action'] ?? null, fn ($q, $v) => $q->where('action', $v))
            ->when($validated['company'] ?? null, fn ($q, $v) => $q->where('company', 'LIKE', "%{$v}%"))
            ->when($validated['requestor'] ?? null, fn ($q, $v) => $q->where('requestor', 'LIKE', "%{$v}%"))
            ->when($validated['username'] ?? null, fn ($q, $v) => $q->where('username', 'LIKE', "%{$v}%"))
            ->when($validated['email'] ?? null, fn ($q, $v) => $q->where('email', 'LIKE', "%{$v}%"))
            ->when($validated['ip_address'] ?? null, fn ($q, $v) => $q->where('ip_address', 'LIKE', "%{$v}%"))
            ->when($validated['created_at_from'] ?? null, fn ($q, $v) => $q->where('created_at', '>=', $v . ' 00:00:00'))
            ->when($validated['created_at_to'] ?? null, fn ($q, $v) => $q->where('created_at', '<=', $v . ' 23:59:59'));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $requestorPasswordChanges = $query->paginate(200);

        return view('admin.requestor_password_changes.index', compact('requestorPasswordChanges', 'sort_direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestorPasswordChange $requestorPasswordChange)
    {
        return view('admin.requestor_password_changes.show', compact('requestorPasswordChange'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestorPasswordChange $requestorPasswordChange)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestorPasswordChange $requestorPasswordChange)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestorPasswordChange $requestorPasswordChange)
    {
        //
    }
}
