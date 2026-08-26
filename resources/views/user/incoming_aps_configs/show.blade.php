<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Incoming APS Config</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.incoming_aps_configs.index') }}"
               class="btn btn-sm btn-secondary">View Incoming APS Configs</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $incomingApsConfig->id }}</td>
        </tr>
        <tr>
            <td>Source</td>
            <td>{{ $incomingApsConfig->source }}</td>
        </tr>
        <tr>
            <td>Source Folder</td>
            <td>{{ $incomingApsConfig->source_folder }}</td>
        </tr>
        <tr>
            <td>Destination Folder</td>
            <td>{{ $incomingApsConfig->destination_folder }}</td>
        </tr>
        <tr>
            <td>Back Up Folder</td>
            <td>{{ $incomingApsConfig->back_up_folder }}</td>
        </tr>
        <tr>
            <td>Created By</td>
            <td>{{ $incomingApsConfig->created_by }}</td>
        </tr>
        <tr>
            <td>Updated By</td>
            <td>{{ $incomingApsConfig->updated_by }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $incomingApsConfig->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $incomingApsConfig->updated_at }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('user.incoming_aps_configs.edit', $incomingApsConfig->id) }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <form method="POST"
          action="{{ route('user.incoming_aps_configs.destroy', $incomingApsConfig->id) }}">
        @csrf
        @method('DELETE')
        <x-form.button class="btn btn-sm btn-danger"
                       onclick="return confirm('Are you sure?')">Delete</x-form.button>
    </form>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            incomingApsConfig
            @php dump(@$incomingApsConfig) @endphp
        </div>
    @endif

    <br />
    <br />

</x-user-layout>
