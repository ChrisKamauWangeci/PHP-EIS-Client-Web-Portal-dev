<x-admin-layout title="">

    <h1>Edit Permission</h1>

    <form action="{{ route('admin.permissions.update', $permission) }}"
          method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Permission Name</label>
            <input type="text"
                   name="name"
                   value="{{ $permission->name }}"
                   class="form-control"
                   required>
        </div>

        <button class="btn btn-sm btn-secondary">Save Changes</button>
    </form>

</x-admin-layout>
