<x-admin-layout title="">

    <h1>Over 60 Days Notice Configs</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('admin.over60daysnoticeconfigs.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="C_Name"
                              label="Name"
                              :value="request('C_Name')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.over60daysnoticeconfigs.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $over60daysnoticeconfigs->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">id</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'Company', 'sort_direction' => $sort_direction]) }}">Company</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'SendNoticeDays', 'sort_direction' => $sort_direction]) }}">Send
                            Notice Days</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'EmailTo', 'sort_direction' => $sort_direction]) }}">Email
                            To</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'CancelDays', 'sort_direction' => $sort_direction]) }}">Cancel
                            Days</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($over60daysnoticeconfigs as $over60daysnoticeconfig)
                    <tr>
                        <td>{{ $over60daysnoticeconfig->id }}</td>
                        <td>{{ $over60daysnoticeconfig->Company }}</td>
                        <td>{{ $over60daysnoticeconfig->SendNoticeDays }}</td>
                        <td>{{ $over60daysnoticeconfig->EmailTo }}</td>
                        <td>{{ $over60daysnoticeconfig->CancelDays }}</td>
                        <td>
                            <a href="{{ route('admin.over60daysnoticeconfigs.show', $over60daysnoticeconfig->id) }}"
                               class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $over60daysnoticeconfigs->withQueryString()->links() }}

    <br />
    <br />

    @if ($adminsession['contractor']['accesslevel'])
        <a href="{{ route('admin.over60daysnoticeconfigs.create') }}"
           class="btn btn-sm btn-secondary">Add</a>
    @endif

    <br />
    <br />

</x-admin-layout>
