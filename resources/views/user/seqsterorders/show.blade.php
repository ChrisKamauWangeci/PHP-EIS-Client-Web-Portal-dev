<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Seqster Order</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.seqsterorders.index') }}"
               class="btn btn-sm btn-secondary">View Seqster Orders</a>
        </div>
    </div>

    <br />

    <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm table-hover w-auto">
            <tr>
                <td>ID</td>
                <td>{{ $seqsterorder->id }}</td>
            </tr>
            <tr>
                <td>UUID</td>
                <td>{{ $seqsterorder->uuid }}</td>
            </tr>
            <tr>
                <td>Project Title</td>
                <td>{{ $seqsterorder->project_title }}</td>
            </tr>
            <tr>
                <td>Site Name</td>
                <td>{{ $seqsterorder->site_name }}</td>
            </tr>
            <tr>
                <td>Site ID</td>
                <td>{{ $seqsterorder->site_id }}</td>
            </tr>
            <tr>
                <td>Participant Identifier</td>
                <td>{{ $seqsterorder->participant_identifier }}</td>
            </tr>
            <tr>
                <td>Workorder ID</td>
                <td>{{ $seqsterorder->workorder_id }}</td>
            </tr>
            <tr>
                <td>Company</td>
                <td>{{ $seqsterorder->company }}</td>
            </tr>
            <tr>
                <td>Patient ID</td>
                <td>{{ $seqsterorder->patient_id }}</td>
            </tr>
            <tr>
                <td>First Name</td>
                <td>{{ $seqsterorder->first_name }}</td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td>{{ $seqsterorder->last_name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $seqsterorder->email }}</td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>{{ $seqsterorder->gender }}</td>
            </tr>
            <tr>
                <td>Birthday</td>
                <td>{{ $seqsterorder->birthday }}</td>
            </tr>
            <tr>
                <td>Address 1</td>
                <td>{{ $seqsterorder->address_1 }}</td>
            </tr>
            <tr>
                <td>Address 2</td>
                <td>{{ $seqsterorder->address_2 }}</td>
            </tr>
            <tr>
                <td>City</td>
                <td>{{ $seqsterorder->city }}</td>
            </tr>
            <tr>
                <td>State</td>
                <td>{{ $seqsterorder->state }}</td>
            </tr>
            <tr>
                <td>Postal Code</td>
                <td>{{ $seqsterorder->postal_code }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>{{ $seqsterorder->status }}</td>
            </tr>
            <tr>
                <td>Status API</td>
                <td>{{ $seqsterorder->status_api }}</td>
            </tr>
            <tr>
                <td>Access Token</td>
                <td>{{ $seqsterorder->access_token }}</td>
            </tr>
            <tr>
                <td>Refresh Token</td>
                <td>{{ $seqsterorder->refresh_token }}</td>
            </tr>
            <tr>
                <td>Seqster Providers</td>
                <td>
                    <pre>{{ $seqsterorder->seqster_providers }}</pre>
                </td>
            </tr>
            <tr>
                <td>API Error</td>
                <td>
                    <pre>{{ $seqsterorder->api_error }}</pre>
                </td>
            </tr>
            <tr>
                <td>IP Address</td>
                <td>{{ $seqsterorder->ip_address }}
                </td>
            </tr>
            <tr>
                <td>Remote Host</td>
                <td>{{ $seqsterorder->remote_host }}</td>
            </tr>
            <tr>
                <td>Email Viewed Count</td>
                <td>{{ $seqsterorder->email_viewed_count }}</td>
            </tr>
            <tr>
                <td>Visit Count</td>
                <td>{{ $seqsterorder->visit_count }}</td>
            </tr>
            <tr>
                <td>Seqster At</td>
                <td>{{ $seqsterorder->seqster_at }}</td>
            </tr>
            <tr>
                <td>Emailed At</td>
                <td>{{ $seqsterorder->emailed_at }}</td>
            </tr>
            <tr>
                <td>Reminded At</td>
                <td>{{ $seqsterorder->reminded_at }}</td>
            </tr>
            <tr>
                <td>Email Viewed At</td>
                <td>{{ $seqsterorder->email_viewed_at }}</td>
            </tr>
            <tr>
                <td>Visited At</td>
                <td>{{ $seqsterorder->visited_at }}</td>
            </tr>
            <tr>
                <td>Seqster Providers At</td>
                <td>{{ $seqsterorder->seqster_providers_at }}</td>
            </tr>
            <tr>
                <td>Record Received At</td>
                <td>{{ $seqsterorder->record_received_at }}</td>
            </tr>
            <tr>
                <td>Created</td>
                <td>{{ $seqsterorder->created }}</td>
            </tr>
            <tr>
                <td>Modified</td>
                <td>{{ $seqsterorder->modified }}</td>
            </tr>
        </table>
    </div>

    <br />
    <br />

    <h3>Actions</h3>

    <form method="POST"
          action="{{ route('user.seqsterorders.sendemail', $seqsterorder->id) }}">
        @csrf
        <button type="submit"
                class="btn btn-sm btn-secondary">Resend Email</button>
    </form>

    <br />

    <a href="{{ route('user.seqsterorders.edit', $seqsterorder->id) }}"
       class="btn btn-sm btn-primary">Edit</a>

    <br />
    <br />

    @if ($seqsterorder->company == 'USAA')
        <a href="https://usaa.expressimagingservices.com/seqsterorders/step1/{{ $seqsterorder->uuid }}"
           target="_blank">https://usaa.expressimagingservices.com/seqsterorders/step1/{{ $seqsterorder->uuid }}</a>
    @else
        <a href="https://www.expressimagingservices.com/seqsterorders/step1/{{ $seqsterorder->uuid }}"
           target="_blank">https://www.expressimagingservices.com/seqsterorders/step1/{{ $seqsterorder->uuid }}</a>
    @endif

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            seqsterorder
            @php dump(@$seqsterorder) @endphp
        </div>
    @endif

    <br />
    <br />

</x-user-layout>
