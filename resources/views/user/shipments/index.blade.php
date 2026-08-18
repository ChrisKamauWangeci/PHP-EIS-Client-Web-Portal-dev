<x-user-layout title="">

    <h1>Shipments</h1>

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('user.shipments.index') }}">
        @csrf
        <input type="hidden" name="search" value="1">
        <input type="hidden" name="type" value="all">

        <div class="row">

            <div class="col-md-2">
                <x-form.input type="number" name="workorder_id" label="workorder_id" :value="request('workorder_id')" max="100000000" />
            </div>

            <div class="col-md-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.shipments.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $shipments->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_id', 'sort_direction' => $sort_direction]) }}">Workorder ID</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'type', 'sort_direction' => $sort_direction]) }}">Type</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'service', 'sort_direction' => $sort_direction]) }}">Service</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'fee', 'sort_direction' => $sort_direction]) }}">Fee</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'tracking_number', 'sort_direction' => $sort_direction]) }}">Tracking Number</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'ship_date', 'sort_direction' => $sort_direction]) }}">Ship Date</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'status', 'sort_direction' => $sort_direction]) }}">Status</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_by', 'sort_direction' => $sort_direction]) }}">Created By</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_by', 'sort_direction' => $sort_direction]) }}">Updated By</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created At</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_at', 'sort_direction' => $sort_direction]) }}">Updated At</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shipments as $shipment)
                    <tr>
                    <td>{{ $shipment->workorder_id }}</td>
                    <td>{{ $shipment->type }}</td>
                    <td>{{ $shipment->service }}</td>
                    <td>{{ $shipment->fee }}</td>
                    <td>{{ $shipment->tracking_number }}</td>
                    <td>{{ $shipment->ship_date }}</td>
                    <td>{{ $shipment->status }}</td>
                    <td>{{ $shipment->created_by }}</td>
                    <td>{{ $shipment->updated_by }}</td>
                    <td>{{ $shipment->created_at }}</td>
                    <td>{{ $shipment->updated_at }}</td>
                    <td><a href="{{ route('user.shipments.show', $shipment->id) }}" class="btn btn-xs btn-secondary">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $shipments->withQueryString()->links() }}

    <br />
    <br />

    @if($workorder_id)
        <a href="{{ route('user.shipments.create', ['workorder_id' => $workorder_id]) }}" class="btn btn-sm btn-secondary">Add</a>
    @endif

    <br />
    <br />

</x-user-layout>