<x-admin-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Docusign Document</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.docusigndocuments.index') }}" class="btn btn-sm btn-secondary">View Docusign Documents</a>
        </div>
    </div>

    <br />

    <table class="table table-bordered table-sm w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $docusigndocument->id }}</td>
        </tr>
        <tr>
            <td>Envelope ID</td>
            <td>{{ $docusigndocument->envelopeid }}</td>
        </tr>
        <tr>
            <td>Template ID</td>
            <td>{{ $docusigndocument->templateid }}</td>
        </tr>
        <tr>
            <td>Environment</td>
            <td>{{ $docusigndocument->environment }}</td>
        </tr>
        <tr>
            <td>Signing Type</td>
            <td>{{ $docusigndocument->signingtype }}</td>
        </tr>
        <tr>
            <td>Slug</td>
            <td>{{ $docusigndocument->slug }}</td>
        </tr>
        <tr>
            <td>DB</td>
            <td>{{ $docusigndocument->db }}</td>
        </tr>
        <tr>
            <td>Workorder ID</td>
            <td>{{ $docusigndocument->workorder_id }}</td>
        </tr>
        <tr>
            <td>Client</td>
            <td>{{ $docusigndocument->client }}</td>
        </tr>
        <tr>
            <td>Company</td>
            <td>{{ $docusigndocument->company }}</td>
        </tr>
        <tr>
            <td>Requestor</td>
            <td>{{ $docusigndocument->requestor }}</td>
        </tr>
        <tr>
            <td>First Name</td>
            <td>{{ $docusigndocument->first_name }}</td>
        </tr>
        <tr>
            <td>Middle Name</td>
            <td>{{ $docusigndocument->middle_name }}</td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td>{{ $docusigndocument->last_name }}</td>
        </tr>
        <tr>
            <td>Social Security</td>
            <td>{{ $docusigndocument->social_security }}</td>
        </tr>
        <tr>
            <td>Birth Date</td>
            <td>{{ $docusigndocument->birth_date }}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{ $docusigndocument->phone }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $docusigndocument->email }}</td>
        </tr>
        <tr>
            <td>Dates of Service From</td>
            <td>{{ $docusigndocument->dates_of_service_from }}</td>
        </tr>
        <tr>
            <td>Access Code</td>
            <td>{{ $docusigndocument->access_code }}</td>
        </tr>
        <tr>
            <td>IP Address</td>
            <td>{{ $docusigndocument->ip_address }}</td>
        </tr>
        <tr>
            <td>Remote Host</td>
            <td>{{ $docusigndocument->remote_host }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>{{ $docusigndocument->status }}</td>
        </tr>
        <tr>
            <td>Statuses</td>
            <td>{!! nl2br($docusigndocument->statuses) !!}</td>
        </tr>
        <tr>
            <td>Email Opened At</td>
            <td>{{ $docusigndocument->email_opened_at }}</td>
        </tr>
        <tr>
            <td>Signed At</td>
            <td>{{ $docusigndocument->signed_at }}</td>
        </tr>
        <tr>
            <td>Downloaded At</td>
            <td>{{ $docusigndocument->downloaded_at }}</td>
        </tr>
        <tr>
            <td>Processed At</td>
            <td>{{ $docusigndocument->processed_at }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $docusigndocument->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $docusigndocument->updated_at }}</td>
        </tr>
    </table>

    <br />

    <pre>
    {{ $docusigndocument->raw_data }}
    </pre>

    <br />

</x-admin-layout>