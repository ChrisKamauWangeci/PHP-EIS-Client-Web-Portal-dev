<x-user-layout title="">

    <div class="row">
        <div class="col">
            <h1>Workorder Payment: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }} {{ $workorder->W_MiddleInit }} {{ $workorder->W_LastName }}</h1>
        </div>
        <div class="col-auto text-end">
            <a href="{{ route('user.workorderpayments.index') }}" class="btn btn-sm btn-secondary">Workorder Payments</a>
            <a href="{{ route('user.workorderpayments.index', ['workorder_id' => $workorderpayment->workorder_id]) }}" class="btn btn-sm btn-secondary">View Workorder Payments for # {{ $workorder->W_WorkOrder }}</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <th>ID</th>
            <td>{{ $workorderpayment->id }}</td>
        </tr>
        <tr>
            <th>Workorder Id</th>
            <td>{{ $workorderpayment->workorder_id }}</td>
        </tr>
        <tr>
            <th>Payment Type</th>
            <td>{{ $workorderpayment->payment_type }}</td>
        </tr>
        <tr>
            <th>Amount</th>
            <td>{{ $workorderpayment->amount }}</td>
        </tr>
        <tr>
            <th>Recipient</th>
            <td>{{ $workorderpayment->recipient }}</td>
        </tr>
        <tr>
            <th>Payment Date</th>
            <td>{{ $workorderpayment->payment_date }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $workorderpayment->status }}</td>
        </tr>
        <tr>
            <th>Created by</th>
            <td>{{ $workorderpayment->created_by }}</td>
        </tr>
        <tr>
            <th>Created at</th>
            <td>{{ $workorderpayment->created_at }}</td>
        </tr>
        <tr>
            <th>Updated by</th>
            <td>{{ $workorderpayment->updated_by }}</td>
        </tr>
        <tr>
            <th>Updated at</th>
            <td>{{ $workorderpayment->updated_at }}</td>
        </tr>
    </table>

    <br />
    <br />

    <a href="{{ route('user.workorderpayments.edit', $workorderpayment->id) }}" class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            workorderpayment
            @php dump(@$workorderpayment) @endphp
        </div>
    @endif

</x-user-layout>