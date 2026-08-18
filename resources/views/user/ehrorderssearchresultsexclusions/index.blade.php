<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>EHR Orders Search Results Exclusions</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.ehrorders.index') }}" class="btn btn-sm btn-secondary">View EHR Orders</a>
            <a href="{{ route('user.ehrorderssearchresults.index') }}" class="btn btn-sm btn-secondary">View EHR Order Search Results</a>
            <a href="{{ route('user.ehrordersdocuments.index') }}" class="btn btn-sm btn-secondary">View EHR Order Documents</a>
        </div>
    </div>

    <br />
    <br />

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('user.ehrorderssearchresultsexclusions.index') }}">
        <div class="row">
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="managing_organization" id="managing_organization" label="Managing Organization" :value="request('managing_organization')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.ehrorderssearchresultsexclusions.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <br />
    <br />

    {{ $ehrorderssearchresultsexclusions->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover1 table-bordered w-auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Managing Organization</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ehrorderssearchresultsexclusions as $ehrorderssearchresultsexclusion)
                    <tr class="fw-bold">
                        <td>{{ $ehrorderssearchresultsexclusion->id }}</td>
                        <td>{{ $ehrorderssearchresultsexclusion->managing_organization }}</td>
                        <td>{{ $ehrorderssearchresultsexclusion->created_by }}</td>
                        <td>{{ $ehrorderssearchresultsexclusion->updated_by }}</td>
                        <td>{{ $ehrorderssearchresultsexclusion->created_at->format('m/d/Y g:i a') }}</td>
                        <td>{{ $ehrorderssearchresultsexclusion->updated_at->format('m/d/Y g:i a') }}</td>
                        <td>
                            <a href="{{ route('user.ehrorderssearchresultsexclusions.show', $ehrorderssearchresultsexclusion->id) }}" class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $ehrorderssearchresultsexclusions->withQueryString()->links() }}

    <br />
    <br />

    <a href="{{ route('user.ehrorderssearchresultsexclusions.create') }}" class="btn btn-sm btn-secondary">Add</a>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            ehrorderssearchresultsexclusions
            @php dump(@$ehrorderssearchresultsexclusions) @endphp
        </div>
    @endif

</x-user-layout>