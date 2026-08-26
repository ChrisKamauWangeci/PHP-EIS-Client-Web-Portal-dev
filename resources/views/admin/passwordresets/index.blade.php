<x-admin-layout title="">

    <h1>Password Resets</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('admin.passwordresets.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="email"
                              label="Email"
                              :value="request('email')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="ip_address"
                              label="IP Address"
                              :value="request('ip_address')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.passwordresets.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $passwordresets->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">ID</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'email', 'sort_direction' => $sort_direction]) }}">Email</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'ip_address', 'sort_direction' => $sort_direction]) }}">IP
                            Address</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created
                            At</a></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($passwordresets as $passwordreset)
                    <tr>
                        <td>{{ $passwordreset->id }} </td>
                        <td>{{ $passwordreset->email }} </td>
                        <td>{{ $passwordreset->ip_address }}</td>
                        <td>{{ $passwordreset->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $passwordresets->withQueryString()->links() }}

    <br />
    <br />

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            passwordresets
            @php dump(@$passwordresets) @endphp
        </div>
    @endif

</x-admin-layout>
