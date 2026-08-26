<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Smart Access Theme</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.smartaccessthemes.index') }}"
               class="btn btn-sm btn-secondary">View Smart Access Themes</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm w-auto">
        <tr>
            <th>ID</th>
            <td>{{ $smartaccesstheme->id }}</td>
        </tr>
        <tr>
            <th>Company Name</th>
            <td>{{ $smartaccesstheme->company_name }}</td>
        </tr>
        <tr>
            <th>Slug</th>
            <td>{{ $smartaccesstheme->slug }}</td>
        </tr>
        <tr>
            <th>Background Color</th>
            <td>
                <div
                     style="width: 15px; height: 15px; background: {{ $smartaccesstheme->backgroundcolor }}; display: inline-block; margin-right: 5px;">
                </div>
                {{ $smartaccesstheme->backgroundcolor }}
            </td>
        </tr>
        <tr>
            <th>Header Color</th>
            <td>
                <div
                     style="width: 15px; height: 15px; background: {{ $smartaccesstheme->headercolor }}; display: inline-block; margin-right: 5px;">
                </div>
                {{ $smartaccesstheme->headercolor }}
            </td>
        </tr>
        <tr>
            <th>Font Color</th>
            <td>
                <div
                     style="width: 15px; height: 15px; background: {{ $smartaccesstheme->fontcolor }}; display: inline-block; margin-right: 5px;">
                </div>
                {{ $smartaccesstheme->fontcolor }}
            </td>
        </tr>
        <tr>
            <th>Logo Background Color</th>
            <td>
                <div
                     style="width: 15px; height: 15px; background: {{ $smartaccesstheme->logobackgroundcolor }}; display: inline-block; margin-right: 5px;">
                </div>
                {{ $smartaccesstheme->logobackgroundcolor }}
            </td>
        </tr>
        <tr>
            <th>Created By</th>
            <td>{{ $smartaccesstheme->created_by }}</td>
        </tr>
        <tr>
            <th>Updated By</th>
            <td>{{ $smartaccesstheme->updated_by }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $smartaccesstheme->created_at }}</td>
        </tr>
        <tr>
            <th>Updated At</th>
            <td>{{ $smartaccesstheme->updated_at }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('admin.smartaccessthemes.edit', $smartaccesstheme->id) }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <form method="POST"
          action="{{ route('admin.smartaccessthemes.destroy', $smartaccesstheme->id) }}">
        @csrf
        @method('DELETE')
        <x-form.button class="btn btn-sm btn-danger"
                       onclick="return confirm('Are you sure?')">Delete</x-form.button>
    </form>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            smartaccesstheme
            @php dump(@$smartaccesstheme) @endphp
        </div>
    @endif

</x-admin-layout>
