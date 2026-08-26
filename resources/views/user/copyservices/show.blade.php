<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Copy Service</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.copyservices.index') }}"
               class="btn btn-sm btn-secondary">View Copy Services</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $copyservice->C_ID }}</td>
        </tr>
        <tr>
            <td>Copy Service</td>
            <td>{{ $copyservice->C_CopyService }}</td>
        </tr>
        <tr>
            <td>Contact Name</td>
            <td>{{ $copyservice->C_ContactName }}</td>
        </tr>
        <tr>
            <td>Contact Email</td>
            <td>{{ $copyservice->C_ContactEmail }}</td>
        </tr>
        <tr>
            <td>Address</td>
            <td>{{ $copyservice->C_Address }}</td>
        </tr>
        <tr>
            <td>City</td>
            <td>{{ $copyservice->C_City }}</td>
        </tr>
        <tr>
            <td>State</td>
            <td>{{ $copyservice->C_State }}</td>
        </tr>
        <tr>
            <td>Zip</td>
            <td>{{ $copyservice->C_Zip }}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{ $copyservice->C_Phone }}</td>
        </tr>
        <tr>
            <td>Phone Ext</td>
            <td>{{ $copyservice->C_PhoneExt }}</td>
        </tr>
        <tr>
            <td>Fax</td>
            <td>{{ $copyservice->C_Fax }}</td>
        </tr>
        <tr>
            <td>Note</td>
            <td>{{ $copyservice->C_Note }}</td>
        </tr>
        @if ($subdomain == 'eisdev')
            <tr>
                <td>Attestation Required</td>
                <td><img src="/img/icon_{{ $copyservice->attestation_required }}.png"
                         alt=""> {{ $copyservice->attestation_required ? 'Yes' : 'No ' }}</td>
            </tr>
            <tr>
                <td>Attestation File</td>
                <td>{{ $copyservice->attestation_file }}</td>
            </tr>
            <tr>
                <td>Attestation Expiration</td>
                <td>{{ $copyservice->attestation_expiration }}</td>
            </tr>
            <tr>
                <td>Attestation Created By</td>
                <td>{{ $copyservice->attestation_created_by }}</td>
            </tr>
            <tr>
                <td>Attestation Created At</td>
                <td>{{ $copyservice->attestation_created_at }}</td>
            </tr>
        @endif
        <tr>
            <td>Update By</td>
            <td>{{ $copyservice->C_UpdateBy }}</td>
        </tr>
        <tr>
            <td>Update Date</td>
            <td>{{ $copyservice->C_UpdateDate }}</td>
        </tr>
    </table>

    <br />
    <br />

    @if ($subdomain == 'eisdev')

        <div class="col-5">

            <h2>Attestation File</h2>

            @php
                $file = '\\\ftpserver\documents\copyservices\\' . $copyservice->attestation_file;
            @endphp

            @if (file_exists($file))

                <div class="text-success">{{ $file }}</div>

                <br />

                <a href="/user/files?file={{ $file }}&download=0"
                   class="btn btn-sm btn-secondary"
                   target="_blank">view</a>
                <a href="/user/files?file={{ $file }}&download=1"
                   class="btn btn-sm btn-secondary"
                   target="_self">download</a>
            @else
                <div class="text-danger">{{ $file }} does not exist</div>

            @endif

            <form method="post"
                  enctype="multipart/form-data"
                  action="{{ route('user.copyservices.fileupload', $copyservice->C_ID) }}">
                @csrf
                <input type="hidden"
                       name="filename"
                       value="{{ $copyservice->attestation_file }}">
                <x-form.input type="file"
                              name="uploadfile"
                              accept=".pdf"
                              required />
                <div class="p-1"></div>
                <x-form.button>Upload</x-form.button>
            </form>

        </div>

    @endif

    <br />
    <br />
    <br />
    <br />

    <a href="{{ route('user.copyservices.edit', $copyservice->C_ID) }}"
       class="btn btn-sm btn-secondary">Edit</a>

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
            copyservice
            @php dump(@$copyservice) @endphp
        </div>
    @endif

</x-user-layout>
