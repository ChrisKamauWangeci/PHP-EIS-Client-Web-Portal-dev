<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequestorroleRequest;
use App\Http\Requests\UpdateRequestorroleRequest;
use App\Models\Requestor;
use App\Models\Requestorrole;
use Illuminate\Http\Request;

class RequestorroleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'company' => 'nullable|string|min:1|max:255',
            'name' => 'nullable|string|min:1|max:255',
            'sort_field' => 'nullable|string|in:company,name,role,created_at,updated_at',
            'sort_direction' => 'nullable|string|in:asc,desc',
        ]);

        $query = Requestorrole::query()
            ->when($validated['company'] ?? null, fn ($q, $v) => $q->where('company', 'LIKE', "%{$v}%"))
            ->when($validated['name'] ?? null, fn ($q, $v) => $q->where('name', 'LIKE', "%{$v}%"));

        $sort_field = $validated['sort_field'] ?? 'company';
        $sort_direction = $validated['sort_direction'] ?? 'asc';

        if ($sort_field) {
            $query->orderBy($sort_field, $sort_direction);
        } else {
            $query->orderBy('company', 'asc')
                ->orderBy('name', 'asc');
        }
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $requestorroles = $query->paginate(200);

        return view('admin.requestorroles.index', compact('requestorroles', 'sort_direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.requestorroles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequestorroleRequest $request)
    {
        $requestorrole = new Requestorrole($request->validated());
        $requestorrole->save();

        return redirect()
            ->route('admin.requestorroles.show', $requestorrole->id)
            ->with('success', 'Data has been saved');
    }

    /**
     * Display the specified resource.
     */
    public function show(Requestorrole $requestorrole)
    {
        $requestors = Requestor::query()
            ->where('requestorrole_id', $requestorrole->id)
            ->limit(300)
            ->get();

        return view('admin.requestorroles.show', compact('requestorrole', 'requestors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Requestorrole $requestorrole)
    {
        return view('admin.requestorroles.edit', compact('requestorrole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequestorroleRequest $request, Requestorrole $requestorrole)
    {
        $requestorrole->update($request->validated());

        return redirect()
            ->route('admin.requestorroles.show', $requestorrole->id)
            ->with('success', 'Data has been saved');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requestorrole $requestorrole)
    {
        $requestorrole->delete();

        return redirect()
            ->route('admin.requestorroles.index')
            ->with('success', 'Data has been deleted');
    }
}
