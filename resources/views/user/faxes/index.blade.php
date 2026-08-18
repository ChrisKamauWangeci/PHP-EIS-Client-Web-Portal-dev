<x-user-layout title="">

    <h1>Faxes</h1>

    <form method="GET" accept-charset="utf-8" id="searchform" action="{{ route('user.faxes.index') }}">

        <input type="hidden" name="search" value="1">
        <input type="hidden" name="type" value="all">

        <div class="row">

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="workorder" id="workorder" label="Workorder ID" :value="request('workorder')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="fax_number" id="fax_number" label="Fax Number" :value="request('fax_number')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="file" id="file" label="File" :value="request('file')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="email" id="email" label="Email" :value="request('email')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="api_status" id="api_status" label="API Status" :value="request('api_status')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <br />
                <x-form.button>Search</x-form.button>

                <a href="{{ route('user.faxes.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $faxes->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">ID</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'client', 'sort_direction' => $sort_direction]) }}">Client</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder', 'sort_direction' => $sort_direction]) }}">Workorder</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'fax_number', 'sort_direction' => $sort_direction]) }}">Fax Number</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'email', 'sort_direction' => $sort_direction]) }}">Email</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'file', 'sort_direction' => $sort_direction]) }}">File</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'api_status', 'sort_direction' => $sort_direction]) }}">API Status</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($faxes as $fax)
                    <tr>
                        <td>{{ $fax->id }}</td>
                        <td>{{ $fax->client }}</td>
                        <td>{{ $fax->workorder }}</td>
                        <td>{{ $fax->fax_number }}</td>
                        <td>{{ $fax->email }}</td>
                        <td>{{ $fax->file }}</td>
                        <td>{{ $fax->api_status }}</td>
                        <td>{{ $fax->created_at }}</td>
                        <td class="actions">
                            <a href="{{ route('user.faxes.show', $fax->id) }}">view</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $faxes->withQueryString()->links() }}

    <br />
    <br />

</x-user-layout>