<h1>{{ $contractorlogin->id }}</h1>

<br />

<table class="table table-hover table-bordered table-sm table-hover w-auto">
    <tr>
        <th>ID</th>
        <td>{{ $contractorlogin->id }}</td>
    </tr>
    <tr>
        <th>Contractor ID</th>
        <td>{{ $contractorlogin->contractor_id }}</td>
    </tr>
    <tr>
        <th>Contractor</th>
        <td>{{ $contractorlogin->contractor }}</td>
    </tr>
    <tr>
        <th>IP Address</th>
        <td>{{ $contractorlogin->ip_address }}</td>
    </tr>
    <tr>
        <th>Remote Host</th>
        <td>{{ $contractorlogin->remote_host }}</td>
    </tr>
    <tr>
        <th>Page Views</th>
        <td>{{ $contractorlogin->page_views }}</td>
    </tr>
    <tr>
        <th>Uploads</th>
        <td>{{ $contractorlogin->uploads }}</td>
    </tr>
    <tr>
        <th>Downloads</th>
        <td>{{ $contractorlogin->downloads }}</td>
    </tr>
    <tr>
        <th>Logout At</th>
        <td>{{ $contractorlogin->logout_at }}</td>
    </tr>
    <tr>
        <th>Created At</th>
        <td>{{ $contractorlogin->created_at }}</td>
    </tr>
    <tr>
        <th>Updated At</th>
        <td>{{ $contractorlogin->updated_at }}</td>
    </tr>
</table>
