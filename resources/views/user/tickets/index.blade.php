<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Tickets</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.tickets.create') }}"
               class="btn btn-sm btn-secondary">Create New Ticket</a>
        </div>
    </div>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('user.tickets.index') }}">

        <div class="row">

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="id"
                              id="ticket_number"
                              label="Ticket"
                              :value="request('id')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="workorder_id"
                              id="workorder_id"
                              label="Workorder"
                              :value="request('workorder_id')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="company"
                              id="company"
                              label="Company"
                              :value="request('company')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="requestor_name"
                              id="requestor_name"
                              label="Requestor"
                              :value="request('requestor_name')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="subject"
                              id="subject"
                              label="Subject"
                              :value="request('subject')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="assigned_to"
                              id="assigned_to"
                              label="Assigned To"
                              :value="request('assigned_to')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.select name="status"
                               label="Status"
                               :options="Helper::ticketstatuses()"
                               empty=" "
                               :default="request('status')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.tickets.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $tickets->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">Ticket</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'status', 'sort_direction' => $sort_direction]) }}">Status</a>
                    </th>
                    <th>DB</th>
                    <th>Work Order</th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'company', 'sort_direction' => $sort_direction]) }}">Company</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'requestor_name', 'sort_direction' => $sort_direction]) }}">Requestor</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'subject', 'sort_direction' => $sort_direction]) }}">Subject</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'assigned_to', 'sort_direction' => $sort_direction]) }}">Assigned
                            To</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created
                            At</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_at', 'sort_direction' => $sort_direction]) }}">Updated
                            At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{!! Helper::ticketStatusIcon($ticket->status) !!} {{ $ticket->status }}</td>
                        <td>{{ $ticket->db }}</td>
                        <td>{{ $ticket->workorder_id }}</td>
                        <td>{{ $ticket->company }}</td>
                        <td>{{ $ticket->requestor_name }}</td>
                        <td>{{ $ticket->subject }}</td>
                        <td>{{ $ticket->assigned_to }}</td>
                        <td>
                            {{ $ticket->created_at->format('m/d/Y') }}
                            <br />
                            {{ $ticket->created_at->diffForHumans() }}
                        </td>
                        <td>
                            {{ $ticket->updated_at->format('m/d/Y') }}
                            <br />
                            {{ $ticket->updated_at->diffForHumans() }}
                        </td>
                        <td>
                            <a href="{{ route('user.tickets.show', $ticket->id) }}"
                               class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $tickets->withQueryString()->links() }}

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            ticket
            @php dump(@$ticket) @endphp
        </div>
    @endif

</x-user-layout>
