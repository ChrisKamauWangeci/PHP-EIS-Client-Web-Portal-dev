<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Report Config Name</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.report_config_names.index') }}"
               class="btn btn-sm btn-secondary">View Report Config Names</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">


        <tr>
            <td>id</td>
            <td>{{ $reportConfigName->id }}</td>
        </tr>
        <tr>
            <td>report_name</td>
            <td>{{ $reportConfigName->report_name }}</td>
        </tr>
        <tr>
            <td>created_by</td>
            <td>{{ $reportConfigName->created_by }}</td>
        </tr>
        <tr>
            <td>updated_by</td>
            <td>{{ $reportConfigName->updated_by }}</td>
        </tr>
        <tr>
            <td>created_at</td>
            <td>{{ $reportConfigName->created_at->format('m/d/Y g:i a') }}</td>
        </tr>
        <tr>
            <td>updated_at</td>
            <td>{{ $reportConfigName->updated_at->format('m/d/Y g:i a') }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('user.report_config_names.edit', $reportConfigName->id) }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <form method="POST"
          action="{{ route('user.report_config_names.destroy', $reportConfigName->id) }}">
        @csrf
        @method('DELETE')
        <x-form.button class="btn btn-sm btn-danger"
                       onclick="return confirm('Are you sure?')">Delete</x-form.button>
    </form>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            reportConfigName
            @php dump(@$reportConfigName) @endphp
        </div>
    @endif

    <br />
    <br />

</x-user-layout>
