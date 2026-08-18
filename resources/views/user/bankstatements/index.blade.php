<x-user-layout title="">

    <h1>Bank Statements</h1>

    <form method="GET" action="{{ route('user.bankstatements.index') }}">

        <div class="row">

            <div class="col-md-2">
                <x-form.input name="B_Workorder" label="B_Workorder" :value="request('B_Workorder')" autocomplete="off" />
            </div>

            <div class="col-md-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.bankstatements.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $bankstatements->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>id</th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'B_Workorder', 'sort_direction' => $sort_direction]) }}">B_Workorder</a></th>
                    <th>Description</th>
                    <th>IssueDate</th>
                    <th>Amount</th>
                    <th>Hospital</th>
                    <th>Note</th>
                    <th>IssueBy</th>
                    <th>IssueOn</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bankstatements as $bankstatement)
                    <tr>
                        <td>{{ $bankstatement->id }}</td>
                        <td>{{ $bankstatement->B_Workorder }}</td>
                        <td>{{ $bankstatement->B_Description }}</td>
                        <td>{{ $bankstatement->B_IssueDate }}</td>
                        <td>{{ $bankstatement->B_Amount }}</td>
                        <td>{{ $bankstatement->B_Hospital }}</td>
                        <td>{{ $bankstatement->B_Note }}</td>
                        <td>{{ $bankstatement->B_IssueBy }}</td>
                        <td>{{ $bankstatement->B_IssueOn }}</td>
                        <td><a href="{{ route('user.bankstatements.show', $bankstatement->id) }}" class="btn btn-xs btn-secondary">view</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $bankstatements->withQueryString()->links() }}

    <br />
    <br />

</x-user-layout>