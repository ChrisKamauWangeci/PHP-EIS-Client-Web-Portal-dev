<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexPlatformConfigurationRequest;
use App\Http\Requests\StorePlatformConfigurationRequest;
use App\Http\Requests\UpdatePlatformConfigurationRequest;
use App\Models\Company;
use App\Models\PlatformConfiguration;

class PlatformConfigurationController extends Controller
{
    public function index(IndexPlatformConfigurationRequest $request)
    {
        $filters = $request->validated();

        $query = PlatformConfiguration::query()
            ->when($filters['company'] ?? null, fn ($q, $v) => $q->where('company', $v))
            ->when($filters['platform'] ?? null, fn ($q, $v) => $q->where('platform', $v))
            ->when($filters['order_type'] ?? null, fn ($q, $v) => $q->where('order_type', $v))
            ->orderBy('company', 'asc')
            ->orderBy('sequence', 'asc');

        $platformConfigurations = $query->paginate(100);

        return $platformConfigurations;
    }

    public function create()
    {
        $companies = Company::query()
            ->orderBy('C_Name', 'asc')
            ->pluck('C_Name', 'C_Name');

        return view('admin.platform_configuration.create', compact('companies'));
    }

    public function store(StorePlatformConfigurationRequest $request)
    {
        $platformConfiguration = new PlatformConfiguration($request->validated());
        $platformConfiguration->save();

        return redirect()
            ->route('admin.platform-configurations.show', $platformConfiguration->id)
            ->with('success', 'Data has been saved');
    }

    public function show(PlatformConfiguration $platformConfiguration)
    {
        return view('admin.platform_configuration.show', compact('platformConfiguration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlatformConfiguration $platformConfiguration)
    {
        return view('admin.platform_configuration.edit', compact('platformConfiguration'));
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
