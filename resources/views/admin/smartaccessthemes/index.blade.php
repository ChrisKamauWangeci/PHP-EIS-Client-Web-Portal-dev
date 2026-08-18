<x-admin-layout title="">

    <h1>Smart Access Themes</h1>

    <br />
    <br />

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('admin.smartaccessthemes.index') }}">
        <div class="row">
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="company_name" id="company_name" label="Company Name" :value="request('company_name')" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="slug" id="slug" label="Slug" :value="request('slug')" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.smartaccessthemes.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <br />
    <br />

    {{ $smartaccessthemes->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover1 table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'company_name', 'sort_direction' => $sort_direction]) }}">Company Name</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'smartaccess_active', 'sort_direction' => $sort_direction]) }}">Enabled</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'slug', 'sort_direction' => $sort_direction]) }}">Slug</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'backgroundcolor', 'sort_direction' => $sort_direction]) }}">Background</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'headercolor', 'sort_direction' => $sort_direction]) }}">Header</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'fontcolor', 'sort_direction' => $sort_direction]) }}">Font</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_at', 'sort_direction' => $sort_direction]) }}">Updated At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($smartaccessthemes as $smartaccesstheme)
                    <tr>
                        <td>{{ $smartaccesstheme->company_name }}</td>
                        <td><img src="/img/icon_{{ $smartaccesstheme->smartaccess_active ?? 0 }}.png" alt=""></td>
                        <td>{{ $smartaccesstheme->slug }}</td>
                        <td>
                            <div style="width: 15px; height: 15px; background: {{ $smartaccesstheme->backgroundcolor }}; display: inline-block; margin-right: 5px;"></div>
                            {{ $smartaccesstheme->backgroundcolor }}
                        </td>
                        <td>
                            <div style="width: 15px; height: 15px; background: {{ $smartaccesstheme->headercolor }}; display: inline-block; margin-right: 5px;"></div>
                            {{ $smartaccesstheme->headercolor }}
                        </td>
                        <td>
                            <div style="width: 15px; height: 15px; background: {{ $smartaccesstheme->fontcolor }}; display: inline-block; margin-right: 5px;"></div>
                            {{ $smartaccesstheme->fontcolor }}
                        </td>
                        <td>{{ $smartaccesstheme->updated_at }}</td>
                        <td>
                            <a href="{{ route('admin.smartaccessthemes.show', $smartaccesstheme->id) }}" class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $smartaccessthemes->withQueryString()->links() }}

    <br />

    <a href="{{ route('admin.smartaccessthemes.create') }}" class="btn btn-sm btn-secondary">Add</a>

    <br />
    <br />

    <div hx-get="{{ route('admin.smartaccessthemes.create') }}" hx-swap="outerHTML" class="btn btn-sm btn-secondary">Add (HTMX)</div>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            smartaccessthemes
            @php dump(@$smartaccessthemes) @endphp
        </div>
    @endif

</x-admin-layout>