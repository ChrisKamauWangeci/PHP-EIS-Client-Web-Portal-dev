<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Setting::query()
            ->when($filters['category'] ?? null, fn ($q, $v) => $q->where('category', $v))
            ->when($filters['name'] ?? null, fn ($q, $v) => $q->where('name', 'LIKE', "%{$v}%"))
            ->when($filters['value'] ?? null, fn ($q, $v) => $q->where('value', 'LIKE', "%{$v}%"))
            ->when($filters['created_by'] ?? null, fn ($q, $v) => $q->where('created_by', $v))
            ->when($filters['updated_by'] ?? null, fn ($q, $v) => $q->where('updated_by', $v));

        $sort_field = $request->query('sort_field', 'category');
        $sort_direction = $request->query('sort_direction', 'asc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $settings = $query->paginate(100);

        return view('admin.settings.index', compact('settings', 'sort_direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $isHtmx = $request->header('HX-Request');

        return view('admin.settings.create', compact('isHtmx'))->fragmentIf($isHtmx, 'formstore');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSettingRequest $request)
    {
        $setting = new Setting($request->validated());
        $setting->created_by = session('admin.contractor.C_Name');
        $setting->updated_by = session('admin.contractor.C_Name');
        $setting->save();

        if ($request->header('HX-Request')) {
            $request->session()->flash('success', 'Data has been saved');

            return response('', 200)->header('HX-Refresh', 'true');
        }

        return redirect()
            ->route('admin.settings.show', $setting->id)
            ->with('success', 'Data has been saved');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        return view('admin.settings.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        $setting->update($request->validated());

        return redirect()
            ->route('admin.settings.show', $setting->id)
            ->with('success', 'Data has been saved');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Record has been deleted');
    }
}
