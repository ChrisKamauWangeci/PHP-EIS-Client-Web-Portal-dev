<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurgeConfigRequest;
use App\Http\Requests\UpdatePurgeConfigRequest;
use App\Models\PurgeConfig;
use Illuminate\Http\Request;

class PurgeConfigController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = PurgeConfig::query()
            ->when($filters['company_name'] ?? null, fn ($q, $v) => $q->where('company_name', 'LIKE', '%' . $v . '%'));

        $sort_field = $request->query('sort_field', 'folder_name');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $purgeConfigs = $query->paginate(200);

        return view('user.purge_configs.index', compact('purgeConfigs', 'sort_direction'));
    }

    public function create()
    {
        return view('user.purge_configs.create');
    }

    public function store(StorePurgeConfigRequest $request)
    {
        $purgeConfig = new PurgeConfig($request->validated());
        $purgeConfig->save();

        return redirect()
            ->route('user.purge_configs.show', $purgeConfig->id)
            ->with('success', 'Data has been saved');
    }

    public function show(PurgeConfig $purgeConfig)
    {
        return view('user.purge_configs.show', compact('purgeConfig'));
    }

    public function edit(Request $request, PurgeConfig $purgeConfig)
    {
        return view('user.purge_configs.edit', compact('purgeConfig'));
    }

    public function update(UpdatePurgeConfigRequest $request, PurgeConfig $purgeConfig)
    {
        // dd($purgeConfig);
        $purgeConfig->update($request->validated());

        return redirect()
            ->route('user.purge_configs.show', $purgeConfig->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(PurgeConfig $purgeConfig)
    {
        $purgeConfig->delete();

        return redirect()
            ->route('user.purge_configs.index')
            ->with('success', 'Record has been deleted');
    }
}
