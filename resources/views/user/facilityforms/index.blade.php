<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Facility Forms</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('user.facilityforms.create') }}"
               class="btn btn-sm btn-secondary">New</a>
        </div>
    </div>

    <br />

    <form method="GET"
          action="{{ route('user.facilityforms.index') }}">

        <input type="hidden"
               name="search"
               value="1">
        <input type="hidden"
               name="type"
               value="all">

        <div class="row">

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="name"
                              id="name"
                              label="Name"
                              :value="request('name')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="file_name"
                              id="file_name"
                              label="File Name"
                              :value="request('file_name')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="docusign_templateid_production"
                              id="docusign_templateid_production"
                              label="DS Template ID Prod"
                              :value="request('docusign_templateid_production')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="created_by"
                              id="created_by"
                              label="Created By"
                              :value="request('created_by')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="updated_by"
                              id="updated_by"
                              label="Updated By"
                              :value="request('updated_by')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.facilityforms.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $facilityforms->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'name', 'sort_direction' => $sort_direction]) }}">Name</a>
                    </th>
                    <th>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'slug', 'sort_direction' => $sort_direction]) }}">Slug</a>
                        <br />
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'file_name', 'sort_direction' => $sort_direction]) }}">File
                            Name</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'internal_form', 'sort_direction' => $sort_direction]) }}">Internal
                            Form</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'usage_count', 'sort_direction' => $sort_direction]) }}">Usage
                            Count</a></th>
                    <th>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_by', 'sort_direction' => $sort_direction]) }}">Created
                            By</a>
                        <br />
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_by', 'sort_direction' => $sort_direction]) }}">Updated
                            By</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created
                            At</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_at', 'sort_direction' => $sort_direction]) }}">Updated
                            At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($facilityforms as $facilityform)
                    <tr>
                        <td>{{ $facilityform->name }}</td>
                        <td>
                            {{ $facilityform->slug }}
                            <br />
                            {{ $facilityform->file_name }}
                        </td>
                        <td><img src="/img/icon_{{ $facilityform->internal_form }}.png"
                                 alt=""></td>
                        <td>{{ $facilityform->usage_count }}</td>
                        <td>
                            {{ $facilityform->created_by }}
                            <br />
                            {{ $facilityform->updated_by }}
                        </td>
                        <td>{{ $facilityform->created_at }}</td>
                        <td>{{ $facilityform->updated_at }}</td>
                        <td class="actions">
                            <a href="{{ route('user.facilityforms.show', $facilityform->id) }}"
                               class="btn btn-xs btn-secondary">view</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $facilityforms->withQueryString()->links() }}

    <br />
    <br />

</x-user-layout>
