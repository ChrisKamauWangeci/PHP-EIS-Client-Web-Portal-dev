<x-user-layout title="Workorder Details">

    <h1>Workorder Details</h1>

    <form method="GET"
          action="{{ route('user.workorderdetails.index') }}">

        <div class="row">

            <div class="col-md-2">
                <x-form.input name="workorder_id"
                              label="Workorder ID"
                              :value="request('workorder_id')"
                              autocomplete="off" />
            </div>

            <div class="col-md-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.workorderdetails.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $workorderdetails->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Workorder</th>
                    <th>Requestor Role</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workorderdetails as $workorderdetail)
                    <tr>
                        <td>{{ $workorderdetail->id }}</td>
                        <td>{{ $workorderdetail->workorder_id }}</td>
                        <td>{{ $workorderdetail->requestorrole }}</td>
                        <td>{{ $workorderdetail->created_at }}</td>
                        <td>{{ $workorderdetail->updated_at }}</td>
                        <td><a href="{{ route('user.workorderdetails.show', $workorderdetail->id) }}"
                               class="btn btn-xs btn-secondary">view</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $workorderdetails->withQueryString()->links() }}

    <br />
    <br />

</x-user-layout>
