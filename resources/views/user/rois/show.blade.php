<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>ROI</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.rois.index') }}"
               class="btn btn-sm btn-secondary">View ROI</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $roi->R_ID }}</td>
        </tr>
        <tr>
            <td>ROI Name</td>
            <td>{{ $roi->R_ROIname }}</td>
        </tr>
        <tr>
            <td>Contact Name</td>
            <td>{{ $roi->R_ContactName }}</td>
        </tr>
        <tr>
            <td>Contact Email</td>
            <td>{{ $roi->R_ContactEmail }}</td>
        </tr>
        <tr>
            <td>Address</td>
            <td>{{ $roi->R_Address }}</td>
        </tr>
        <tr>
            <td>City</td>
            <td>{{ $roi->R_City }}</td>
        </tr>
        <tr>
            <td>State</td>
            <td>{{ $roi->R_State }}</td>
        </tr>
        <tr>
            <td>Zip</td>
            <td>{{ $roi->R_Zip }}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{ $roi->R_Phone }}</td>
        </tr>
        <tr>
            <td>Phone Ext</td>
            <td>{{ $roi->R_PhoneExt }}</td>
        </tr>
        <tr>
            <td>Fax</td>
            <td>{{ $roi->R_Fax }}</td>
        </tr>
        <tr>
            <td>Note</td>
            <td>{{ $roi->R_Note }}</td>
        </tr>
        <tr>
            <td>Update By</td>
            <td>{{ $roi->R_UpdateBy }}</td>
        </tr>
        <tr>
            <td>Update Date</td>
            <td>{{ $roi->R_UpdateDate }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('user.rois.edit', $roi->R_ID) }}"
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
            roi
            @php dump(@$roi) @endphp
        </div>
    @endif

</x-user-layout>
