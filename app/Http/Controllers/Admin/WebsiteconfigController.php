<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWebsiteconfigRequest;
use App\Http\Requests\UpdateWebsiteconfigRequest;
use App\Models\Requestor;
use App\Models\Websiteconfig;
use Illuminate\Http\Request;

class WebsiteconfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Websiteconfig::query()
            ->when($filters['name'] ?? null, fn ($q, $v) => $q->where('name', 'LIKE', "%{$v}%"));

        $sort_field = $request->query('sort_field', 'name');
        $sort_direction = $request->query('sort_direction', 'asc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';
        $websiteconfigs = $query->paginate(200);

        return view('admin.websiteconfigs.index', compact('websiteconfigs', 'sort_direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.websiteconfigs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWebsiteconfigRequest $request)
    {
        $websiteconfig = new Websiteconfig($request->validated());
        $websiteconfig->created_by = session('admin.contractor.C_Name');
        $websiteconfig->updated_by = session('admin.contractor.C_Name');
        $websiteconfig->save();

        return redirect()
            ->route('admin.websiteconfigs.show', $websiteconfig->id)
            ->with('success', 'Data has been saved');
    }

    /**
     * Display the specified resource.
     */
    public function show(Websiteconfig $websiteconfig)
    {
        $requestors = Requestor::query()
            ->where('websiteconfig_id', $websiteconfig->id)
            ->limit(300)
            ->get();

        return view('admin.websiteconfigs.show', compact('websiteconfig', 'requestors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Websiteconfig $websiteconfig)
    {
        return view('admin.websiteconfigs.edit', compact('websiteconfig'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWebsiteconfigRequest $request, Websiteconfig $websiteconfig)
    {
        $websiteconfig->update($request->validated() + [
            'updated_by' => session('admin.contractor.C_Name'),
        ]);

        return redirect()
            ->route('admin.websiteconfigs.show', $websiteconfig->id)
            ->with('success', 'Data has been saved');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Websiteconfig $websiteconfig)
    {
        //
    }
}
