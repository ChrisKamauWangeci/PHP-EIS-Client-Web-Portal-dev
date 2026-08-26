<x-user-layout>

    <h1>Contractor</h1>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>id</td>
            <td>{{ $contractor->id }}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{ $contractor->C_Name }}</td>
        </tr>
        <tr>
            <td>Location</td>
            <td>{{ $contractor->C_Location }}</td>
        </tr>
        <tr>
            <td>SS</td>
            <td>{{ $contractor->C_SS }}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{ $contractor->C_Phone }}</td>
        </tr>
        <tr>
            <td>Fax</td>
            <td>{{ $contractor->C_Fax }}</td>
        </tr>
        <tr>
            <td>Cell</td>
            <td>{{ $contractor->C_Cell }}</td>
        </tr>
        <tr>
            <td>SysAdmin</td>
            <td>{{ $contractor->C_SysAdmin }}</td>
        </tr>
        <tr>
            <td>Driver</td>
            <td>{{ $contractor->C_Driver }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $contractor->C_Email }}</td>
        </tr>
        <tr>
            <td>Company Change</td>
            <td>{{ $contractor->C_CompanyChange }}</td>
        </tr>
        <tr>
            <td>Invoice</td>
            <td>{{ $contractor->C_Invoice }}</td>
        </tr>
        <tr>
            <td>Status Email</td>
            <td>{{ $contractor->C_StatusEmail }}</td>
        </tr>
        <tr>
            <td>Dr Fee Update</td>
            <td>{{ $contractor->C_DrFeeUpdate }}</td>
        </tr>
        <tr>
            <td>Caller</td>
            <td>{{ $contractor->C_Caller }}</td>
        </tr>
        <tr>
            <td>User Company</td>
            <td>{{ $contractor->C_UserCompany }}</td>
        </tr>
        <tr>
            <td>User Lock</td>
            <td>{{ $contractor->C_UserLock }}</td>
        </tr>
        <tr>
            <td>accesslevel</td>
            <td>{{ $contractor->accesslevel }}</td>
        </tr>
        <tr>
            <td>is_active</td>
            <td>{{ $contractor->is_active }}</td>
        </tr>
        <tr>
            <td>Password Changed</td>
            <td>{{ $contractor->password_changed }}</td>
        </tr>
        <tr>
            <td>Last Login</td>
            <td>{{ $contractor->C_LastLogin }}</td>
        </tr>
        <tr>
            <td>Created</td>
            <td>{{ $contractor->C_Created }}</td>
        </tr>
        <tr>
            <td>Updated</td>
            <td>{{ $contractor->C_Updated }}</td>
        </tr>
    </table>

    <br />


    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            contractor
            @php unset($contractor->C_Password); @endphp
            @php dump(@$contractor) @endphp
        </div>
    @endif

    <br />
    <br />
    <br />

</x-user-layout>
