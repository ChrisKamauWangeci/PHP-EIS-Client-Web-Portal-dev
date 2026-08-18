<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Changelog;
use Illuminate\Http\Request;

class ChangelogController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Changelog::query()
            ->when($filters['title'] ?? null, fn ($q, $v) => $q->where('title', 'LIKE', "%{$v}%"));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $changelogs = $query->paginate(200);

        return view('admin.changelogs.index', compact('changelogs', 'sort_direction'));
    }

    public function create()
    {
        return view('admin.changelogs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'string',
            'released_at' => 'date',
            'is_active' => 'sometimes|boolean',
        ]);

        $changelog = new Changelog($validated + [
            'created_by' => session('admin.contractor.C_Name'),
            'updated_by' => session('admin.contractor.C_Name'),
        ]);
        $changelog->save();

        return redirect()
            ->route('admin.changelogs.show', $changelog->id)
            ->with('success', 'Data has been saved');
    }

    public function show(Changelog $changelog)
    {
        return view('admin.changelogs.show', compact('changelog'));
    }

    public function edit(Changelog $changelog)
    {
        return view('admin.changelogs.edit', compact('changelog'));
    }

    public function update(Request $request, Changelog $changelog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'string',
            'released_at' => 'date',
            'is_active' => 'sometimes|boolean',
        ]);

        $changelog->update($validated + [
            'updated_by' => session('admin.contractor.C_Name'),
        ]);

        return redirect()
            ->route('admin.changelogs.show', $changelog->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(Changelog $changelog)
    {
        $changelog->delete();

        return redirect()
            ->route('admin.changelogs.index')
            ->with('success', 'Record has been deleted');
    }
}
