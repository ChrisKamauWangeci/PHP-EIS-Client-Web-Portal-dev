<x-user-layout title="">

    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap"
          rel="stylesheet">
    <style>
        .mono {
            font-family: 'Roboto Mono', monospace;
        }
    </style>

    <div class="row">
        <div class="col-auto">
            <h1>Workorder: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }} {{ $workorder->W_LastName }}
            </h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}"
               class="btn btn-sm btn-secondary">View Workorder</a>
            &nbsp;
            <a href="{{ route('user.workorderfiles.show', $workorder->W_WorkOrder) }}"
               class="btn btn-sm btn-secondary">View Workorder Files</a>
        </div>
    </div>

    <br />

    <div class="">
        Authorization File {{ $workorder->W_AuthorizedFile }}
    </div>

    <br />

    <h4>Prefill Folders</h4>

    @foreach ($prefillfolders as $prefillfolder)
        <a href="/user/workorderprefills?workorder_id={{ $workorder->W_WorkOrder }}&directory={{ $prefillfolder }}"
           {!! $prefillfolder == $directory ? ' class="fw-bold"' : '' !!}>{{ $prefillfolder }}</a>
        <br />
    @endforeach

    <br />

    <h4>Merge Folders</h4>

    @foreach ($mergefolders as $mergefolder)
        <a href="/user/workorderprefills?workorder_id={{ $workorder->W_WorkOrder }}&directory={{ $mergefolder }}"
           {!! $mergefolder == $directory ? ' class="fw-bold"' : '' !!}>{{ $mergefolder }}</a>
        <br />
    @endforeach

    <br />

    <br />

    <div class="col-sm-7">
        <h4>Upload</h4>

        <form method="post"
              enctype="multipart/form-data"
              action="{{ route('user.workorderprefills.store') }}">
            @csrf

            <input type="hidden"
                   name="type"
                   value="prefill">
            <input type="hidden"
                   name="W_WorkOrder"
                   value="{{ $workorder->W_WorkOrder }}">
            <input type="hidden"
                   name="directory"
                   value="{{ $directory }}">

            {{ $directory }}

            <br />

            <x-form.input type="file"
                          name="uploadfile"
                          accept=".pdf,.tif"
                          required />
            <br />

            <x-form.errors />

            <button class="btn btn-sm btn-secondary"
                    type="submit">Submit</button>
        </form>

    </div>

    <br />
    <br />

    <h4>{{ $directory }}</h4>

    <table class="table table-sm table-bordered w-auto">
        @foreach ($files as $file)
            <tr>
                <td><a href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
                       target="_blank">View</a></td>
                <td><a href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=1"
                       target="_blank">Download</a></td>
                <td><a
                       href="/user/faxes/create?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}">Fax</a>
                </td>
                <td><a
                       href="/user/emails/create?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}">Email</a>
                </td>
                <td class="mono">{{ $file }}</td>
            </tr>
        @endforeach
    </table>

    <br />
    <br />
    <br />
    <br />

    @if ($usersession['debug'])
        :
        <div class="bg-light small p-2 d-print-none">
            workorder
            @php dump(@$workorder) @endphp
        </div>
    @endif

</x-user-layout>
