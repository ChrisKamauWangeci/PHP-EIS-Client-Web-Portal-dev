<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Bill To Picklist</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.billtopicklists.index') }}"
               class="btn btn-sm btn-secondary">View Bill To Picklists</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $billtopicklist->id }}</td>
        </tr>
        <tr>
            <td>Bill To</td>
            <td>{{ $billtopicklist->BL_BillTo }}</td>
        </tr>
        <tr>
            <td>Insurance Company</td>
            <td>{{ $billtopicklist->BL_InsCompany }}</td>
        </tr>
        <tr>
            <td>Max Amount</td>
            <td>{{ $billtopicklist->BL_MaxAmt }}</td>
        </tr>
        <tr>
            <td>Auth Fee</td>
            <td>{{ $billtopicklist->BL_AuthFee }}</td>
        </tr>
        <tr>
            <td>Epic Fee</td>
            <td>{{ $billtopicklist->epic_fee }}</td>
        </tr>
        <tr>
            <td>Veradigm Fee</td>
            <td>{{ $billtopicklist->veradigm_fee }}</td>
        </tr>
        <tr>
            <td>Created By</td>
            <td>{{ $billtopicklist->created_by }}</td>
        </tr>
        <tr>
            <td>Updated By</td>
            <td>{{ $billtopicklist->updated_by }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $billtopicklist->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $billtopicklist->updated_at }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('admin.billtopicklists.edit', $billtopicklist->id) }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    {{-- <form method="POST" action="{{ route('admin.billtopicklists.destroy', $billtopicklist->id) }}">
            @csrf
            @method('DELETE')
            <x-form.button class="btn-danger" onclick="return confirm('Are you sure?')">Delete</x-form.button>
        </form> --}}

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            billtopicklist
            @php dump(@$billtopicklist) @endphp
        </div>
    @endif

    <br />
    <br />
    <br />

</x-admin-layout>
