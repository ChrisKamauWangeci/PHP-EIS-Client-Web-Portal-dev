<x-user-layout title="">

    @if ($postname)
        <script>
             function post_value(value) {
                opener.hospitalform.alternatepayment.value = value;
                self.close();
            }
        </script>
    @endif

    <div class="row">
        <div class="col-6">
            <h1>Alternate Payments</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{ route('user.alternatepayments.create') }}" class="btn btn-sm btn-secondary">Create New</a>
        </div>
    </div>

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('user.alternatepayments.index') }}">

        @if ($postname)
            <input type="hidden" name="postname" value="1">
        @endif

        <div class="row">

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="A_CopyService" id="A_CopyService" label="Copy Service" :value="request('A_CopyService')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="A_City" id="A_City" label="City" :value="request('A_City')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="A_Zip" id="A_Zip" label="Zip Code" :value="request('A_Zip')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="A_Phone" id="A_Phone" label="Phone" :value="request('A_Phone')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="A_Fax" id="A_Fax" label="Fax" :value="request('A_Fax')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.alternatepayments.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />

    {{ $alternatepayments->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'A_CopyService', 'sort_direction' => $sort_direction]) }}">Copy Service</a></th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zip</th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'A_Phone', 'sort_direction' => $sort_direction]) }}">Phone</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'A_Fax', 'sort_direction' => $sort_direction]) }}">Fax</a></th>
                    <th>Update Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alternatepayments as $alternatepayment)
                    <tr>
                        <td>{{ $alternatepayment->A_CopyService }}</td>
                        <td>{{ $alternatepayment->A_Address }}</td>
                        <td>{{ $alternatepayment->A_City }}</td>
                        <td>{{ $alternatepayment->A_State }}</td>
                        <td>{{ $alternatepayment->A_Zip }}</td>
                        <td>{{ $alternatepayment->A_Phone }}</td>
                        <td>{{ $alternatepayment->A_Fax }}</td>
                        <td>{{ $alternatepayment->A_UpdateDate }}</td>
                        <td class="actions">
                            @if ($postname)
                                <button class="btn btn-xs btn-success" onclick="post_value('{{ $alternatepayment->A_CopyService }}');">Select</button>
                            @endif
                            <a href="{{ route('user.alternatepayments.show', $alternatepayment->A_ID) }}" class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $alternatepayments->withQueryString()->links() }}

</x-user-layout>