<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Websiteconfig</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.websiteconfigs.index') }}" class="btn btn-sm btn-secondary">View Websiteconfigs</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $websiteconfig->id }}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{ $websiteconfig->name }}</td>
        </tr>
        <tr>
            <td>Show Order</td>
            <td><img src="/img/icon_{{ $websiteconfig->show_order }}.png" alt=""></td>
        </tr>
        <tr>
            <td>Show Facilities</td>
            <td><img src="/img/icon_{{ $websiteconfig->show_facilities }}.png" alt=""></td>
        </tr>
        <tr>
            <td>Show Files</td>
            <td><img src="/img/icon_{{ $websiteconfig->show_files }}.png" alt=""></td>
        </tr>
        <tr>
            <td>Show Reports</td>
            <td><img src="/img/icon_{{ $websiteconfig->show_reports }}.png" alt=""></td>
        </tr>
        <tr>
            <td>Show Forms</td>
            <td><img src="/img/icon_{{ $websiteconfig->show_forms }}.png" alt=""></td>
        </tr>
        <tr>
            <td>Show Requestors</td>
            <td><img src="/img/icon_{{ $websiteconfig->show_requestors }}.png" alt=""></td>
        </tr>
        <tr>
            <td>Show Contact Manager</td>
            <td><img src="/img/icon_{{ $websiteconfig->show_contactmanager }}.png" alt=""></td>
        </tr>
        <tr>
            <td>Workorders Show All Requestors</td>
            <td><img src="/img/icon_{{ $websiteconfig->workorders_show_all_requestors }}.png" alt=""></td>
        </tr>
        <tr>
            <td>Workorder Inquiry</td>
            <td><img src="/img/icon_{{ $websiteconfig->workorder_inquiry }}.png" alt=""></td>
        </tr>
        <tr>
            <td>Workorder Upload Auth</td>
            <td><img src="/img/icon_{{ $websiteconfig->workorder_upload_auth }}.png" alt=""></td>
        </tr>
        <tr>
            <td>Workorder Upload APS</td>
            <td><img src="/img/icon_{{ $websiteconfig->workorder_upload_aps }}.png" alt=""></td>
        </tr>
        <tr>
            <td>Workorder Additional Files</td>
            <td><img src="/img/icon_{{ $websiteconfig->workorder_additional_files }}.png" alt=""></td>
        </tr>
        <tr>
            <td>Created By</td>
            <td>{{ $websiteconfig->created_by }}</td>
        </tr>
        <tr>
            <td>Updated By</td>
            <td>{{ $websiteconfig->updated_by }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $websiteconfig->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $websiteconfig->updated_at }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('admin.websiteconfigs.edit', $websiteconfig->id) }}" class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>R_ID</th>
                    <th>Company</th>
                    <th>Name</th>
                    <th>Login</th>
                    <th>Email</th>
                    <th>Login Last</th>
                    <th>Is Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requestors as $requestor)
                    <tr>
                        <td>{{ $requestor->R_ID }} </td>
                        <td>{{ $requestor->R_Company }}</td>
                        <td>{{ $requestor->R_Name }}</td>
                        <td>{{ $requestor->R_LoginEmail }}</td>
                        <td>{{ $requestor->R_Email }}</td>
                        <td nowrap>{{ $requestor->login_last }}</td>
                        <td><img src="/img/icon_{{ $requestor->R_Active }}.png" alt=""></td>
                        <td><a href="{{ route('admin.requestors.show', $requestor ) }}" class="btn btn-xs btn-secondary">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            websiteconfig
            @php dump(@$websiteconfig) @endphp
        </div>
    @endif

</x-admin-layout>