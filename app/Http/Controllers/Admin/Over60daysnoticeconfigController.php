<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOver60daysnoticeconfigRequest;
use App\Http\Requests\UpdateOver60daysnoticeconfigRequest;
use App\Models\Over60daysnoticeconfig;
use Illuminate\Http\Request;

class Over60daysnoticeconfigController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Over60daysnoticeconfig::query()
            ->when($filters['C_Name'] ?? null, fn ($q, $v) => $q->where('C_Name', 'LIKE', "%{$v}%"));

        $sort_field = $request->query('sort_field', 'id');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $over60daysnoticeconfigs = $query->paginate(500);

        return view('admin.over60daysnoticeconfigs.index', compact('over60daysnoticeconfigs', 'sort_direction'));
    }

    public function create()
    {
        return view('admin.over60daysnoticeconfigs.create');
    }

    public function store(StoreOver60daysnoticeconfigRequest $request)
    {
        $over60daysnoticeconfig = new Over60daysnoticeconfig($request->validated());
        $over60daysnoticeconfig->save();

        return redirect()
            ->route('admin.over60daysnoticeconfigs.show', $over60daysnoticeconfig->id)
            ->with('success', 'Data has been saved');
    }

    public function show(Over60daysnoticeconfig $over60daysnoticeconfig)
    {
        return view('admin.over60daysnoticeconfigs.show', compact('over60daysnoticeconfig'));
    }

    public function edit(Over60daysnoticeconfig $over60daysnoticeconfig)
    {
        return view('admin.over60daysnoticeconfigs.edit', compact('over60daysnoticeconfig'));
    }

    public function update(UpdateOver60daysnoticeconfigRequest $request, Over60daysnoticeconfig $over60daysnoticeconfig)
    {
        $over60daysnoticeconfig->update($request->validated());

        return redirect()
            ->route('admin.over60daysnoticeconfigs.show', $over60daysnoticeconfig->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(Over60daysnoticeconfig $over60daysnoticeconfig)
    {
        $over60daysnoticeconfig->delete();

        return redirect()
            ->route('admin.over60daysnoticeconfigs.index')->with('success', 'Data has been deleted');
    }
}
