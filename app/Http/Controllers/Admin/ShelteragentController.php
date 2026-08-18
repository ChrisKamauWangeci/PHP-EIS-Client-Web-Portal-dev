<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shelteragent;
use Illuminate\Http\Request;

class ShelteragentController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:50',
            'email' => 'nullable|string|max:50',
            'role' => 'nullable|string|max:50',
            'sdl_district_number' => 'nullable|string|max:50',
            'agent_code' => 'nullable|string|max:50',
            'sort_field' => 'nullable|string',
            'sort_direction' => 'nullable|string|in:asc,desc',
        ]);

        $query = Shelteragent::query()
            ->when($validated['name'] ?? null, fn ($q, $v) => $q->where('name', 'LIKE', "%$v%"))
            ->when($validated['email'] ?? null, fn ($q, $v) => $q->where('email', 'LIKE', "%$v%"))
            ->when($validated['role'] ?? null, fn ($q, $v) => $q->where('role', $v))
            ->when($validated['sdl_district_number'] ?? null, fn ($q, $v) => $q->where('sdl_district_number', $v))
            ->when($validated['agent_code'] ?? null, fn ($q, $v) => $q->where('agent_code', $v));

        $sort_field = $request->query('sort_field', 'name');
        $sort_direction = $request->query('sort_direction', 'asc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $shelteragents = $query->paginate(200);

        return view('admin.shelteragents.index', compact('shelteragents', 'sort_direction'));
    }

    public function create()
    {
        return view('admin.shelteragents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'string|min:2|max:50',
            'email' => 'email|min:2|max:50',
            'role' => 'in:sdl,agent',
            'sdl_district_number' => 'nullable|string|max:50',
            'agent_code' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ]);

        $shelteragent = Shelteragent::create($validated);

        return redirect()
            ->route('admin.shelteragents.show', $shelteragent->id)
            ->with('success', 'Data has been saved');
    }

    public function show(Shelteragent $shelteragent)
    {
        $shelteragents = null;
        if ($shelteragent->role === 'sdl') {
            $shelteragents = Shelteragent::query()
                ->where('sdl_district_number', $shelteragent->sdl_district_number)
                ->where('role', 'agent')
                ->get();
        }

        return view('admin.shelteragents.show', compact('shelteragent', 'shelteragents'));
    }

    public function edit(Shelteragent $shelteragent)
    {
        return view('admin.shelteragents.edit', compact('shelteragent'));
    }

    public function update(Request $request, Shelteragent $shelteragent)
    {
        $validated = $request->validate([
            'name' => 'string|min:2|max:50',
            'email' => 'email|min:2|max:50',
            'role' => 'in:sdl,agent',
            'sdl_district_number' => 'nullable|string|max:50',
            'agent_code' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ]);

        $shelteragent->update($validated);

        return redirect()
            ->route('admin.shelteragents.show', $shelteragent->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(Shelteragent $shelteragent)
    {
        return back()->with('danger', 'Delete is disabled for now');

        // $shelteragent->delete();
        // return redirect()
        //     ->route('admin.shelteragents.index')
        //     ->with('success', 'Data has been deleted');
    }
}
