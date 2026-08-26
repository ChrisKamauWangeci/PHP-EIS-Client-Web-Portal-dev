<x-admin-layout>

    <style>
        .ql-editor p {
            margin-bottom: 0;
        }
    </style>

    <div class="row">
        <div class="col-auto">
            <h1>Changelog</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.changelogs.index') }}"
               class="btn btn-sm btn-secondary">View Changelogs</a>
        </div>
    </div>

    <br />

    <table class="table table-bordered table-sm w-auto">
        <tr>
            <td>Id</td>
            <td>{{ $changelog->id }}</td>
        </tr>
        <tr>
            <td>Release Date</td>
            <td>{{ $changelog->released_at }}</td>
        </tr>
        <tr>
            <td>Title</td>
            <td>{{ $changelog->title }}</td>
        </tr>
        <tr>
            <td>Description</td>
            <td>
                <div class="ql-editor">
                    {!! $changelog->description !!}
                </div>
            </td>
        </tr>
        <tr>
            <td>Is Active</td>
            <td><img src="/img/icon_{{ $changelog->is_active }}.png"
                     alt=""></td>
        </tr>
        <tr>
            <td>Created By</td>
            <td>{{ $changelog->created_by }}</td>
        </tr>
        <tr>
            <td>Updated By</td>
            <td>{{ $changelog->updated_by }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $changelog->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $changelog->updated_at }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('admin.changelogs.edit', $changelog->id) }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <form method="POST"
          action="{{ route('admin.changelogs.destroy', $changelog->id) }}">
        @csrf
        @method('DELETE')
        <x-form.button class="btn-danger"
                       onclick="return confirm('Are you sure?')">Delete</x-form.button>
    </form>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            changelog
            @php dump(@$changelog) @endphp
        </div>
    @endif

    <br />
    <br />


</x-admin-layout>
