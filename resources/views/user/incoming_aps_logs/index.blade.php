<x-user-layout title="">

    <h1>Incoming APS Logs</h1>

    <br />
    <br />

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('user.incoming_aps_logs.index') }}">

        <div class="row">

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="source" id="source" label="Source" :value="request('source')" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="workorder" id="workorder" label="Workorder" :value="request('workorder')" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="new_file" id="new_file" label="New File" :value="request('new_file')" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input type="date" name="created_at_from" id="created_at_from" label="Created At (From)" :value="request('created_at_from')" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input type="date" name="created_at_to" id="created_at_to" label="Created At (To)" :value="request('created_at_to')" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.incoming_aps_logs.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $incomingApsLogs->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Source</th>
                    <th>Workorder</th>
                    <th>New File</th>
                    <th>Page Count</th>
                    <th>Invoice Number</th>
                    <th>Created At</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($incomingApsLogs as $incomingApsLog)
                    <tr>
                        <td>{{ $incomingApsLog->id }}</td>
                        <td>{{ $incomingApsLog->source }}</td>
                        <td>{{ $incomingApsLog->workorder }}</td>
                        <td>
                            {{ $incomingApsLog->new_file }}
                            @if(file_exists(('//FTPSERVER/ftpserver/OCRData/EIS/pending/ready/' . $incomingApsLog->new_file)))
                                <a href="/user/workorderfiles/file?file={{ urlencode('//FTPSERVER/ftpserver/OCRData/EIS/pending/ready/' . $incomingApsLog->new_file) }}&amp;download=0" target="_blank" title="{{ '//FTPSERVER/ftpserver/OCRData/EIS/pending/ready/' . $incomingApsLog->new_file }}"><span class="badge bg-success">ready</span></a>
                            @endif
                            @if(file_exists(('//FTPSERVER/ftpserver/OCRData/EIS/pending/review/' . $incomingApsLog->new_file)))
                                <a href="/user/workorderfiles/file?file={{ urlencode('//FTPSERVER/ftpserver/OCRData/EIS/pending/review/' . $incomingApsLog->new_file) }}&amp;download=0" target="_blank" title="{{ '//FTPSERVER/ftpserver/OCRData/EIS/pending/review/' . $incomingApsLog->new_file }}"><span class="badge bg-warning">review</span></a>
                            @endif
                        </td>
                        <td>{{ $incomingApsLog->page_count }}</td>
                        <td>{{ $incomingApsLog->invoice_number }}</td>
                        <td>{{ $incomingApsLog->created_at->format('m/d/Y g:i a') }}</td>
                        <td>
                            <a href="{{ route('user.incoming_aps_logs.show', $incomingApsLog->id) }}" class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $incomingApsLogs->withQueryString()->links() }}

    <br />
    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            incomingApsLogs
            @php dump(@$incomingApsLogs) @endphp
        </div>
    @endif

</x-user-layout>