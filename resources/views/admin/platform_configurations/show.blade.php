<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Platform Configuration</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.platform-configurations.index') }}"
               class="btn btn-sm btn-secondary">View Platform Configurations</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm w-auto">
        <tr>
            <th>ID</th>
            <td>{{ $platformConfiguration->id }}</td>
        </tr>
        <tr>
            <th>Company</th>
            <td>{{ $platformConfiguration->company }}</td>
        </tr>
        <tr>
            <th>Platform</th>
            <td>{{ $platformConfiguration->platform }}</td>
        </tr>
        <tr>
            <th>Order Type</th>
            <td>{{ $platformConfiguration->order_type }}</td>
        </tr>
        <tr>
            <th>Submission Type</th>
            <td>{{ $platformConfiguration->submission_type }}</td>
        </tr>
        <tr>
            <th>Wait Days</th>
            <td>{{ $platformConfiguration->wait_days ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Sequence</th>
            <td>{{ $platformConfiguration->sequence }}</td>
        </tr>
        <tr>
            <th>Active</th>
            <td>
                @if ($platformConfiguration->is_active)
                    <span class="text-success">Yes</span>
                @else
                    <span class="text-danger">No</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $platformConfiguration->created_at }}</td>
        </tr>
        <tr>
            <th>Updated At</th>
            <td>{{ $platformConfiguration->updated_at }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('admin.platform-configurations.edit', $platformConfiguration->id) }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <form method="POST"
          action="{{ route('admin.platform-configurations.destroy', $platformConfiguration->id) }}">
        @csrf
        @method('DELETE')
        <x-form.button class="btn btn-sm btn-danger"
                       onclick="return confirm('Are you sure?')">Delete</x-form.button>
    </form>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            platformConfiguration
            @php dump(@$platformConfiguration) @endphp
        </div>
    @endif

</x-admin-layout>
