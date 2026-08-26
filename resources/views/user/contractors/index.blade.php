<x-user-layout title="">

    <h1>Contractors</h1>

    <br />
    <br />

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('user.contractors.index') }}">

        <div class="row">

            <div class="col-md-2">
                <x-form.input name="C_Name"
                              label="Name"
                              :value="request('C_Name')" />
            </div>

            <div class="col-md-2">
                <x-form.input name="C_Email"
                              label="Email"
                              :value="request('C_Email')" />
            </div>

            <div class="col-md-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.contractors.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $contractors->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_Name', 'sort_direction' => $sort_direction]) }}">Name</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_Email', 'sort_direction' => $sort_direction]) }}">Email</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_SysAdmin', 'sort_direction' => $sort_direction]) }}">Is
                            Admin</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'accesslevel', 'sort_direction' => $sort_direction]) }}">Access
                            Level</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_Caller', 'sort_direction' => $sort_direction]) }}">Caller</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'is_active', 'sort_direction' => $sort_direction]) }}">Is
                            Active</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'password_changed', 'sort_direction' => $sort_direction]) }}">Password
                            Changed</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_LastLogin', 'sort_direction' => $sort_direction]) }}">Last
                            Login</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_Updated', 'sort_direction' => $sort_direction]) }}">Updated</a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contractors as $contractor)
                    <tr>
                        <td>{{ $contractor->C_Name }} </td>
                        <td>{{ $contractor->C_Email }} </td>
                        <td><img src="/img/icon_{{ $contractor->C_SysAdmin }}.png"
                                 alt=""></td>
                        <td>{{ $contractor->accesslevel }} </td>
                        <td><img src="/img/icon_{{ $contractor->C_Caller }}.png"
                                 alt=""></td>
                        <td><img src="/img/icon_{{ $contractor->is_active }}.png"
                                 alt=""></td>
                        <td>{{ $contractor->password_changed }}</td>
                        <td>{{ $contractor->C_LastLogin }}</td>
                        <td>{{ $contractor->C_Updated }}</td>
                        <td>
                            <a href="{{ route('user.contractors.show', $contractor->id) }}"
                               class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $contractors->withQueryString()->links() }}

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            contractors
            @php dump(@$contractors) @endphp
        </div>
    @endif

</x-user-layout>
