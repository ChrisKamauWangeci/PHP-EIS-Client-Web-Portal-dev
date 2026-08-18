<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Contractor</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.contractors.index') }}" class="btn btn-sm btn-secondary">View Contractors</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $contractor->id }}</td>
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
            <td>Name</td>
            <td>{{ $contractor->C_Name }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $contractor->C_Email }}</td>
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
            <td>Cell</td>
            <td>{{ $contractor->C_Cell }}</td>
        </tr>
        <tr>
            <td>Fax</td>
            <td>{{ $contractor->C_Fax }}</td>
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
            <td>Is Admin</td>
            <td>
                <img src="/img/icon_{{ $contractor->C_SysAdmin }}.png" alt="">
                {{ $contractor->C_SysAdmin }}
            </td>
        </tr>
        <tr>
            <td>Is Caller</td>
            <td>
                <img src="/img/icon_{{ $contractor->C_Caller }}.png" alt="">
                {{ $contractor->C_Caller }}
            </td>
        </tr>
        <tr>
            <td>Is Active</td>
            <td>
                <img src="/img/icon_{{ $contractor->is_active }}.png" alt="">
                {{ $contractor->is_active }}
            </td>
        </tr>
        <tr>
            <td>Access Level</td>
            <td>
                <img src="/img/icon_{{ $contractor->accesslevel }}.png" alt="">
                {{ $contractor->accesslevel }}
            </td>
        </tr>
        <tr>
            <td>Access Files</td>
            <td>
                <img src="/img/icon_{{ $contractor->access_files }}.png" alt="">
                {{ $contractor->access_files }}
            </td>
        </tr>
        <tr>
            <td>Access MFA</td>
            <td>
                <img src="/img/icon_{{ $contractor->access_mfa }}.png" alt="">
                {{ $contractor->access_mfa }}
            </td>
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

    <a href="{{ route('admin.contractors.edit', $contractor->id) }}" class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <a href="{{ route('admin.contractors.password', $contractor->id) }}" class="btn btn-sm btn-secondary">Change Password</a>

    <br />
    <br />

    Workorders Count Owner: {{ $workordersownercount }}

    <br />

    Workorders Count Contractor: {{ $workorderscontractorcount }}

    <br />
    <br />

    @if (!$workordersownercount && !$workorderscontractorcount)

        {{-- <form method="POST" action="{{ route('admin.contractors.destroy', $contractor->id) }}">
            @csrf
            @method('DELETE')
            <x-form.button class="btn-danger" onclick="return confirm('Are you sure?')">Delete</x-form.button>
        </form> --}}

    @endif

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            contractor
            @php unset($contractor->C_Password); @endphp
            @php dump(@$contractor) @endphp
            @php dump(@$contractorprofile) @endphp
        </div>
    @endif

    <br />
    <br />
    <br />

</x-admin-layout>