<x-email>

    <?php
    $ticket = $data['ticket'];
    $ticketcomments = $data['ticketcomments'];
    ?>

        <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $ticket->id }}</td>
        </tr>
        <tr>
            <td>Ticket Number</td>
            <td>{{ $ticket->ticket_number }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>{{ $ticket->status }}</td>
        </tr>
        <tr>
            <td>Workorder Id</td>
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
            <td>Created By</td>
            <td>{{ $ticket->created_by }}</td>
        </tr>
        <tr>
            <td>Created By Email</td>
            <td>{{ $ticket->created_by_email }}</td>
        </tr>
        <tr>
            <td>Updated By</td>
            <td>{{ $ticket->updated_by }}</td>
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

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        @foreach ($ticketcomments as $ticketcomment)
            <tr>
                <td cellpadding="5">
                    <strong>{!! nl2br(e($ticketcomment->comment ?? '')) !!}</strong>
                    <br />
                    <br />
                    <small>{{ $ticketcomment->created_by }} - {{ $ticketcomment->created_at->format('m/d/Y H:i') }}</small>
                </td>
            </tr>
        @endforeach
    </table>

    <br />
    <br />

</x-email>