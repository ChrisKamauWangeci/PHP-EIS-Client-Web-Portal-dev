<x-user-layout title="">

    <h1>Request Logs</h1>

    <form method="GET" action="{{ route('user.requestlogs.index') }}">

        <div class="row">

            <div class="col-md-2">
                <x-form.input name="workorder_id" id="workorder_id" label="workorder_id" :value="request('workorder_id')" />
            </div>

            <div class="col-md-2">
                <x-form.input name="request_type" id="request_type" label="request_type" :value="request('request_type')" />
            </div>

            <div class="col-md-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.requestlogs.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />

    {{ $requestlogs->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">id</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_id', 'sort_direction' => $sort_direction]) }}">workorder_id</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'request_type', 'sort_direction' => $sort_direction]) }}">request_type</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'status', 'sort_direction' => $sort_direction]) }}">status</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'notes', 'sort_direction' => $sort_direction]) }}">notes</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_by', 'sort_direction' => $sort_direction]) }}">created_by</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_by', 'sort_direction' => $sort_direction]) }}">updated_by</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">created_at</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_at', 'sort_direction' => $sort_direction]) }}">updated_at</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requestlogs as $requestlog)
                    <tr>
                        <td>{{ $requestlog->id }}</td>
                        <td>{{ $requestlog->workorder_id }}</td>
                        <td>{{ $requestlog->request_type }}</td>
                        <td>{{ $requestlog->status }}</td>
                        <td>{{ $requestlog->notes }}</td>
                        <td>{{ $requestlog->created_by }}</td>
                        <td>{{ $requestlog->updated_by }}</td>
                        <td>{{ $requestlog->created_at }}</td>
                        <td>{{ $requestlog->updated_at }}</td>
                        <td class="actions">
                            <a href="{{ route('user.requestlogs.show', $requestlog->id) }}" class="btn btn-xs btn-secondary">view</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $requestlogs->withQueryString()->links() }}

    <br />

    <a href="{{ route('user.requestlogs.create') }}" class="btn btn-sm btn-secondary">New</a>

    <br />

</x-user-layout>