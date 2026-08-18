<x-user-layout title="">

    <h1>Workorder Payments</h1>

    <form method="GET" action="{{ route('user.workorderpayments.index') }}">

        <input type="hidden" name="search" value="1">
        <input type="hidden" name="type" value="all">

        <div class="row">

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="workorder_id" id="workorder_id" label="Workorder ID" :value="request('workorder_id')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <br />
                <x-form.button type="submit">Submit</x-form.button>
                <a href="{{ route('user.workorderpayments.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $workorderpayments->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_id', 'sort_direction' => $sort_direction]) }}">Workorder ID</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'payment_type', 'sort_direction' => $sort_direction]) }}">Payment Type</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'amount', 'sort_direction' => $sort_direction]) }}">Amount</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'recipient', 'sort_direction' => $sort_direction]) }}">Recipient</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'payment_date', 'sort_direction' => $sort_direction]) }}">Payment Date</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'check_number', 'sort_direction' => $sort_direction]) }}">Check Number</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'status', 'sort_direction' => $sort_direction]) }}">Status</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_by', 'sort_direction' => $sort_direction]) }}">Created By</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_by', 'sort_direction' => $sort_direction]) }}">Updated By</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created At</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_at', 'sort_direction' => $sort_direction]) }}">Updated At</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workorderpayments as $workorderpayment)
                    <tr>
                    <td>{{ $workorderpayment->workorder_id }}</td>
                    <td>{{ $workorderpayment->payment_type }}</td>
                    <td>{{ $workorderpayment->amount }}</td>
                    <td>{{ $workorderpayment->recipient }}</td>
                    <td>{{ $workorderpayment->payment_date }}</td>
                    <td>{{ $workorderpayment->check_number }}</td>
                    <td>{{ $workorderpayment->status }}</td>
                    <td>{{ $workorderpayment->created_by }}</td>
                    <td>{{ $workorderpayment->created_at }}</td>
                    <td>{{ $workorderpayment->updated_by }}</td>
                    <td>{{ $workorderpayment->updated_at }}</td>
                    <td><a href="{{ route('user.workorderpayments.show', $workorderpayment->id) }}" class="btn btn-xs btn-secondary">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $workorderpayments->withQueryString()->links() }}

    <br />
    <br />

    @if(request('workorder_id'))
        <a href="{{ route('user.workorderpayments.create', ['workorder_id' => request('workorder_id')]) }}" class="btn btn-sm btn-secondary">Add</a>
    @endif

</x-user-layout>