<x-admin-layout title="">

    <h1>Company Updates</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('admin.companyupdates.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="name"
                              label="Name"
                              :value="request('name')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.companyupdates.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />


    {{ $companyupdates->withQueryString()->links() }}

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
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'filename', 'sort_direction' => $sort_direction]) }}">Filename</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created
                            At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companyupdates as $companyupdate)
                    <tr>
                        <td>{{ $companyupdate->id }} </td>
                        <td>{{ $companyupdate->name }} </td>
                        <td>{{ $companyupdate->filename }} </td>
                        <td>{{ $companyupdate->created_at }} </td>
                        <td>
                            <a href="{{ route('admin.companyupdates.show', $companyupdate->id) }}"
                               class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $companyupdates->withQueryString()->links() }}

    <br />

    <br />
    <br />

    <a href="{{ route('admin.companyupdates.create') }}"
       class="btn btn-sm btn-secondary">Add</a>

    <br />
    <br />

    <a href="{{ route('admin.contractors.resetcompanyupdates') }}"
       class="btn btn-sm btn-warning">Set Contractor News</a>

    <br />
    <br />

</x-admin-layout>
