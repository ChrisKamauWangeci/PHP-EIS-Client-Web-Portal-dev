<x-admin-layout title="">

    <h1>Bill To Picklists</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('admin.billtopicklists.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="BL_BillTo"
                              label="Bill To"
                              :value="request('BL_BillTo')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="BL_InsCompany"
                              label="Insurance Company"
                              :value="request('BL_InsCompany')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.billtopicklists.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $billtopicklists->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'BL_BillTo', 'sort_direction' => $sort_direction]) }}">Bill
                            To</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'BL_InsCompany', 'sort_direction' => $sort_direction]) }}">Insurance
                            Company</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'BL_MaxAmt', 'sort_direction' => $sort_direction]) }}">Max
                            Amount</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'BL_AuthFee', 'sort_direction' => $sort_direction]) }}">Auth
                            Fee</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'epic_fee', 'sort_direction' => $sort_direction]) }}">Epic
                            Fee</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'veradigm_fee', 'sort_direction' => $sort_direction]) }}">Veradigm
                            Fee</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($billtopicklists as $billtopicklist)
                    <tr>
                        <td>{{ $billtopicklist->BL_BillTo }}</td>
                        <td>{{ $billtopicklist->BL_InsCompany }}</td>
                        <td>{{ $billtopicklist->BL_MaxAmt }}</td>
                        <td>{{ $billtopicklist->BL_AuthFee }}</td>
                        <td>{{ $billtopicklist->epic_fee }}</td>
                        <td>{{ $billtopicklist->veradigm_fee }}</td>
                        <td nowrap>
                            <a href="{{ route('admin.billtopicklists.show', $billtopicklist->id) }}"
                               class="btn btn-xs btn-secondary">View</a>
                            <a href="{{ route('admin.billtopicklists.edit', $billtopicklist->id) }}"
                               class="btn btn-xs btn-secondary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $billtopicklists->withQueryString()->links() }}

    <br />

    <br />
    <br />


    @if ($adminsession['contractor']['accesslevel'])
        <a href="{{ route('admin.billtopicklists.create') }}"
           class="btn btn-sm btn-secondary">Add</a>
    @endif

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            billtopicklists
            @php dump(@$billtopicklists) @endphp
        </div>
    @endif

</x-admin-layout>
