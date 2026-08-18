<x-admin-layout title="">

    <h1>Create Permission</h1>

    <form action="{{ route('admin.permissions.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Permission Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <button class="btn btn-sm btn-secondary">Create</button>
    </form>

</x-admin-layout>
