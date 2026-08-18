<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Requestor Role</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.requestorroles.index') }}" class="btn btn-sm btn-secondary">View Requestor Roles</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $requestorrole->id }}</td>
        </tr>
        <tr>
            <td>Company</td>
            <td>{{ $requestorrole->company }}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{ $requestorrole->name }}</td>
        </tr>
        <tr>
            <td>Role</td>
            <td>{{ $requestorrole->role }}</td>
        </tr>
        <tr>
            <td>Active in Order</td>
            <td><img src="/img/icon_{{ $requestorrole->active_in_order }}.png" alt=""></td>
        </tr>
        <tr>
            <td>Active in Search</td>
            <td><img src="/img/icon_{{ $requestorrole->active_in_search }}.png" alt=""></td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $requestorrole->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $requestorrole->updated_at }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('admin.requestorroles.edit', $requestorrole->id) }}" class="btn btn-sm btn-secondary"><i class="fas fa-edit"></i> Edit</a>

    <br />
    <br />

    <h3>Requestors</h3>

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>R_ID</th>
                    <th>Company</th>
                    <th>Name</th>
                    <th>Login</th>
                    <th>Email</th>
                    <th>Login Last</th>
                    <th>Is Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requestors as $requestor)
                    <tr>
                        <td>{{ $requestor->R_ID }} </td>
                        <td>{{ $requestor->R_Company }}</td>
                        <td>{{ $requestor->R_Name }}</td>
                        <td>{{ $requestor->R_LoginEmail }}</td>
                        <td>{{ $requestor->R_Email }}</td>
                        <td nowrap>{{ $requestor->login_last }}</td>
                        <td>
                            <img src="/img/icon_{{ $requestor->R_Active }}.png" alt="">
                        </td>
                        <td><a href="{{ route('admin.requestors.show', $requestor ) }}" class="btn btn-xs btn-secondary">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br />
    <br />

    <form method="POST" action="{{ route('admin.requestorroles.destroy', $requestorrole->id) }}">
        @csrf
        @method('DELETE')
        <x-form.button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> Delete Requestor Role</x-form.button>
    </form>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            requestorrole
            @php dump(@$requestorrole) @endphp
        </div>
    @endif

    <br />
    <br />
    <br />

</x-admin-layout>