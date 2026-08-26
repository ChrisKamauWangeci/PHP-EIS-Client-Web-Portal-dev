<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Requestor</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.requestors.index') }}"
               class="btn btn-sm btn-secondary">View Requestors</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $requestor->R_ID }}</td>
        </tr>
        <tr>
            <td>Company</td>
            <td><a
                   href="{{ route('admin.requestors.index', ['R_Company' => $requestor->R_Company]) }}">{{ $requestor->R_Company }}</a>
            </td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{ $requestor->R_Name }}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{ $requestor->R_Phone }}</td>
        </tr>
        <tr>
            <td>Phone Ext</td>
            <td>{{ $requestor->R_PhoneExt }}</td>
        </tr>
        <tr>
            <td>Cell</td>
            <td>{{ $requestor->R_Cell }}</td>
        </tr>
        <tr>
            <td>Fax</td>
            <td>{{ $requestor->R_Fax }}</td>
        </tr>
        <tr>
            <td>Login</td>
            <td>{{ $requestor->R_LoginEmail }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $requestor->R_Email }}</td>
        </tr>
        <tr>
            <td>SSO ID</td>
            <td>{{ $requestor->R_SSOID }}</td>
        </tr>
        <tr>
            <td>Active</td>
            <td><img src="/img/icon_{{ $requestor->R_Active }}.png"
                     alt=""></td>
        </tr>
        <tr>
            <td>Super User</td>
            <td><img src="/img/icon_{{ $requestor->R_SuperUser }}.png"
                     alt=""></td>
        </tr>
        <tr>
            <td>Confirm Email</td>
            <td><img src="/img/icon_{{ $requestor->R_ConfirmEmail }}.png"
                     alt=""></td>
        </tr>
        <tr>
            <td>Status Email Audit</td>
            <td>{{ $requestor->R_StatusEmailAudit }}</td>
        </tr>
        <tr>
            <td>View Records</td>
            <td><img src="/img/icon_{{ $requestor->R_ViewRecords }}.png"
                     alt=""></td>
        </tr>
        <tr>
            <td>No Order</td>
            <td><img src="/img/icon_{{ $requestor->R_NoOrder }}.png"
                     alt=""></td>
        </tr>
        <tr>
            <td>Password Last Changed</td>
            <td>{{ $requestor->R_PWDate }}</td>
        </tr>
        <tr>
            <td><a href="{{ route('admin.requestorroles.index') }}">Requestor Role ID</a></td>
            <td>{{ $requestor->requestorrole_id }} - {{ $requestor->requestorrole?->name }}</td>
        </tr>
        <tr>
            <td><a href="{{ route('admin.websiteconfigs.index') }}">Website Config ID</a></td>
            <td>{{ $requestor->websiteconfig_id }} - {{ $requestor->websiteconfig?->name }}</td>
        </tr>
        <tr>
            <td>Login Last</td>
            <td>{{ $requestor->login_last }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $requestor->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $requestor->updated_at }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('admin.requestors.edit', $requestor->R_ID) }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <a href="{{ route('admin.requestors.password', $requestor->R_ID) }}"
       class="btn btn-sm btn-secondary">Change Password</a>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            requestor
            @php dump(@$requestor) @endphp
        </div>
    @endif

</x-admin-layout>
