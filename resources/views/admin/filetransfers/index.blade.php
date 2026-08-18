<x-admin-layout title="">

    <h1>File Transfer</h1>

    <form method="GET" action="{{ route('admin.filetransfers.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input type="number" name="workorder_id" label="Workorder ID" :value="request('workorder_id')" autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="direction" label="Direction" :value="request('direction')" autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="file_type" label="File Type" :value="request('file_type')" autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="filename" label="Filename" :value="request('filename')" autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <button class="btn btn-sm btn-secondary" type="submit">Search</button> <a href="{{ route('admin.filetransfers.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $filetransfers->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_id', 'sort_direction' => $sort_direction]) }}">Workorder ID</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'direction', 'sort_direction' => $sort_direction]) }}">Direction</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'file_type', 'sort_direction' => $sort_direction]) }}">File Type</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'filename', 'sort_direction' => $sort_direction]) }}">Filename</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'contractor', 'sort_direction' => $sort_direction]) }}">Contractor</a></th>
                    <th>
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'ip_address', 'sort_direction' => $sort_direction]) }}">IP Address</a>
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'remote_host', 'sort_direction' => $sort_direction]) }}">Remote Host</a>
                    </th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($filetransfers as $filetransfer)
                    <tr>
                        <td>{{ $filetransfer->workorder_id }}</td>
                        <td>{{ $filetransfer->direction }}</td>
                        <td>{{ $filetransfer->file_type }}</td>
                        <td>{{ $filetransfer->filename }}</td>
                        <td>{{ $filetransfer->contractor }}</td>
                        <td>
                            {{ $filetransfer->ip_address }}
                            <br />
                            {{ $filetransfer->remote_host }}
                        </td>
                        <td nowrap>{{ $filetransfer->created_at }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.filetransfers.show', $filetransfer->id) }}" class="btn btn-xs btn-secondary">view</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $filetransfers->withQueryString()->links() }}

    <br />
    <br />

</x-admin-layout>