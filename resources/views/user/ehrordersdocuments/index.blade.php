<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>EHR Orders Documents</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.ehrorders.index') }}"
               class="btn btn-sm btn-secondary">View EHR Orders</a>
            <a href="{{ route('user.ehrorderssearchresults.index') }}"
               class="btn btn-sm btn-secondary">View EHR Order Search Results</a>
            <a href="{{ route('user.ehrordersdocuments.index') }}"
               class="btn btn-sm btn-secondary">View EHR Order Documents</a>
        </div>
    </div>

    <br />
    <br />

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('user.ehrordersdocuments.index') }}">

        <div class="row">

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="id"
                              id="id"
                              label="EHR Order Document ID"
                              :value="request('id')" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="ehrorder_id"
                              id="ehrorder_id"
                              label="EHR Order ID"
                              :value="request('ehrorder_id')" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="workorder_id"
                              id="workorder_id"
                              label="Workorder ID"
                              :value="request('workorder_id')" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="first_name"
                              id="first_name"
                              label="First Name"
                              :value="request('first_name')" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="last_name"
                              id="last_name"
                              label="Last Name"
                              :value="request('last_name')" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="status"
                              id="status"
                              label="Status"
                              :value="request('status')" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input type="datetime-local"
                              name="received_at_from"
                              label="Received At (From)"
                              :value="request('received_at_from')" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input type="datetime-local"
                              name="received_at_to"
                              label="Received At (To)"
                              :value="request('received_at_to')" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input type="datetime-local"
                              name="created_at_from"
                              label="Created At (From)"
                              :value="request('created_at_from')" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input type="datetime-local"
                              name="created_at_to"
                              label="Created At (To)"
                              :value="request('created_at_to')" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.ehrordersdocuments.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $ehrordersdocuments->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">ID</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'ehrorder_id', 'sort_direction' => $sort_direction]) }}">EHR
                            Order ID</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'ehrorderssearchresult_id', 'sort_direction' => $sort_direction]) }}">EHR
                            Order Search Result ID</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_id', 'sort_direction' => $sort_direction]) }}">Workorder
                            ID</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'service_provider', 'sort_direction' => $sort_direction]) }}">Service
                            Provider</a></th>
                    <th>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'first_name', 'sort_direction' => $sort_direction]) }}">First
                            Name</a>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'last_name', 'sort_direction' => $sort_direction]) }}">Last
                            Name</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'name', 'sort_direction' => $sort_direction]) }}">Name</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'event_date', 'sort_direction' => $sort_direction]) }}">Event
                            Date</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'file_type', 'sort_direction' => $sort_direction]) }}">File
                            Type</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'file_size', 'sort_direction' => $sort_direction]) }}">File
                            Size</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'download_duration', 'sort_direction' => $sort_direction]) }}">Download
                            Duration</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'retry_count', 'sort_direction' => $sort_direction]) }}">Retry
                            Count</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'status', 'sort_direction' => $sort_direction]) }}">Status</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'processing_at', 'sort_direction' => $sort_direction]) }}">Processing
                            At</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'received_at', 'sort_direction' => $sort_direction]) }}">Received
                            At</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created
                            At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ehrordersdocuments as $ehrordersdocument)
                    <tr>
                        <td>{{ $ehrordersdocument->id }}</td>
                        <td><a
                               href="{{ route('user.ehrorders.show', $ehrordersdocument->ehrorder_id) }}">{{ $ehrordersdocument->ehrorder_id }}</a>
                        </td>
                        <td><a
                               href="{{ route('user.ehrorderssearchresults.show', $ehrordersdocument->ehrorderssearchresult_id) }}">{{ $ehrordersdocument->ehrorderssearchresult_id }}</a>
                        </td>
                        <td>{{ $ehrordersdocument->workorder_id }}</td>
                        <td>{{ $ehrordersdocument->service_provider }}</td>
                        <td>{{ $ehrordersdocument->first_name }} {{ $ehrordersdocument->last_name }}</td>
                        <td>{{ $ehrordersdocument->name }}</td>
                        <td nowrap>{{ $ehrordersdocument->event_date }}</td>
                        <td>{{ $ehrordersdocument->file_type }}</td>
                        <td nowrap>{{ number_format(($ehrordersdocument->file_size ?? 0) / 1048576, 2) . ' MB' }}</td>
                        <td>{{ $ehrordersdocument->download_duration }}</td>
                        <td>{{ $ehrordersdocument->retry_count }}</td>
                        <td>{{ $ehrordersdocument->status }}</td>
                        <td nowrap>{{ $ehrordersdocument->processing_at }}</td>
                        <td nowrap>{{ $ehrordersdocument->received_at }}</td>
                        <td nowrap>{{ $ehrordersdocument->created_at }}</td>
                        <td>
                            <a href="{{ route('user.ehrordersdocuments.show', $ehrordersdocument->id) }}"
                               class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $ehrordersdocuments->withQueryString()->links() }}

    <br />
    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            ehrordersdocuments
            @php dump(@$ehrordersdocuments) @endphp
        </div>
    @endif

</x-user-layout>
