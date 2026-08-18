<x-admin-layout>

    <h1>Requestor Password Change</h1>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $requestorPasswordChange->id }}</td>
        </tr>
        <tr>
            <td>DB</td>
            <td>{{ $requestorPasswordChange->db }}</td>
        </tr>
        <tr>
            <td>Company</td>
            <td>{{ $requestorPasswordChange->company }}</td>
        </tr>
        <tr>
            <td>Requestor</td>
            <td>{{ $requestorPasswordChange->requestor }}</td>
        </tr>
        <tr>
            <td>Username</td>
            <td>{{ $requestorPasswordChange->username }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $requestorPasswordChange->email }}</td>
        </tr>
        <tr>
            <td>IP Address</td>
            <td>{{ $requestorPasswordChange->ip_address }}</td>
        </tr>
        <tr>
            <td>Country</td>
            <td>
                {{ $requestorPasswordChange->country_iso }}
                <img src="/img/flags/gif/{{ strtolower($requestorPasswordChange->country_iso ?? '') }}.gif" alt="">
            </td>
        </tr>
        <tr>
            <td>Region</td>
            <td>{{ $requestorPasswordChange->region_iso }}</td>
        </tr>
        <tr>
            <td>City</td>
            <td>{{ $requestorPasswordChange->city }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $requestorPasswordChange->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $requestorPasswordChange->updated_at }}</td>
        </tr>
    </table>

    <br />
    <br />

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            requestorPasswordChange
            @php dump(@$requestorPasswordChange) @endphp
        </div>
    @endif

    <br />
    <br />

</x-admin-layout>