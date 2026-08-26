<x-admin-layout title="">

    <h1>Roles</h1>

    <table class="table table-sm table-striped table-bordered w-auto">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Permissions</th>
                <th>Contractors</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td class="small">
                        @foreach ($role->permissions as $permission)
                            {{ $permission->name }}<br />
                        @endforeach
                    </td>
                    <td class="small">
                        @foreach ($role->users as $contractor)
                            <a
                               href="{{ route('admin.contractors.show', $contractor->id) }}">{{ $contractor->C_Name }}</a>
                            <br />
                        @endforeach
                    </td>
                    <td nowrap>{{ $role->created_at }}</td>
                    <td nowrap>{{ $role->updated_at }}</td>
                    <td nowrap>
                        <a class="btn btn-xs btn-secondary"
                           href="{{ route('admin.roles.show', $role) }}">Show</a>
                        <a class="btn btn-xs btn-secondary"
                           href="{{ route('admin.roles.edit', $role) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br />

    <a href="{{ route('admin.roles.create') }}"
       class="btn btn-sm btn-secondary">Create Role</a>

    <br />

</x-admin-layout>
