<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Facility Form</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('user.facilityforms.index') }}"
               class="btn btn-sm btn-secondary">Facility Forms</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <th>ID</th>
            <td>{{ $facilityform->id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $facilityform->name }}</td>
        </tr>
        <tr>
            <th>Slug</th>
            <td>{{ $facilityform->slug }}</td>
        </tr>
        <tr>
            <th>File Name</th>
            <td>{{ $facilityform->file_name }}</td>
        </tr>
        <tr>
            <th>DocuSign Template ID (Test)</th>
            <td>{{ $facilityform->docusign_templateid_test }}</td>
        </tr>
        <tr>
            <th>DocuSign Template ID (Production)</th>
            <td>{{ $facilityform->docusign_templateid_production }}</td>
        </tr>
        <tr>
            <th>Internal Form</th>
            <td><img src="/img/icon_{{ $facilityform->internal_form }}.png"
                     alt=""></td>
        </tr>
        <tr>
            <th>SignNow Template ID</th>
            <td>{{ $facilityform->signnow_templateid }}</td>
        </tr>
        <tr>
            <th>Version</th>
            <td>{{ $facilityform->version }}</td>
        </tr>
        <tr>
            <th>Revision Date</th>
            <td>{{ $facilityform->revision_date }}</td>
        </tr>
        <tr>
            <th>Created By</th>
            <td>{{ $facilityform->created_by }}</td>
        </tr>
        <tr>
            <th>Updated By</th>
            <td>{{ $facilityform->updated_by }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $facilityform->created_at }}</td>
        </tr>
        <tr>
            <th>Updated At</th>
            <td>{{ $facilityform->updated_at }}</td>
        </tr>
    </table>

    <a href="/user/hospitals?dbfield=H_Docusign&dbconditions=isequalto&dbvalue={{ $facilityform->slug }}">Hospital
        Docusign Count</a>
    <br />
    <a href="/user/hospitals?dbfield=H_SpecialAuthFile&dbconditions=isequalto&dbvalue={{ $facilityform->file_name }}">Hospital
        Special Auth File Count</a>
    <br />
    <br />

    <div class="col-5">

        <h2>Facility Form File</h2>

        @php
            $file = '\\\ftpserver\ftpserver\facilityforms\\' . $facilityform->file_name;
        @endphp

        @if (file_exists($file))
            <div class="text-success">{{ $file }}</div>

            <br />

            <a href="/user/files?file={{ $file }}&download=0"
               class="btn btn-sm btn-secondary"
               target="_blank">view</a>
            <a href="/user/files?file={{ $file }}&download=1"
               class="btn btn-sm btn-secondary"
               target="_self">download</a>
        @else
            <div class="text-danger">{{ $file }} does not exist</div>
        @endif

        <br />
        <br />

        <form method="post"
              enctype="multipart/form-data"
              action="{{ route('user.facilityforms.fileupload', $facilityform->id) }}">
            @csrf
            <input type="hidden"
                   name="filename"
                   value="{{ $facilityform->file_name }}">
            <x-form.input type="file"
                          name="uploadfile"
                          accept=".pdf"
                          required />
            <div class="p-1"></div>
            <x-form.button>Upload</x-form.button>
        </form>

    </div>

    <br />
    <br />

    <div class="col-5">
        <h2>Facility Form File Internal Fillable</h2>

        @php
            $file = '\\\ftpserver\ftpserver\facilityformsfillable\\' . $facilityform->file_name;
        @endphp

        @if (file_exists($file))
            <div class="text-success">{{ $file }}</div>

            <br />

            <a href="/user/files?file={{ $file }}&download=0"
               class="btn btn-sm btn-secondary"
               target="_blank">view</a>
            <a href="/user/files?file={{ $file }}&download=1"
               class="btn btn-sm btn-secondary"
               target="_self">download</a>
        @else
            <div class="text-danger">{{ $file }} does not exist</div>
        @endif

        <br />
        <br />

        <form method="post"
              enctype="multipart/form-data"
              action="{{ route('user.facilityforms.fileupload', $facilityform->id) }}">
            @csrf
            <input type="hidden"
                   name="filetype"
                   value="facilityformsfillable">
            <input type="hidden"
                   name="filename"
                   value="{{ $facilityform->file_name }}">
            <x-form.input type="file"
                          name="uploadfile"
                          accept=".pdf"
                          required />
            <div class="p-1"></div>
            <x-form.button>Upload</x-form.button>
        </form>

    </div>

    <br />
    <br />

    <a href="{{ route('user.facilityforms.edit', $facilityform->id) }}"
       class="btn btn-sm btn-secondary">Edit Facility Form</a>

    <br />
    <br />

    <form method="POST"
          action="{{ route('user.facilityforms.destroy', $facilityform->id) }}"
          onclick="return confirm('Are You Sure Want to Delete?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger"
                type="submit">Delete Facility Form: {{ $facilityform->name }}</button>
    </form>

    <br />
    <br />

</x-user-layout>
