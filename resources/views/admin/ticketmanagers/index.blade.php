<x-admin-layout title="">

    <h1>Ticket Managers</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('admin.ticketmanagers.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="name"
                              label="Name"
                              :value="request('name')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="email"
                              label="Email"
                              :value="request('email')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.ticketmanagers.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $ticketmanagers->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">ID</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'name', 'sort_direction' => $sort_direction]) }}">Name</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'email', 'sort_direction' => $sort_direction]) }}">Email</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created
                            At</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_at', 'sort_direction' => $sort_direction]) }}">Updated
                            At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ticketmanagers as $ticketmanager)
                    <tr>
                        <td>{{ $ticketmanager->id }}</td>
                        <td>{{ $ticketmanager->name }}</td>
                        <td>{{ $ticketmanager->email }}</td>
                        <td>{{ $ticketmanager->created_at }}</td>
                        <td>{{ $ticketmanager->updated_at }}</td>
                        <td>
                            <a href="{{ route('admin.ticketmanagers.show', $ticketmanager->id) }}"
                               class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $ticketmanagers->withQueryString()->links() }}

    <br />
    <br />

    <div class="row">
        <div class="col-sm-6 col-md-4">
            <form method="post"
                  action="{{ route('admin.ticketmanagers.assign') }}">
                @csrf
                <x-form.select name="C_Name"
                               label="Contractor"
                               :options="$contractors"
                               empty=" "
                               required />
                <br />
                <x-form.button>Assign Ticket Manager</x-form.button>
            </form>
        </div>
    </div>

    <br />
    <br />

    {{-- @if ($adminsession['contractor']['accesslevel'])
        <h3>Add Ticket Manager</h3>
        <a href="{{ route('admin.ticketmanagers.create') }}" class="btn btn-sm btn-secondary">Add</a>
    @endif --}}

    <br />
    <br />

</x-admin-layout>
