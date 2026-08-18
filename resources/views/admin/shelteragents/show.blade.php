<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Shelter Agent</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.shelteragents.index') }}" class="btn btn-sm btn-secondary">View Shelter Agents</a>
        </div>
    </div>

    <br />

    <table class="table table-bordered table-sm w-auto">
        <tr>
            <td>Name</td>
            <td>{{ $shelteragent->name }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $shelteragent->email }}</td>
        </tr>
        <tr>
            <td>Role</td>
            <td>{{ $shelteragent->role }}</td>
        </tr>
        <tr>
            <td>SDL District</td>
            <td>{{ $shelteragent->sdl_district_number }}</td>
        </tr>
        <tr>
            <td>Agent Code</td>
            <td>{{ $shelteragent->agent_code }}</td>
        </tr>
        <tr>
            <td>Is Active</td>
            <td><img src="/img/icon_{{ $shelteragent->is_active }}.png" alt=""></td>
        </tr>
        <tr>
            <td>Created By</td>
            <td>{{ $shelteragent->created_by }}</td>
        </tr>
        <tr>
            <td>Updated By</td>
            <td>{{ $shelteragent->updated_by }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $shelteragent->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $shelteragent->updated_at }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('admin.shelteragents.edit', $shelteragent->id) }}" class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <form method="POST" action="{{ route('admin.shelteragents.destroy', $shelteragent->id) }}">
        @csrf
        @method('DELETE')
        <x-form.button class="btn-danger" onclick="return confirm('Are you sure?')">Delete</x-form.button>
    </form>

    <br />
    <br />

    @if ($shelteragents)
        <div class="table-responsive">
            <table class="table table-sm table-hover table-bordered w-auto">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>SDL District</th>
                        <th>Agent Code</th>
                        <th>Active</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shelteragents as $shelteragent)
                        <tr>
                            <td>{{ $shelteragent->name }}</td>
                            <td>{{ $shelteragent->email }}</td>
                            <td>{{ $shelteragent->role }}</td>
                            <td>{{ $shelteragent->sdl_district_number }}</td>
                            <td>{{ $shelteragent->agent_code }}</td>
                            <td><img src="/img/icon_{{ $shelteragent->is_active }}.png" alt=""></td>
                            <td>
                                <a href="{{ route('admin.shelteragents.show', $shelteragent->id) }}" class="btn btn-xs btn-secondary">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            shelteragent
            @php dump(@$shelteragent) @endphp
        </div>
    @endif

    <br />
    <br />

</x-admin-layout>
