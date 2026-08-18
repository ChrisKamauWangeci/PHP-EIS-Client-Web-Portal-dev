<x-admin-layout title="">

    <h1>Changelogs</h1>

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('admin.changelogs.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="title" label="Title" :value="request('title')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.changelogs.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $changelogs->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'released_at', 'sort_direction' => $sort_direction]) }}">Release Date</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'title', 'sort_direction' => $sort_direction]) }}">Title</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'is_active', 'sort_direction' => $sort_direction]) }}">Active</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_by', 'sort_direction' => $sort_direction]) }}">Created By</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_by', 'sort_direction' => $sort_direction]) }}">Updated By</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created At</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_at', 'sort_direction' => $sort_direction]) }}">Updated At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($changelogs as $changelog)
                    <tr>
                        <td>{{ $changelog->released_at }}</td>
                        <td>{{ $changelog->title }} </td>
                        <td><img src="/img/icon_{{ $changelog->is_active }}.png" alt=""></td>
                        <td>{{ $changelog->created_by }}</td>
                        <td>{{ $changelog->updated_by }}</td>
                        <td>{{ $changelog->created_at }}</td>
                        <td>{{ $changelog->updated_at }}</td>
                        <td>
                            <a href="{{ route('admin.changelogs.show', $changelog->id ) }}" class="btn btn-xs btn-secondary">View</a>
                            <a href="{{ route('admin.changelogs.edit', $changelog->id ) }}" class="btn btn-xs btn-secondary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $changelogs->withQueryString()->links() }}

    <br />

    <a href="{{ route('admin.changelogs.create') }}" class="btn btn-sm btn-secondary">Add</a>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            changelogs
            @php dump(@$changelogs) @endphp
        </div>
    @endif

</x-admin-layout>