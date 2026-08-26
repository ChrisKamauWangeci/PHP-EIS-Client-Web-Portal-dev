<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Purge Config</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.purge_configs.index') }}"
               class="btn btn-sm btn-secondary">View Purge Configs</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $purgeConfig->id }}</td>
        </tr>
        <tr>
            <td>Company Name</td>
            <td>{{ $purgeConfig->company_name }}</td>
        </tr>
        <tr>
            <td>Folder Name</td>
            <td>{{ $purgeConfig->folder_name }}</td>
        </tr>
        <tr>
            <td>Source Path</td>
            <td>{{ $purgeConfig->source_path }}</td>
        </tr>
        <tr>
            <td>Destination Path</td>
            <td>{{ $purgeConfig->destination_path }}</td>
        </tr>
        <tr>
            <td>Frequency</td>
            <td>{{ $purgeConfig->frequency }}</td>
        </tr>
        <tr>
            <td>Purge After Days</td>
            <td>{{ $purgeConfig->purge_after_days }}</td>
        </tr>
        <tr>
            <td>Purge Type</td>
            <td>{{ $purgeConfig->purge_type }}</td>
        </tr>
        <tr>
            <td>Last Purge Date</td>
            <td>{{ $purgeConfig->last_purge_date }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $purgeConfig->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $purgeConfig->updated_at }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('user.purge_configs.edit', $purgeConfig->id) }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <form method="POST"
          action="{{ route('user.purge_configs.destroy', $purgeConfig->id) }}">
        @csrf
        @method('DELETE')
        <x-form.button class="btn btn-sm btn-danger"
                       onclick="return confirm('Are you sure?')">Delete</x-form.button>
    </form>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            purgeConfig
            @php dump(@$purgeConfig) @endphp
        </div>
    @endif

    <br />
    <br />

</x-user-layout>
