<x-admin-layout title="">

    <h1>Edit Role</h1>

    <form action="{{ route('admin.roles.update', $role) }}"
          method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Role Name</label>
            <input type="text"
                   name="name"
                   value="{{ $role->name }}"
                   class="form-control"
                   required>
        </div>

        <h3 class="mt-4">Permissions</h3>

        <div class="row">
            @foreach ($permissions as $p)
                <div class="col-md-3">
                    <label>
                        <input type="checkbox"
                               name="permissions[]"
                               value="{{ $p->name }}"
                               {{ in_array($p->id, $rolePermissions) ? 'checked' : '' }}>
                        {{ $p->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <br />

        <button class="btn btn-sm btn-secondary">Save Changes</button>

    </form>

</x-admin-layout>
