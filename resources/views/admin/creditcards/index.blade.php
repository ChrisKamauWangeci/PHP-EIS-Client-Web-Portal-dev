<x-admin-layout title="">

    <h1>Credit Cards</h1>

    <br />
    <br />

    {{ $creditcards->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Card number</th>
                    <th>Card name</th>
                    <th>Expiration date</th>
                    <th>CVC</th>
                    <th>Created</th>
                    <th>Modified</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($creditcards as $creditcard)
                    <tr>
                        <td>{{ $creditcard->id }}</td>
                        <td>{{ $creditcard->CC_No }}</td>
                        <td>{{ $creditcard->CC_Name }}</td>
                        <td>{{ $creditcard->ExpDate }}</td>
                        <td>{{ $creditcard->CVC_No }}</td>
                        <td>{{ $creditcard->created }}</td>
                        <td>{{ $creditcard->modified }}</td>
                        <td>
                            <a href="{{ route('admin.creditcards.show', $creditcard->id ) }}" class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $creditcards->withQueryString()->links() }}

    <br />

    <a href="{{ route('admin.creditcards.create') }}" class="btn btn-sm btn-secondary">Add</a>

    <br />
    <br />

</x-admin-layout>