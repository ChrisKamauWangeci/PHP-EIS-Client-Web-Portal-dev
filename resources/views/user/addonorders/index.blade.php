<x-user-layout title="Addon Orders">

    <h1>Addon Orders</h1>

    <form method="GET"
          action="{{ route('user.addonorders.index') }}">

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
                <a href="{{ route('user.addonorders.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $addonorders->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Workorder</th>
                    <th>Company</th>
                    <th>Requestor</th>
                    <th>Applicant</th>
                    <th>Gender</th>
                    <th>New Order Type</th>
                    <th>Note</th>
                    <th>New Workorder ID</th>
                    <th>Hospital</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($addonorders as $addonorder)
                    <tr>
                        <td>{{ $addonorder->id }}</td>
                        <td>{{ $addonorder->workorder_id }}</td>
                        <td>{{ $addonorder->company }}</td>
                        <td>{{ $addonorder->requestor }}</td>
                        <td>{{ $addonorder->applicant }}</td>
                        <td>{{ $addonorder->gender }}</td>
                        <td>{{ $addonorder->newordertype }}</td>
                        <td>{{ $addonorder->note }}</td>
                        <td>{{ $addonorder->newworkorder_id }}</td>
                        <td>{{ $addonorder->hospital }}</td>
                        <td>{{ $addonorder->created }}</td>
                        <td>{{ $addonorder->Updated }}</td>
                        <td><a href="{{ route('user.addonorders.show', $addonorder->id) }}"
                               class="btn btn-xs btn-secondary">view</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $addonorders->withQueryString()->links() }}

    <br />
    <br />

</x-user-layout>
