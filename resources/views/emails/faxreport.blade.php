<x-email>

    Fax Report

    <br />
    <br />

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Client</th>
                <th>File</th>
                <th>API Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['faxes'] as $fax)
                <tr>
                    <td>{{ $fax->id }}</td>
                    <td>{{ $fax->product }}</td>
                    <td>{{ $fax->client }}</td>
                    <td>{{ $fax->file }}</td>
                    <td>{{ $fax->api_status }}</td>
                    <td>{{ $fax->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br />
    <br />

</x-email>
