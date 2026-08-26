<x-email>

    Filetransfer Report

    <br />
    <br />

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Contractor</th>
                <th>Direction</th>
                <th>File Type</th>
                <th>Filename</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['filetransfers'] as $filetransfers)
                <tr>
                    <td>{{ $filetransfers->id }}</td>
                    <td>{{ $filetransfers->contractor }}</td>
                    <td>{{ $filetransfers->direction }}</td>
                    <td>{{ $filetransfers->file_type }}</td>
                    <td>{{ $filetransfers->filename }}</td>
                    <td>{{ $filetransfers->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br />
    <br />

</x-email>
