<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Credit Card</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.creditcards.index') }}"
               class="btn btn-sm btn-secondary">View Credit Cards</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $creditcard->id }}</td>
        </tr>
        <tr>
            <td>Card Number</td>
            <td>{{ $creditcard->CC_No }}</td>
        </tr>
        <tr>
            <td>Card Name</td>
            <td>{{ $creditcard->CC_Name }}</td>
        </tr>
        <tr>
            <td>Expiration Date</td>
            <td>{{ $creditcard->ExpDate }}</td>
        </tr>
        <tr>
            <td>CVC Number</td>
            <td>{{ $creditcard->CVC_No }}</td>
        </tr>
        <tr>
            <td>Created</td>
            <td>{{ $creditcard->created }}</td>
        </tr>
        <tr>
            <td>Modified</td>
            <td>{{ $creditcard->modified }}</td>
        </tr>

    </table>

    <br />

    <a href="{{ route('admin.creditcards.edit', $creditcard->id) }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <form method="POST"
          action="{{ route('admin.creditcards.destroy', $creditcard->id) }}">
        @csrf
        @method('DELETE')
        <x-form.button class="btn btn-sm btn-danger"
                       onclick="return confirm('Are you sure?')">Delete</x-form.button>
    </form>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            creditcard
            @php dump(@$creditcard) @endphp
        </div>
    @endif

    <br />
    <br />

</x-admin-layout>
