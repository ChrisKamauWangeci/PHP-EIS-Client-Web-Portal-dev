<x-user-layout title="Orders">

    <h1>Orders</h1>

    <form method="GET" action="{{ route('user.orders.index') }}">

        <div class="row">

            <div class="col-md-2">
                <x-form.input name="workorder_id" label="Workorder ID" :value="request('workorder_id')" autocomplete="off" />
            </div>

            <div class="col-md-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.orders.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $orders->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Order Type</th>
                    <th>Company</th>
                    <th>Requestor Name</th>
                    <th>Applicant First Name</th>
                    <th>Applicant Last Name</th>
                    <th>Gender</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->order_type }}</td>
                        <td>{{ $order->company }}</td>
                        <td>{{ $order->requestor_name }}</td>
                        <td>{{ $order->applicant_first_name }}</td>
                        <td>{{ $order->applicant_last_name }}</td>
                        <td>{{ $order->applicant_gender }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->updated_at }}</td>
                        <td><a href="{{ route('user.orders.show', $order->id) }}" class="btn btn-xs btn-secondary">view</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $orders->withQueryString()->links() }}

    <br />
    <br />

</x-user-layout>