<x-user-layout>

    <h1>Company Update</h1>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>id</td>
            <td>{{ $companyupdate->id }}</td>
        </tr>
        <tr>
            <td>name</td>
            <td>{{ $companyupdate->name }}</td>
        </tr>
        <tr>
            <td>filename</td>
            <td>{{ $companyupdate->filename }}</td>
        </tr>
        <tr>
            <td>created_at</td>
            <td>{{ $companyupdate->created_at }}</td>
        </tr>
    </table>

    <br />
    <br />

</x-user-layout>
