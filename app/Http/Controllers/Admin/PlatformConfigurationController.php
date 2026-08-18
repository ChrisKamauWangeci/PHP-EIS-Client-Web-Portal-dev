<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexPlatformConfigurationRequest;
use App\Http\Requests\StorePlatformConfigurationRequest;
use App\Http\Requests\UpdatePlatformConfigurationRequest;
use App\Models\Company;
use App\Models\PlatformConfiguration;
use Illuminate\Http\Request;

class PlatformConfigurationController extends Controller
{
    public function companies(Request $request)
    {
        $companies = PlatformConfiguration::query()
            ->select('company')
            ->distinct()
            ->orderBy('company', 'asc')
            ->paginate(100);

        return view('admin.platform_configurations.companies', compact('companies'));
    }

    public function index(IndexPlatformConfigurationRequest $request)
    {
        $filters = $request->validated();

        $query = PlatformConfiguration::query()
            ->when($filters['company'] ?? null, fn ($q, $v) => $q->where('company', $v))
            ->when($filters['platform'] ?? null, fn ($q, $v) => $q->where('platform', $v))
            ->when($filters['order_type'] ?? null, fn ($q, $v) => $q->where('order_type', $v));

        $sort_field = $request->query('sort_field', 'company');
        $sort_direction = $request->query('sort_direction', 'asc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $platformConfigurations = $query->paginate(100);

        $companies = Company::orderBy('C_Name', 'asc')->pluck('C_Name', 'C_Name');

        return view('admin.platform_configurations.index', compact('platformConfigurations', 'sort_direction', 'companies'));
    }

    public function create(Request $request)
    {
        $isHtmx = $request->header('HX-Request');

        $companies = Company::query()
            ->orderBy('C_Name', 'asc')
            ->pluck('C_Name', 'C_Name');

        return view('admin.platform_configurations.create', compact('companies', 'isHtmx'))->fragmentIf($isHtmx, 'formstore');
    }

    public function store(StorePlatformConfigurationRequest $request)
    {
        $platformConfiguration = new PlatformConfiguration($request->validated());
        $platformConfiguration->save();

        if ($request->header('HX-Request')) {
            $request->session()->flash('success', 'Data has been saved');

            return response('', 200)->header('HX-Refresh', 'true');
        }

        return redirect()
            ->route('admin.platform-configurations.show', $platformConfiguration->id)
            ->with('success', 'Data has been saved');
    }

    public function show(PlatformConfiguration $platformConfiguration)
    {
        return view('admin.platform_configurations.show', compact('platformConfiguration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlatformConfiguration $platformConfiguration)
    {
        return view('admin.platform_configurations.edit', compact('platformConfiguration'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlatformConfigurationRequest $request, PlatformConfiguration $platformConfiguration)
    {
        $platformConfiguration->update($request->validated());

        return redirect()
            ->route('admin.platform-configurations.show', $platformConfiguration->id)
            ->with('success', 'Data has been saved');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlatformConfiguration $platformConfiguration)
    {
        $platformConfiguration->delete();

        return redirect()
            ->route('admin.platform-configurations.index')
            ->with('success', 'Record has been deleted');
    }
}
