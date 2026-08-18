<x-user-layout title="">

    <div class="row">
        <div class="col">
            <h1>Shipment - {{ $shipment->id }}</h1>
        </div>
        <div class="col-auto text-end">
            <a href="/user/shipments" class="btn btn-sm btn-secondary">Shipments</a>
            <a href="/user/shipments?workorder_id={{ $workorder->W_WorkOrder }}" class="btn btn-sm btn-secondary">View Shipments for # {{ $workorder->W_WorkOrder }}</a>
        </div>
    </div>


    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <th>ID</th>
            <td>{{ $shipment->id }}</td>
        </tr>
        <tr>
            <th>Workorder Id</th>
            <td>{{ $shipment->workorder_id }}</td>
        </tr>
        <tr>
            <th>Fee</th>
            <td>${{ $shipment->fee }}</td>
        </tr>
        <tr>
            <th>Type</th>
            <td>{{ $shipment->type }}</td>
        </tr>
        <tr>
            <th>Service</th>
            <td>{{ $shipment->service }}</td>
        </tr>
        <tr>
            <th>Tracking Number</th>
            <td>{{ $shipment->tracking_number }}</td>
        </tr>
        <tr>
            <th>Created by</th>
            <td>{{ $shipment->created_by }}</td>
        </tr>
        <tr>
            <th>Updated by</th>
            <td>{{ $shipment->updated_by }}</td>
        </tr>
        <tr>
            <th>Created at</th>
            <td>{{ $shipment->created_at }}</td>
        </tr>
        <tr>
            <th>Updated at</th>
            <td>{{ $shipment->updated_at }}</td>
        </tr>
    </table>

    <br />
    <br />

</x-user-layout>