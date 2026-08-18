<x-admin-layout>

    <h1>Over 60 Days Notice Config</h1>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>id</td>
            <td>{{ $over60daysnoticeconfig->id }}</td>
        </tr>
        <tr>
            <td>Company</td>
            <td>{{ $over60daysnoticeconfig->Company }}</td>
        </tr>
        <tr>
            <td>SendNoticeDays</td>
            <td>{{ $over60daysnoticeconfig->SendNoticeDays }}</td>
        </tr>
        <tr>
            <td>EmailTo</td>
            <td>{{ $over60daysnoticeconfig->EmailTo }}</td>
        </tr>
        <tr>
            <td>CancelDays</td>
            <td>{{ $over60daysnoticeconfig->CancelDays }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('admin.over60daysnoticeconfigs.edit', $over60daysnoticeconfig->id) }}" class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <form method="POST" action="{{ route('admin.over60daysnoticeconfigs.destroy', $over60daysnoticeconfig->id) }}">
        @csrf
        @method('DELETE')
        <x-form.button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</x-form.button>
    </form>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            over60daysnoticeconfig
            @php dump(@$over60daysnoticeconfig) @endphp
        </div>
    @endif

    <br />
    <br />

</x-admin-layout>