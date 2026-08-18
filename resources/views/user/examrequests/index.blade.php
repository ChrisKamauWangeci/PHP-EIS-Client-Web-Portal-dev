<x-user-layout title="">

    <div class="row">
        <div class="col-6">
            <h1>Examrequests</h1>
        </div>
        <div class="col-6 text-end">
        </div>
    </div>

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('user.examrequests.index') }}">
        <div class="row">
            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="E_WorkOrder" id="E_WorkOrder" label="WorkOrder" :value="$E_WorkOrder" />
            </div>
            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.examrequests.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <br />

    {{ $examrequests->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>WorkOrder</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($examrequests as $examrequest)
                    <tr>
                        <td>{{ $examrequest->E_WorkOrder }}</td>
                        <td>{{ $examrequest->E_Address }}</td>
                        <td>{{ $examrequest->E_City }}</td>
                        <td>{{ $examrequest->E_State }}</td>
                        <td class="actions">
                            <a href="{{ route('user.examrequests.show', $examrequest->E_WorkOrder) }}" class="btn btn-xs btn-secondary">view</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $examrequests->withQueryString()->links() }}

    <br />
    <br />

</x-user-layout>