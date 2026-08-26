<x-admin-layout>

    <h1>Company Update</h1>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $companyupdate->id }}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{ $companyupdate->name }}</td>
        </tr>
        <tr>
            <td>Filename</td>
            <td>{{ $companyupdate->filename }}</td>
        </tr>
        <tr>
            <td>Created By</td>
            <td>{{ $companyupdate->created_by }}</td>
        </tr>
        <tr>
            <td>Updated By</td>
            <td>{{ $companyupdate->updated_by }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $companyupdate->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $companyupdate->updated_at }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('admin.companyupdates.index') }}"
       class="btn btn-sm btn-secondary">Company Updates</a>

    <br />
    <br />

    <a href="{{ route('admin.companyupdates.edit', $companyupdate->id) }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <form method="POST"
          action="{{ route('admin.companyupdates.destroy', $companyupdate->id) }}">
        @csrf
        @method('DELETE')
        <x-form.button class="btn-danger"
                       onclick="return confirm('Are you sure?')">Delete</x-form.button>
    </form>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            companyupdate
            @php dump(@$companyupdate) @endphp
        </div>
    @endif

    <br />
    <br />
    <br />

</x-admin-layout>
