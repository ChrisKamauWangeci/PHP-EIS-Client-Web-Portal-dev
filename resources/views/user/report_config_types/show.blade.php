<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Report Config Type</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.report_config_types.index') }}"
               class="btn btn-sm btn-secondary">View Report Config Types</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">


        <tr>
            <td>id</td>
            <td>{{ $reportConfigType->id }}</td>
        </tr>
        <tr>
            <td>report_type</td>
            <td>{{ $reportConfigType->report_type }}</td>
        </tr>
        <tr>
            <td>created_by</td>
            <td>{{ $reportConfigType->created_by }}</td>
        </tr>
        <tr>
            <td>updated_by</td>
            <td>{{ $reportConfigType->updated_by }}</td>
        </tr>
        <tr>
            <td>created_at</td>
            <td>{{ $reportConfigType->created_at->format('m/d/Y g:i a') }}</td>
        </tr>
        <tr>
            <td>updated_at</td>
            <td>{{ $reportConfigType->updated_at->format('m/d/Y g:i a') }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('user.report_config_types.edit', $reportConfigType->id) }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <form method="POST"
          action="{{ route('user.report_config_types.destroy', $reportConfigType->id) }}">
        @csrf
        @method('DELETE')
        <x-form.button class="btn btn-sm btn-danger"
                       onclick="return confirm('Are you sure?')">Delete</x-form.button>
    </form>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            reportConfigType
            @php dump(@$reportConfigType) @endphp
        </div>
    @endif

    <br />
    <br />

</x-user-layout>
