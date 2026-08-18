<x-user-layout title="">

    <h1>Prefill</h1>

    <br />

    <table class="table table-bordered table-sm w-auto">
        <tr>
            <td>Id</td>
            <td>{{ $prefill->id }}</td>
        </tr>
        <tr>
            <td>slug</td>
            <td>{{ $prefill->slug }}</td>
        </tr>
        <tr>
            <td>db</td>
            <td>{{ $prefill->db }}</td>
        </tr>
        <tr>
            <td>workorder_id</td>
            <td>{{ $prefill->workorder_id }}</td>
        </tr>
        <tr>
            <td>created_at</td>
            <td>{{ $prefill->created_at }}</td>
        </tr>
        <tr>
            <td>updated_at</td>
            <td>{{ $prefill->updated_at }}</td>
        </tr>
    </table>

    <br />
    <br />

</x-user-layout>