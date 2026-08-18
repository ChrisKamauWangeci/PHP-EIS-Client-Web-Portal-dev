<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>EHR Order Document</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.ehrordersdocuments.index') }}" class="btn btn-sm btn-secondary">View EHR Documents</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $ehrordersdocument->id }}</td>
        </tr>
        <tr>
            <td>UUID</td>
            <td>{{ $ehrordersdocument->uuid }}</td>
        </tr>
        <tr>
            <td>EHR Order ID</td>
            <td>{{ $ehrordersdocument->ehrorder_id }}</td>
        </tr>
        <tr>
            <td>EHR Orders Search Result ID</td>
            <td>{{ $ehrordersdocument->ehrorderssearchresult_id }}</td>
        </tr>
        <tr>
            <td>Workorder ID</td>
            <td>{{ $ehrordersdocument->workorder_id }}</td>
        </tr>
        <tr>
            <td>FHIR Patient ID</td>
            <td>{{ $ehrordersdocument->fhir_patient_id }}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{ $ehrordersdocument->name }}</td>
        </tr>
        <tr>
            <td>Event Date</td>
            <td>{{ $ehrordersdocument->event_date }}</td>
        </tr>
        <tr>
            <td>Description</td>
            <td>{{ $ehrordersdocument->description }}</td>
        </tr>
        <tr>
            <td>FHIR Document ID</td>
            <td>{{ $ehrordersdocument->fhir_document_id }}</td>
        </tr>
        <tr>
            <td>File Name</td>
            <td>{{ $ehrordersdocument->file_name }}</td>
        </tr>
        <tr>
            <td>File Type</td>
            <td>{{ $ehrordersdocument->file_type }}</td>
        </tr>
        <tr>
            <td>File Size</td>
            <td>{{ $ehrordersdocument->file_size }}</td>
        </tr>
        <tr>
            <td>Download Duration</td>
            <td>{{ $ehrordersdocument->download_duration }}</td>
        </tr>
        <tr>
            <td>JSON Filename</td>
            <td>{{ $ehrordersdocument->json_filename }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>{{ $ehrordersdocument->status }}</td>
        </tr>
        <tr>
            <td>Retry Count</td>
            <td>{{ $ehrordersdocument->retry_count }}</td>
        </tr>
        <tr>
            <td>Is Processing</td>
            <td>{{ $ehrordersdocument->is_processing }}</td>
        </tr>
        <tr>
            <td>Processing At</td>
            <td>{{ $ehrordersdocument->processing_at }}</td>
        </tr>
        <tr>
            <td>Received At</td>
            <td>{{ $ehrordersdocument->received_at }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $ehrordersdocument->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $ehrordersdocument->updated_at }}</td>
        </tr>
    </table>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            ehrordersdocument
            @php dump(@$ehrordersdocument) @endphp
        </div>
    @endif

    <br />
    <br />

</x-user-layout>