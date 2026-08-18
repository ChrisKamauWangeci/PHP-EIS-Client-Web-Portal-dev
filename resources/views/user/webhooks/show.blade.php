<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Webhook</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.webhooks.index') }}" class="btn btn-sm btn-secondary">View Webhooks</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $webhook->id }}</td>
        </tr>
        <tr>
            <td>External ID</td>
            <td>{{ $webhook->external_id }}</td>
        </tr>
        <tr>
            <td>Source</td>
            <td>{{ $webhook->source }}</td>
        </tr>
        <tr>
            <td>Event</td>
            <td>{{ $webhook->event }}</td>
        </tr>
        <tr>
            <td>Headers</td>
            <td>
                <pre>{{ print_r($webhook->headers, true) }}</pre>
            </td>
        </tr>
        <tr>
            <td>Payload</td>
            <td>
                <pre>{{ json_encode($webhook->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
            </td>
        </tr>
        <tr>
            <td>Attempts</td>
            <td>{{ $webhook->attempts }}</td>
        </tr>
        <tr>
            <td>Error</td>
            <td>{{ $webhook->error }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>{{ $webhook->status }}</td>
        </tr>
        <tr>
            <td>Received At</td>
            <td>{{ $webhook->received_at }}</td>
        </tr>
        <tr>
            <td>Processed At</td>
            <td>{{ $webhook->processed_at }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $webhook->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $webhook->updated_at }}</td>
        </tr>
    </table>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            webhook
            @php dump(@$webhook); @endphp
        </div>
    @endif

</x-user-layout>
