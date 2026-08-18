<x-user-layout title="Addon Order">

    <div class="row">
        <div class="col-auto">
            <h1>Addon Order</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.addonorders.index') }}" class="btn btn-sm btn-secondary">View Addon Orders</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>id</td>
            <td>{{ $addonorder->id }}</td>
        </tr>
        <tr>
            <td>workorder_id</td>
            <td>{{ $addonorder->workorder_id }}</td>
        </tr>
        <tr>
            <td>company</td>
            <td>{{ $addonorder->company }}</td>
        </tr>
        <tr>
            <td>requestor</td>
            <td>{{ $addonorder->requestor }}</td>
        </tr>
        <tr>
            <td>applicant</td>
            <td>{{ $addonorder->applicant }}</td>
        </tr>
        <tr>
            <td>gender</td>
            <td>{{ $addonorder->gender }}</td>
        </tr>
        <tr>
            <td>newordertype</td>
            <td>{{ $addonorder->newordertype }}</td>
        </tr>
        <tr>
            <td>note</td>
            <td>{{ $addonorder->note }}</td>
        </tr>
        <tr>
            <td>New Workorder ID</td>
            <td>{{ $addonorder->newworkorder_id }}</td>
        </tr>
        <tr>
            <td>Hospital</td>
            <td>{{ $addonorder->hospital }}</td>
        </tr>
        <tr>
            <td>Created</td>
            <td>{{ $addonorder->created }}</td>
        </tr>
        <tr>
            <td>Updated</td>
            <td>{{ $addonorder->Updated }}</td>
        </tr>
    </table>

    <br />
    <br />

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            addonorder
            @php dump(@$addonorder) @endphp
        </div>
    @endif

</x-user-layout>
