<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>EHR Orders Search Results Exclusion</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.ehrorderssearchresultsexclusions.index') }}" class="btn btn-sm btn-secondary">View EHR Order Search Results Exclusions</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $ehrorderssearchresultsexclusion->id }}</td>
        </tr>
        <tr>
            <td>Managing Organization</td>
            <td>{{ $ehrorderssearchresultsexclusion->managing_organization }}</td>
        </tr>
        <tr>
            <td>Created By</td>
            <td>{{ $ehrorderssearchresultsexclusion->created_by }}</td>
        </tr>
        <tr>
            <td>Updated By</td>
            <td>{{ $ehrorderssearchresultsexclusion->updated_by }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $ehrorderssearchresultsexclusion->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $ehrorderssearchresultsexclusion->updated_at }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('user.ehrorderssearchresultsexclusions.edit', $ehrorderssearchresultsexclusion->id) }}" class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <form method="POST" action="{{ route('user.ehrorderssearchresultsexclusions.destroy', $ehrorderssearchresultsexclusion->id) }}">
        @csrf
        @method('DELETE')
        <x-form.button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</x-form.button>
    </form>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            ehrorderssearchresultsexclusion
            @php dump(@$ehrorderssearchresultsexclusion) @endphp
        </div>
    @endif

</x-user-layout>