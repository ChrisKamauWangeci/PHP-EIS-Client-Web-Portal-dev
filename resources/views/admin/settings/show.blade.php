<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Setting</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.settings.index') }}"
               class="btn btn-sm btn-secondary">View Settings</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm w-auto">
        <tr>
            <th>ID</th>
            <td>{{ $setting->id }}</td>
        </tr>
        <tr>
            <th>Category</th>
            <td>{{ $setting->category }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $setting->name }}</td>
        </tr>
        <tr>
            <th>Value</th>
            <td>{{ $setting->value }}</td>
        </tr>
        <tr>
            <th>Created By</th>
            <td>{{ $setting->created_by }}</td>
        </tr>
        <tr>
            <th>Updated By</th>
            <td>{{ $setting->updated_by }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $setting->created_at }}</td>
        </tr>
        <tr>
            <th>Updated At</th>
            <td>{{ $setting->updated_at }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('admin.settings.edit', $setting->id) }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <form method="POST"
          action="{{ route('admin.settings.destroy', $setting->id) }}">
        @csrf
        @method('DELETE')
        <x-form.button class="btn btn-sm btn-danger"
                       onclick="return confirm('Are you sure?')">Delete</x-form.button>
    </form>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            setting
            @php dump(@$setting) @endphp
        </div>
    @endif

</x-admin-layout>
