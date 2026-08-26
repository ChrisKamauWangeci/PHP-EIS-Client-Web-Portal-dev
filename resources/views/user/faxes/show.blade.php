<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Fax</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.faxes.index') }}"
               class="btn btn-sm btn-secondary">View Faxes</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $fax->id }}</td>
        </tr>
        <tr>
            <td>Product</td>
            <td>{{ $fax->product }}</td>
        </tr>
        <tr>
            <td>Client</td>
            <td>{{ $fax->client }}</td>
        </tr>
        <tr>
            <td>Workorder</td>
            <td>{{ $fax->workorder }}</td>
        </tr>
        <tr>
            <td>Fax Number</td>
            <td>{{ $fax->fax_number }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $fax->email }}</td>
        </tr>
        <tr>
            <td>Path</td>
            <td>{{ $fax->path }}</td>
        </tr>
        <tr>
            <td>File</td>
            <td>{{ $fax->file }}</td>
        </tr>
        <tr>
            <td>File Size</td>
            <td>{{ $fax->filesize }}</td>
        </tr>
        <tr>
            <td>File Size (Human Readable)</td>
            <td>{{ $fax->filesizehuman }}</td>
        </tr>
        <tr>
            <td>API ID</td>
            <td>{{ $fax->api_id }}</td>
        </tr>
        <tr>
            <td>API Filename</td>
            <td>{{ $fax->api_filename }}</td>
        </tr>
        <tr>
            <td>API Status (Upload)</td>
            <td>{{ $fax->api_status_upload }}</td>
        </tr>
        <tr>
            <td>API Status (Send)</td>
            <td>{{ $fax->api_status_send }}</td>
        </tr>
        <tr>
            <td>API Status (Delete)</td>
            <td>{{ $fax->api_status_delete }}</td>
        </tr>
        <tr>
            <td>API Status</td>
            <td>{{ $fax->api_status }}</td>
        </tr>
        <tr>
            <td>API Response (Delete)</td>
            <td>{{ $fax->api_response_delete }}</td>
        </tr>
        <tr>
            <td>API Message No</td>
            <td>{{ $fax->api_message_no }}</td>
        </tr>
        <tr>
            <td>API Message ID</td>
            <td>{{ $fax->api_message_id }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>{{ $fax->status }}</td>
        </tr>
        <tr>
            <td>Transmit Error Info</td>
            <td>{{ $fax->transmit_error_info }}</td>
        </tr>
        <tr>
            <td>Page Count</td>
            <td>{{ $fax->page_count }}</td>
        </tr>
        <tr>
            <td>Number of Attempts</td>
            <td>{{ $fax->number_of_attempts }}</td>
        </tr>
        <tr>
            <td>Call Duration</td>
            <td>{{ $fax->call_duration }}</td>
        </tr>
        <tr>
            <td>Total Transmit Time</td>
            <td>{{ $fax->total_transmit_time }}</td>
        </tr>
        <tr>
            <td>Upload At</td>
            <td>{{ $fax->upload_at }}</td>
        </tr>
        <tr>
            <td>Send At</td>
            <td>{{ $fax->send_at }}</td>
        </tr>
        <tr>
            <td>Delete At</td>
            <td>{{ $fax->delete_at }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $fax->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $fax->updated_at }}</td>
        </tr>
    </table>

    <br />
    <br />

</x-user-layout>
