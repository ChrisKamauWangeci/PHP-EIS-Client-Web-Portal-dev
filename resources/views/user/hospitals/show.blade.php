<x-user-layout title="">

    <div class="row">
        <div class="col">
            <h1>{{ $hospital->H_Hospital }}</h1>
        </div>
        <div class="col-auto text-end">
            <a href="{{ route('user.hospitals.index') }}" class="btn btn-sm btn-secondary">Hospitals</a>
            &nbsp;
            <a href="{{ route('user.hospitals.edit', $hospital->H_ID) }}" class="btn btn-sm btn-secondary">Edit Hospital</a>
        </div>
    </div>

    <br />

    <div class="container-fluid">
        <div class="row">

            <div class="col-6 col-sm-4 col-md-3 border">
                Dr/Facility
                <br />
                <strong>{{ $hospital->H_Hospital }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Dr/Facility 2
                <br />
                <strong>{{ $hospital->H_Hospital2 }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Hospital / Affiliate
                <br />
                <strong>{{ $hospital->H_Affiliate }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Copy Service
                <br />
                <strong>{{ $hospital->H_CopyService }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Contact Name
                <br />
                <strong>{{ $hospital->H_ContactName }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Phone
                <br />
                <strong>{{ Helper::formatPhoneFax($hospital->H_Phone) }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Phone Ext
                <br />
                <strong>{{ $hospital->H_PhoneExt }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Fax
                <br />
                <strong>{{ Helper::formatPhoneFax($hospital->H_Fax) }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Address
                <br />
                <strong>{{ $hospital->H_Address }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                City
                <br />
                <strong>{{ $hospital->H_City }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                State
                <br />
                <strong>{{ $hospital->H_State }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Zip Code
                <br />
                <strong>{{ $hospital->H_Zip }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Alternate Payment
                <br />
                <strong>{{ $hospital->H_AlternatePayment }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Special Auth Form Required
                <br />
                <strong>{{ $hospital->H_SpecialAuth ? 'Yes' : 'No' }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Allow E-Signature
                <br />
                <strong>{{ $hospital->H_NoEsignature ? 'Yes' : 'No' }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Turnaround (days)
                <br />
                <strong>{{ $hospital->H_TurnOverDays }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Response Time (days)
                <br />
                <strong>{{ $hospital->H_ResponseTime }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                LOR
                <br />
                <strong>{{ $hospital->H_LOR ? 'Yes' : 'No' }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                ROI
                <br />
                <strong>{{ $hospital->H_ROI }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Send Method
                <br />
                <strong>{!! Helper::method($hospital->H_SendMethod) !!}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Receive Method
                <br />
                <strong>{!! Helper::method($hospital->H_ReceiveMethod) !!}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                CIOX Site ID
                <br />
                <strong>{{ $cioxsiteid->C_SiteID ?? 'not set' }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Upload By
                <br />
                <strong>{{ $hospital->upload_by }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                File Upload Date
                <br />
                <strong>{{ $hospital->upload_date }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Docusign
                <br />
                <strong>{{ $hospital->H_Docusign }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Auth / Docusign Updated
                <br />
                <strong>{{ $hospital->auth_docusign_changed }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                facilityform_update
                <br />
                <strong>{{ $hospital->facilityform_update }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Timezone Offset
                <br />
                <strong>{{ $hospital->timezone_offset }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Created
                <br />
                <strong>{{ $hospital->H_Created }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Updated
                <br />
                <strong>{{ $hospital->H_UpdDate }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Created By
                <br />
                <strong>{{ $hospital->created_by }}</strong>
            </div>

            <div class="col-6 col-sm-4 col-md-3 border">
                Updated By
                <br />
                <strong>{{ $hospital->H_UpdUser }}</strong>
            </div>

        </div>
    </div>

    <br />

    <h5>New Facility Form (used for Docusign)</h5>
    @if (is_file('\\\ftpserver\ftpserver\facilityforms\\' . $hospital->H_SpecialAuthFile))
        <a href="/user/files?file=\\ftpserver\ftpserver\facilityforms\{{ $hospital->H_SpecialAuthFile }}&download=1">\\ftpserver\ftpserver\facilityforms\{{ $hospital->H_SpecialAuthFile }}</a>
        <br />
    @else
        Form Not Found
        <br />
    @endif

    <br />

    @php
        $dirremote = '\\\server2\eisaccess\facilityforms\\';
        $authorizationfile = Str::slug($hospital->H_Hospital2 ?? '', '-');
        $file = $dirremote . $authorizationfile;
    @endphp

    <h5>Facility Forms</h5>

    @if ($hospital->H_Hospital2 && is_file($dirremote . $authorizationfile . '.tif'))
        <a href="/user/files?file={{ $file }}.tif&download=1">{{ $file }}.tif</a>
        <br />
    @endif

    @if ($hospital->H_Hospital2 && is_file($dirremote . $authorizationfile . '.pdf'))
        <a href="/user/files?file={{ $file }}.pdf&download=1">{{ $file }}.pdf</a>
        <br />
    @endif

    <br />

    <div class="col-5">
        <h5>Facility Form File Upload</h5>

        @if ($hospital->H_Hospital2)
            <form method="post" enctype="multipart/form-data" action="{{ route('user.hospitals.fileupload', $hospital->H_ID) }}">
                @csrf
                <input type="hidden" name="filename" value="{{ $authorizationfile }}">

                <x-form.input type="file" name="uploadfile" accept=".pdf,.tif" required />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>
        @else
            Dr/Facility 2 - is empty
        @endif
    </div>

    <br />
    <br />

    <h5>Copy Schedule</h5>

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>
                Mon From:
                {{ $hospital->H_MonFrom }}
            </td>
            <td>
                Mon To:
                {{ $hospital->H_MonTo }}
            </td>
            <td>
                Mon From 2:
                {{ $hospital->H_MonFrom2 }}
            </td>
            <td>
                Mon To 2:
                {{ $hospital->H_MonTo2 }}
            </td>
        </tr>
        <tr>
            <td>
                Tue From:
                {{ $hospital->H_TueFrom }}
            </td>
            <td>
                Tue To:
                {{ $hospital->H_TueTo }}
            </td>
            <td>
                Tue From 2:
                {{ $hospital->H_TueFrom2 }}
            </td>
            <td>
                Tue To 2:
                {{ $hospital->H_TueTo2 }}
            </td>
        </tr>
        <tr>
            <td>
                Wed From:
                {{ $hospital->H_WedFrom }}
            </td>
            <td>
                Wed To:
                {{ $hospital->H_WedTo }}
            </td>
            <td>
                Wed From 2:
                {{ $hospital->H_WedFrom2 }}
            </td>
            <td>
                Wed To 2:
                {{ $hospital->H_WedTo2 }}
            </td>
        </tr>
        <tr>
            <td>
                Thu From:
                {{ $hospital->H_ThuFrom }}
            </td>
            <td>
                Thu To:
                {{ $hospital->H_ThuTo }}
            </td>
            <td>
                Thu From 2:
                {{ $hospital->H_ThuFrom2 }}
            </td>
            <td>
                Thu To 2:
                {{ $hospital->H_ThuTo2 }}
            </td>
        </tr>
        <tr>
            <td>
                Fri From:
                {{ $hospital->H_FriFrom }}
            </td>
            <td>
                Fri To:
                {{ $hospital->H_FriTo }}
            </td>
            <td>
                Fri From 2:
                {{ $hospital->H_FriFrom2 }}
            </td>
            <td>
                Fri To 2:
                {{ $hospital->H_FriTo2 }}
            </td>
        </tr>
    </table>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <div class="border p-2">
                <h4>Caller Instructions</h4>
                {!! nl2br($hospital->H_Note ?? '') !!}
            </div>
            <br />

            <div class="border p-2">
                <h4>Driver Instructions</h4>
                {!! nl2br($hospital->H_NoteDriver ?? '') !!}
            </div>
            <br />

            <div class="border p-2">
                <h4>Uploader Notes</h4>
                {!! nl2br($hospital->H_NoteUploader ?? '') !!}
            </div>
            <br />

        </div>
        <div class="col-sm-6">

            <div class="border p-2">
                <h4>Billing Notes</h4>
                {!! nl2br($hospital->H_NoteBilling ?? '') !!}
            </div>
            <br />

            <div class="border p-2">
                <h4>Notes</h4>
                {!! nl2br($hospital->H_Note2 ?? '') !!}
            </div>
            <br />

        </div>
    </div>

    <br />
    <br />

    @php
        $directory = '\\\server2\eisaccess\\' . $subdomain . '\\AuthForms\\';
        if ($subdomain == 'eis') {
            $directory = '\\\server2\eisaccess\AuthForms\\';
        }
    @endphp

    <h4>Related Workorders</h4>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm table-hover w-auto">
            <thead>
                <tr>
                    <th>WO</th>
                    <th>Last Name</th>
                    <th>Policy Number</th>
                    <th>Facility / Hospital</th>
                    <th>Contractor</th>
                    <th>Received</th>
                    <th>Follow up</th>
                    <th>Completed</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workorders as $workorder)
                    <tr>
                        <td small nowrap>
                            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}">{!! $workorder->W_WorkOrder !!}</a>
                            <br />
                            {!! Helper::statusesIcons($workorder->W_Status) !!}
                            {!! Helper::UrgentIcons($workorder->W_Urgent) !!}
                        </td>
                        <td>{{ $workorder->W_FirstName }} {{ $workorder->W_MiddleInit }} {{ $workorder->W_LastName }}</td>
                        <td>{{ $workorder->W_InsPolicy }}</td>
                        <td>
                            {{ $workorder->W_Hospital }}
                            <br />
                            {{ $workorder->H_Affiliate }}
                            <br />
                            {{ $workorder->H_ContactName }}
                        </td>
                        <td>{{ $workorder->W_Contractor }}</td>
                        <td nowrap>{{ $workorder->W_ReceiveDate?->format('m/d/Y') }}</td>
                        <td nowrap>{{ $workorder->W_FollowUpDt?->format('m/d/Y') }}</td>
                        <td nowrap>{{ $workorder->W_CompletedDate?->format('m/d/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            hospital
            @php dump(@$hospital) @endphp
        </div>
    @endif

</x-user-layout>
