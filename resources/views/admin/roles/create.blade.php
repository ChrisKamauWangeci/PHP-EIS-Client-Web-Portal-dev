<x-admin-layout title="">

    <h1>Create Role</h1>

    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Role Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <h3 class="mt-4">Assign Permissions</h3>
        <div class="row">
            @foreach ($permissions as $p)
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $p->name }}">
                        {{ $p->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button class="btn btn-success mt-3">Create</button>
    </form>

</x-admin-layout>
