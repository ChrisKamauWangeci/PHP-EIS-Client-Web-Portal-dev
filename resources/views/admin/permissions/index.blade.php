<x-admin-layout title="">

    <h1>Permissions</h1>

    <table class="table table-bordered table-striped w-auto">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
            <tr>
                <td>{{ $permission->id }}</td>
                <td>{{ $permission->name }}</td>
                <td>{{ $permission->created_at }}</td>
                <td>{{ $permission->updated_at }}</td>
                <td nowrap>
                    <a class="btn btn-xs btn-secondary" href="{{ route('admin.permissions.edit', $permission) }}">Edit</a>
                    <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-xs btn-danger" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br />

    <a href="{{ route('admin.permissions.create') }}" class="btn btn-sm btn-secondary">Create Permission</a>

</x-admin-layout>