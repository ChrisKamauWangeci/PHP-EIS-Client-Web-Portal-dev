<x-admin-layout title="">

    <h1>Website Configs</h1>

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('admin.websiteconfigs.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="name" label="Name" :value="request('name')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.websiteconfigs.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $websiteconfigs->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">ID</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'name', 'sort_direction' => $sort_direction]) }}">Name</a></th>

                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'show_order', 'sort_direction' => $sort_direction]) }}" class="" title="show_order">Order</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'show_facilities', 'sort_direction' => $sort_direction]) }}" class="" title="show_facilities">Facilities</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'show_files', 'sort_direction' => $sort_direction]) }}" class="" title="show_files">Files</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'show_forms', 'sort_direction' => $sort_direction]) }}" class="" title="show_forms">Forms</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'show_reports', 'sort_direction' => $sort_direction]) }}" class="" title="show_reports">Reports</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'show_requestors', 'sort_direction' => $sort_direction]) }}" class="" title="show_requestors">Requestors</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'show_contactmanager', 'sort_direction' => $sort_direction]) }}" class="" title="show_contactmanager">Contact Manager</a></th>

                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorders_show_all_requestors', 'sort_direction' => $sort_direction]) }}" class="" title="workorders_show_all_requestors">?</a></th>

                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_inquiry', 'sort_direction' => $sort_direction]) }}" class="" title="workorder_inquiry">?</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_upload_auth', 'sort_direction' => $sort_direction]) }}" class="" title="workorder_upload_auth">?</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_upload_aps', 'sort_direction' => $sort_direction]) }}" class="" title="workorder_upload_aps">?</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_additional_files', 'sort_direction' => $sort_direction]) }}" class="" title="workorder_additional_files">?</a></th>

                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created At</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_at', 'sort_direction' => $sort_direction]) }}">Updated At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($websiteconfigs as $websiteconfig)
                    <tr>
                        <td>{{ $websiteconfig->id }}</td>
                        <td>{{ $websiteconfig->name }}</td>
                        <td><img src="/img/icon_{{ $websiteconfig->show_order }}.png" alt=""></td>
                        <td><img src="/img/icon_{{ $websiteconfig->show_facilities }}.png" alt=""></td>
                        <td><img src="/img/icon_{{ $websiteconfig->show_files }}.png" alt=""></td>
                        <td><img src="/img/icon_{{ $websiteconfig->show_forms }}.png" alt=""></td>
                        <td><img src="/img/icon_{{ $websiteconfig->show_reports }}.png" alt=""></td>
                        <td><img src="/img/icon_{{ $websiteconfig->show_requestors }}.png" alt=""></td>
                        <td><img src="/img/icon_{{ $websiteconfig->show_contactmanager }}.png" alt=""></td>

                        <td><img src="/img/icon_{{ $websiteconfig->workorders_show_all_requestors }}.png" alt=""></td>

                        <td><img src="/img/icon_{{ $websiteconfig->workorder_inquiry }}.png" alt=""></td>
                        <td><img src="/img/icon_{{ $websiteconfig->workorder_upload_auth }}.png" alt=""></td>
                        <td><img src="/img/icon_{{ $websiteconfig->workorder_upload_aps }}.png" alt=""></td>
                        <td><img src="/img/icon_{{ $websiteconfig->workorder_additional_files }}.png" alt=""></td>

                        <td>{{ $websiteconfig->created_at }}</td>
                        <td>{{ $websiteconfig->updated_at }}</td>
                        <td>
                            <a href="{{ route('admin.websiteconfigs.edit', $websiteconfig->id ) }}" class="btn btn-xs btn-secondary">Edit</a>
                            <a href="{{ route('admin.websiteconfigs.show', $websiteconfig->id ) }}" class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $websiteconfigs->withQueryString()->links() }}

    <br />

    <br />
    <br />

    @if ($adminsession['contractor']['accesslevel'])
        <a href="{{ route('admin.websiteconfigs.create') }}" class="btn btn-sm btn-secondary">Add</a>
    @endif

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            websiteconfigs
            @php dump(@$websiteconfigs) @endphp
        </div>
    @endif

</x-admin-layout>