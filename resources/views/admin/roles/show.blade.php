<x-admin-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Role</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-secondary">View Roles</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $role->id }}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{ $role->name }}</td>
        </tr>
        <tr>
            <td>Permissions</td>
            <td>
                @foreach ($role->permissions as $permission)
                    {{ $permission->name }}
                    <br />
                @endforeach
            </td>
        </tr>
        <tr>
            <td>Contractors</td>
            <td>
                @foreach ($role->users as $contractor)
                    <a href="{{ route('admin.contractors.show', $contractor->id) }}">{{ $contractor->C_Name }}</a>
                    <br />
                @endforeach
            </td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $role->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $role->updated_at }}</td>
        </tr>
    </table>

    <br />

    <a class="btn btn-sm btn-secondary" href="{{ route('admin.roles.edit', $role) }}">Edit</a>

    <br />
    <br />

    @if ($role->users->isEmpty())
        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
        </form>
    @endif

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            role
            @php dump(@$role) @endphp
        </div>
    @endif

    <br />
    <br />
    <br />

</x-admin-layout>
