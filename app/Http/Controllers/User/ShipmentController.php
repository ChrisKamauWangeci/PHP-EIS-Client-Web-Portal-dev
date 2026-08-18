<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShipmentRequest;
use App\Http\Requests\UpdateShipmentRequest;
use App\Models\Shipment;
use App\Models\Workorder;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index(StoreShipmentRequest $request)
    {
        $filters = $request->query();

        $workorder_id = $filters['workorder_id'] ?? null;

        $query = Shipment::query()
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', $v));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $shipments = $query->paginate(50);

        return view('user.shipments.index', compact('shipments', 'sort_direction', 'workorder_id'));
    }

    public function create(Request $request)
    {
        $workorder_id = $request->query('workorder_id') ?? null;

        $workorder = Workorder::query()
            ->where('W_WorkOrder', $workorder_id)
            ->firstOrFail();

        return view('user.shipments.create', compact('workorder'));
    }

    public function store(StoreShipmentRequest $request)
    {
        $shipment = new Shipment($request->validated());
        $shipment->created_by = session('user.contractor.C_Name');
        $shipment->updated_by = session('user.contractor.C_Name');
        $shipment->save();

        $totalamount = Shipment::query()
            ->where('workorder_id', $shipment->workorder_id)
            ->sum('fee');

        Workorder::where('W_WorkOrder', $shipment->workorder_id)->limit(1)->update(['W_ShipFee' => $totalamount]);

        return redirect()
            ->route('user.shipments.index', ['workorder_id' => $shipment->workorder_id])
            ->with('success', 'Data has been saved');
    }

    public function show(Shipment $shipment)
    {
        $workorder = Workorder::query()
            ->where('W_WorkOrder', $shipment->workorder_id)
            ->firstOrFail();

        return view('user.shipments.show', compact('shipment', 'workorder'));
    }

    public function edit(Shipment $shipment)
    {
        return view('user.shipments.edit', compact('shipment'));
    }

    public function update(UpdateShipmentRequest $request, Shipment $shipment)
    {
        $shipment->update($request->validated() + [
            'updated_by' => session('user.contractor.C_Name'),
        ]);

        $totalamount = Shipment::query()
            ->where('workorder_id', $shipment->workorder_id)
            ->sum('fee');

        Workorder::where('W_WorkOrder', $shipment->workorder_id)->limit(1)->update(['W_ShipFee' => $totalamount]);

        return redirect()
            ->route('user.shipments.show', $shipment->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(Shipment $shipment)
    {
        //
    }
}
