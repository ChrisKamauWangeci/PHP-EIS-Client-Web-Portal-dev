<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Insurance Company</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.insurancecompanies.index') }}" class="btn btn-sm btn-secondary">View Insurance Companies</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $insurancecompany->I_ID }}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{ $insurancecompany->I_Name }}</td>
        </tr>
        <tr>
            <td>Address</td>
            <td>{{ $insurancecompany->I_Address }}</td>
        </tr>
        <tr>
            <td>City</td>
            <td>{{ $insurancecompany->I_City }}</td>
        </tr>
        <tr>
            <td>State</td>
            <td>{{ $insurancecompany->I_State }}</td>
        </tr>
        <tr>
            <td>Zip</td>
            <td>{{ $insurancecompany->I_Zip }}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{ $insurancecompany->I_Phone }}</td>
        </tr>
        <tr>
            <td>Fax</td>
            <td>{{ $insurancecompany->I_Fax }}</td>
        </tr>
        <tr>
            <td>LOR</td>
            <td>{{ $insurancecompany->I_LOR }}</td>
        </tr>
        <tr>
            <td>LOR Expiration Date</td>
            <td>{{ $insurancecompany->I_LORExpirationDate?->format('Y-m-d') }}</td>
        </tr>
        <tr>
            <td>Direct Billing</td>
            <td>{{ $insurancecompany->I_DirectBilling }}</td>
        </tr>
        <tr>
            <td>Active Website</td>
            <td>{{ $insurancecompany->I_ActiveWebsite }}</td>
        </tr>
    </table>

    <br />

    <!-- <a href="{{ route('user.insurancecompanies.edit', $insurancecompany->I_ID) }}" class="btn btn-sm btn-secondary">Edit</a> -->

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            insurancecompany
            @php dump(@$insurancecompany) @endphp
        </div>
    @endif

</x-user-layout>