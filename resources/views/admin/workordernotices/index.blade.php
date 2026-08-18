<x-admin-layout title="">

    <h1>Workorder Notices</h1>

    <form method="get" action="{{ route('admin.workordernotices.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="workorder_id" label="Workorder ID" :value="request('workorder_id')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="recipient" label="Recipient" :value="request('recipient')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.workordernotices.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $workordernotices->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">ID</a></th>
                <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_id', 'sort_direction' => $sort_direction]) }}">Workorder ID</a></th>
                <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'user_before', 'sort_direction' => $sort_direction]) }}">User Before</a></th>
                <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'user_after', 'sort_direction' => $sort_direction]) }}">User After</a></th>
                <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'recipient', 'sort_direction' => $sort_direction]) }}">Recipient</a></th>
                <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_by', 'sort_direction' => $sort_direction]) }}">Created By</a></th>
                <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_by', 'sort_direction' => $sort_direction]) }}">Updated By</a></th>
                <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created At</a></th>
                <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_at', 'sort_direction' => $sort_direction]) }}">Updated At</a></th>
                <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workordernotices as $workordernotice)
                    <tr>
                        <td>{{ $workordernotice->id }}</td>
                        <td>{{ $workordernotice->workorder_id }}</td>
                        <td>{{ $workordernotice->user_before }}</td>
                        <td>{{ $workordernotice->user_after }}</td>
                        <td>{{ $workordernotice->recipient }}</td>
                        <td>{{ $workordernotice->created_by }}</td>
                        <td>{{ $workordernotice->updated_by }}</td>
                        <td>{{ $workordernotice->created_at }}</td>
                        <td>{{ $workordernotice->updated_at }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.workordernotices.show', $workordernotice->id) }}" class="btn btn-xs btn-secondary">view</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $workordernotices->withQueryString()->links() }}

    <br />
    <br />

    <a href="{{ route('admin.workordernotices.create') }}" class="btn btn-sm btn-secondary">Add</a>

    <br />
    <br />

</x-admin-layout>