<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Alternate Payment</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.alternatepayments.index') }}"
               class="btn btn-sm btn-secondary">View Alternate Payments</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $alternatepayment->A_ID }}</td>
        </tr>
        <tr>
            <td>Copy Service</td>
            <td>{{ $alternatepayment->A_CopyService }}</td>
        </tr>
        <tr>
            <td>Contact Name</td>
            <td>{{ $alternatepayment->A_ContactName }}</td>
        </tr>
        <tr>
            <td>Contact Email</td>
            <td>{{ $alternatepayment->A_ContactEmail }}</td>
        </tr>
        <tr>
            <td>Address</td>
            <td>{{ $alternatepayment->A_Address }}</td>
        </tr>
        <tr>
            <td>City</td>
            <td>{{ $alternatepayment->A_City }}</td>
        </tr>
        <tr>
            <td>State</td>
            <td>{{ $alternatepayment->A_State }}</td>
        </tr>
        <tr>
            <td>Zip</td>
            <td>{{ $alternatepayment->A_Zip }}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{ $alternatepayment->A_Phone }}</td>
        </tr>
        <tr>
            <td>Phone Ext</td>
            <td>{{ $alternatepayment->A_PhoneExt }}</td>
        </tr>
        <tr>
            <td>Fax</td>
            <td>{{ $alternatepayment->A_Fax }}</td>
        </tr>
        <tr>
            <td>Note</td>
            <td>{{ $alternatepayment->A_Note }}</td>
        </tr>
        <tr>
            <td>Update By</td>
            <td>{{ $alternatepayment->A_UpdateBy }}</td>
        </tr>
        <tr>
            <td>Update Date</td>
            <td>{{ $alternatepayment->A_UpdateDate }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('user.alternatepayments.edit', $alternatepayment->A_ID) }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />
    <br />

    @if (count($hospitals) > 0)

        <h3>Hospitals Related</h3>

        <div class="table-responsive">
            <table class="table table-sm table-hover table-bordered w-auto">
                <thead>
                    <tr>
                        <th>Facility / Hospital</th>
                        <th>Facility / Hospital 2</th>
                        <th>Address City State Zip</th>
                        <th>
                            Phone
                            <br />
                            Fax
                        </th>
                        <th>
                            Created
                            <br />
                            Created By
                            <br />
                            Updated
                            <br />
                            Updated By
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hospitals as $hospital)
                        <tr>
                            <td>{{ $hospital->H_Hospital }}</td>
                            <td>{{ $hospital->H_Hospital2 }}</td>
                            <td>
                                {{ $hospital->H_Address }}
                                <br />
                                {{ $hospital->H_City }}
                                {{ $hospital->H_State }}
                                {{ $hospital->H_Zip }}
                            </td>
                            <td nowrap>
                                tel: {{ $hospital->H_Phone }}
                                <br />
                                fax: {{ $hospital->H_Fax }}
                            </td>
                            <td nowrap>
                                {{ $hospital->H_Created?->format('m/d/Y') }}
                                <br />
                                {{ $hospital->created_by }}
                                <br />
                                {{ $hospital->H_UpdDate?->format('m/d/Y') }}
                                <br />
                                {{ $hospital->H_UpdUser }}
                            </td>
                            <td nowrap>
                                <a href="{{ route('user.hospitals.show', $hospital->H_ID) }}"
                                   class="btn btn-xs btn-secondary">View</a>
                                <br />
                                <a href="{{ route('user.hospitals.edit', $hospital->H_ID) }}"
                                   class="btn btn-xs btn-secondary">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endisset

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            alternatepayment
            @php dump(@$alternatepayment) @endphp
        </div>
    @endif

</x-user-layout>
