<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>EHR Order Search Result</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.ehrorderssearchresults.index') }}"
               class="btn btn-sm btn-secondary">View EHR Order Search Results</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $ehrorderssearchresult->id }}</td>
        </tr>
        <tr>
            <td>UUID</td>
            <td>{{ $ehrorderssearchresult->uuid }}</td>
        </tr>
        <tr>
            <td>EHR Order ID</td>
            <td>{{ $ehrorderssearchresult->ehrorder_id }}</td>
        </tr>
        <tr>
            <td>Work Order ID</td>
            <td>{{ $ehrorderssearchresult->workorder_id }}</td>
        </tr>
        <tr>
            <td>Service Provider</td>
            <td>{{ $ehrorderssearchresult->service_provider }}</td>
        </tr>
        <tr>
            <td>Entry Type</td>
            <td>{{ $ehrorderssearchresult->entry_type }}</td>
        </tr>
        <tr>
            <td>Managing Organization</td>
            <td>{{ $ehrorderssearchresult->managing_organization }}</td>
        </tr>
        <tr>
            <td>Company Name</td>
            <td>{{ $ehrorderssearchresult->company_name }}</td>
        </tr>
        <tr>
            <td>FHIR Patient ID</td>
            <td>{{ $ehrorderssearchresult->fhir_patient_id }}</td>
        </tr>
        <tr>
            <td>FHIR Consent ID</td>
            <td>{{ $ehrorderssearchresult->fhir_consent_id }}</td>
        </tr>
        <tr>
            <td>Consent Required</td>
            <td>{{ $ehrorderssearchresult->consent_required }}</td>
        </tr>
        <tr>
            <td>Person Status</td>
            <td>{{ $ehrorderssearchresult->person_status }}</td>
        </tr>
        <tr>
            <td>Document Status</td>
            <td>{{ $ehrorderssearchresult->document_status }}</td>
        </tr>
        <tr>
            <td>Operation Outcome</td>
            <td class="{{ !empty($ehrorderssearchresult->operation_outcome) ? 'bg-danger-subtle' : '' }}">
                {{ $ehrorderssearchresult->operation_outcome }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>{{ $ehrorderssearchresult->status }}</td>
        </tr>
        <tr>
            <td>Is Active</td>
            <td><img src="/img/icon_{{ $ehrorderssearchresult->is_active }}.png"
                     alt=""></td>
        </tr>
        <tr>
            <td>Created By</td>
            <td>{{ $ehrorderssearchresult->created_by }}</td>
        </tr>
        <tr>
            <td>Updated By</td>
            <td>{{ $ehrorderssearchresult->updated_by }}</td>
        </tr>
        <tr>
            <td>Requested At</td>
            <td>{{ $ehrorderssearchresult->requested_at }}</td>
        </tr>
        <tr>
            <td>Submitted At</td>
            <td>{{ $ehrorderssearchresult->submitted_at }}</td>
        </tr>
        <tr>
            <td>Operation Outcome At</td>
            <td>{{ $ehrorderssearchresult->operation_outcome_at }}</td>
        </tr>
        <tr>
            <td>Received At</td>
            <td>{{ $ehrorderssearchresult->received_at }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $ehrorderssearchresult->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $ehrorderssearchresult->updated_at }}</td>
        </tr>
    </table>

    <br />
    <br />

    <!-- <pre>
    {{ $ehrorderssearchresult->rawdata }}
    </pre> -->

    <br />
    <br />

    <!-- <a href="{{ route('user.ehrorderssearchresults.edit', $ehrorderssearchresult->id) }}" class="btn btn-sm btn-secondary">Edit</a> -->

    <br />
    <br />

    <!-- <form method="POST" action="{{ route('user.ehrorderssearchresults.destroy', $ehrorderssearchresult->id) }}">
        @csrf
        @method('DELETE')
        <x-form.button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</x-form.button>
    </form> -->

    <br />
    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            ehrorderssearchresult
            @php dump(@$ehrorderssearchresult) @endphp
        </div>
    @endif

</x-user-layout>
