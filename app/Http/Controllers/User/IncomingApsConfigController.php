<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIncomingApsConfigRequest;
use App\Http\Requests\UpdateIncomingApsConfigRequest;
use App\Models\IncomingApsConfig;
use Illuminate\Http\Request;

class IncomingApsConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = IncomingApsConfig::query()
            ->when($filters['source'] ?? null, fn ($q, $v) => $q->where('source', 'LIKE', '%' . $v . '%'))
            ->when($filters['source_folder'] ?? null, fn ($q, $v) => $q->where('source_folder', 'LIKE', '%' . $v . '%'))
            ->when($filters['destination_folder'] ?? null, fn ($q, $v) => $q->where('destination_folder', 'LIKE', '%' . $v . '%'));

        $sort_field = $request->query('sort_field', 'source');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $incomingApsConfigs = $query->paginate(200);
        // dd($purgeConfigs);

        return view('user.incoming_aps_configs.index', compact('incomingApsConfigs', 'sort_direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.incoming_aps_configs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIncomingApsConfigRequest $request)
    {
        $incomingApsConfig = new IncomingApsConfig($request->validated());
        $incomingApsConfig->created_by = session('user.contractor.C_Name');
        $incomingApsConfig->updated_by = session('user.contractor.C_Name');
        $incomingApsConfig->save();

        return redirect()
            ->route('user.incoming_aps_configs.show', $incomingApsConfig->id)
            ->with('success', 'Data has been saved');
    }

    /**
     * Display the specified resource.
     */
    public function show(IncomingApsConfig $incomingApsConfig)
    {
        return view('user.incoming_aps_configs.show', compact('incomingApsConfig'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IncomingApsConfig $incomingApsConfig)
    {
        return view('user.incoming_aps_configs.edit', compact('incomingApsConfig'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIncomingApsConfigRequest $request, IncomingApsConfig $incomingApsConfig)
    {
        // dd($incomingApsConfig);

        $incomingApsConfig->update($request->validated() + [
            'updated_by' => session('user.contractor.C_Name'),
        ]);

        return redirect()
            ->route('user.incoming_aps_configs.show', $incomingApsConfig->id)
            ->with('success', 'Data has been saved');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncomingApsConfig $incomingApsConfig)
    {
        $incomingApsConfig->delete();

        return redirect()
            ->route('user.incoming_aps_configs.index')
            ->with('success', 'Record has been deleted');
    }
}
