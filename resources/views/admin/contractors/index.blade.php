<x-admin-layout title="">

    <h1>Contractors</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('admin.contractors.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="C_Name"
                              label="Name"
                              :value="request('C_Name')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="C_Email"
                              label="Email"
                              :value="request('C_Email')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.select name="C_Location"
                               label="Location"
                               :options="Helper::locations()"
                               empty="-"
                               :default="request('C_Location')"
                               maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.select name="C_SysAdmin"
                               label="Admin"
                               :options="['' => 'All', '1' => 'Yes', '0' => 'No']"
                               :default="request('C_SysAdmin')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.select name="accesslevel"
                               label="Access Level"
                               :options="['' => 'All', '1' => 'Yes', '0' => 'No']"
                               :default="request('accesslevel')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.select name="C_Caller"
                               label="Caller"
                               :options="['' => 'All', '1' => 'Yes', '0' => 'No']"
                               :default="request('C_Caller')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.select name="is_active"
                               label="Is Active"
                               :options="['' => 'All', '1' => 'Yes', '0' => 'No']"
                               :default="request('is_active')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.contractors.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $contractors->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_Name', 'sort_direction' => $sort_direction]) }}">Name</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_Email', 'sort_direction' => $sort_direction]) }}">Email</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_Location', 'sort_direction' => $sort_direction]) }}">Location</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_SysAdmin', 'sort_direction' => $sort_direction]) }}">Admin</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'accesslevel', 'sort_direction' => $sort_direction]) }}">Access
                            Level</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_Caller', 'sort_direction' => $sort_direction]) }}">Caller</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'access_files', 'sort_direction' => $sort_direction]) }}">Files</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'is_active', 'sort_direction' => $sort_direction]) }}">Active</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_LastLogin', 'sort_direction' => $sort_direction]) }}">Last
                            Login</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_Updated', 'sort_direction' => $sort_direction]) }}">Updated</a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contractors as $contractor)
                    <tr>
                        <td>{{ $contractor->C_Name }}</td>
                        <td>{{ $contractor->C_Email }}</td>
                        <td>{{ $contractor->C_Location }}</td>
                        <td><img src="/img/icon_{{ $contractor->C_SysAdmin }}.png"
                                 alt=""></td>
                        <td><img src="/img/icon_{{ $contractor->accesslevel }}.png"
                                 alt=""></td>
                        <td><img src="/img/icon_{{ $contractor->C_Caller }}.png"
                                 alt=""></td>
                        <td><img src="/img/icon_{{ $contractor->access_files }}.png"
                                 alt=""></td>
                        <td><img src="/img/icon_{{ $contractor->is_active }}.png"
                                 alt=""></td>
                        <td nowrap>{{ $contractor->C_LastLogin }}</td>
                        <td nowrap>{{ $contractor->C_Updated }}</td>
                        <td nowrap>
                            <a href="{{ route('admin.contractors.show', $contractor->id) }}"
                               class="btn btn-xs btn-secondary">View</a>
                            <a href="{{ route('admin.contractors.edit', $contractor->id) }}"
                               class="btn btn-xs btn-secondary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $contractors->withQueryString()->links() }}

    <br />

    <br />
    <br />

    @if ($adminsession['contractor']['accesslevel'])
        <a href="{{ route('admin.contractors.create') }}"
           class="btn btn-sm btn-secondary">Add</a>
    @endif

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            contractors
            @php dump(@$contractors) @endphp
        </div>
    @endif

</x-admin-layout>
