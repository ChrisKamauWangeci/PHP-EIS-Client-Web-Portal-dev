<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Ticket</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.tickets.edit', $ticket->id) }}" class="btn btn-sm btn-secondary">Edit Ticket</a>
            <a href="{{ route('user.tickets.index') }}" class="btn btn-sm btn-secondary">View Tickets</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>Ticket</td>
            <td>{{ $ticket->id }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                {{ $ticket->status }}
            </td>
        </tr>
        <tr>
            <td>Workorder</td>
            <td>{{ $ticket->workorder_id }}</td>
        </tr>
        <tr>
            <td>Company</td>
            <td>{{ $ticket->company }}</td>
        </tr>
        <tr>
            <td>Requestor Name</td>
            <td>{{ $ticket->requestor_name }}</td>
        </tr>
        <tr>
            <td>Requestor Email</td>
            <td>{{ $ticket->requestor_email }}</td>
        </tr>
        <tr>
            <td>Requestor Phone</td>
            <td>{{ $ticket->requestor_phone }}</td>
        </tr>
        <tr>
            <td>Assigned To</td>
            <td>{{ $ticket->assigned_to }}</td>
        </tr>
        <tr>
            <td>Assigned To Email</td>
            <td>{{ $ticket->assigned_to_email }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $ticket->created_at->format('m/d/Y H:i:s') }}</td>
        <tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $ticket->updated_at->format('m/d/Y H:i:s') }}</td>
        </tr>
    </table>

    <h5>Subject</h5>
    {{ $ticket->subject }}

    <br />
    <br />

    <div class="row">
        <div class="col-10 col-sm-8 col-md-8 col-lg-6 pt-2">

            <h5>Description</h5>
            <div class="card">
                <div class="card-body">
                    {!! nl2br(e($ticket->description ?? '')) !!}
                </div>
            </div>
            <br />

            <h5>Comments</h5>
            @foreach ($ticket->ticketcomments as $ticketcomment)
                <div class="card">
                    <div class="card-body">
                        {!! nl2br(e($ticketcomment->comment ?? '')) !!}
                        <br />
                        <br />

                        <div class="text-end">
                            <small>{{ $ticketcomment->created_by }} - {{ $ticketcomment->created_at->format('m/d/Y H:i:s') }}</small>
                        </div>

                    </div>
                </div>
                <br />
            @endforeach

            <br />
            <br />

            <form method="post" action="{{ route('user.tickets.commentadd', $ticket->id) }}">
                <strong>Add Comment</strong>
                @csrf
                <x-form.textarea name="comment" :value="old('comment')" :rows="6" required />
                <br />
                <x-form.button>Add Comment</x-form.button>
            </form>

            <br />
            <br />

            {{-- @php
                $directory = '//ftpserver/documents/website/tickets/' . $ticket->created_at->format('Ym') . '/' . $ticket->id . '/';

                try {
                    $files = new FilesystemIterator($directory, FilesystemIterator::KEY_AS_FILENAME | FilesystemIterator::SKIP_DOTS);
                    // $files = array_reverse(iterator_to_array($files));
                } catch (\Throwable $th) {
                    $files = [];
                    $directory = '<span class="text-danger">directory error: ' . $directory . '</span>';
                }
            @endphp --}}

            {{-- <strong>Files</strong>

            <table class="table table-sm table-bordered w-auto">
                <tr>
                    <th>File</th>
                    <th>View</th>
                </tr>
                @foreach ($files as $file)
                    <tr>
                        <td class="mono">{{ $file->getFilename() }}</td>
                        <td><a href="{{ route('user.tickets.filedownload', [$ticket->id, 'filename' => $file->getFilename()]) }}" target="_blank">view</a></td>
                    </tr>
                @endforeach
            </table>

            <br />

            <strong>Upload File</strong>
            <form name="orderform" id="orderform" method="post" action="{{ route('user.tickets.fileadd', $ticket->id) }}" enctype="multipart/form-data">
                @csrf
                <x-form.input type="file" name="uploadfile" accept=".jpg,.png,.pdf,.tif" required />
                <br />
                <x-form.button id="uploadsubmit">Upload File</x-form.button>
            </form> --}}

            <br />
            <br />

            <form method="post" action="{{ route('user.tickets.update', $ticket->id) }}">
                <strong>Change Status</strong>
                @csrf
                @method('PATCH')

                @php
                    $statuses = [
                        'open' => 'open',
                        'closed' => 'closed',
                    ];
                @endphp

                <x-form.select name="status" :options="$statuses" :default="$ticket->status" required />
                <br />
                <x-form.button onclick="return confirm('Are you sure?')">Change Status</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />
    <a href="{{ route('user.tickets.edit', $ticket->id) }}" class="btn btn-sm btn-secondary">Edit Ticket</a>
    <br />
    <br />

    {{-- <h4>Delete Ticket</h4>
    <form method="POST" action="{{ route('user.tickets.destroy', $ticket->id) }}">
        @csrf
        @method('DELETE')
        <x-form.button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete Ticket</x-form.button>
    </form>

    <br />
    <br /> --}}

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            ticket
            @php dump(@$ticket) @endphp
        </div>
    @endif

    <br />
    <br />

</x-user-layout>
