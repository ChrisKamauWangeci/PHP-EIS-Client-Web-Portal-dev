<x-pdf-layout title="">

    <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::size(60)->generate($workorder->W_WorkOrder)) }}" class="m-2" />

    <div class="text-center">
        <h1>EXPRESS IMAGING SERVICES</h1>
        P.O. Box 778, Torrance, CA 90508
        <br />
        Phone: <strong>{!! Helper::coverPagePhone($usersession) !!}</strong> &nbsp; &nbsp; Fax: <strong>{!! Helper::coverPageFax($usersession) !!}</strong>
    </div>

    <div class="p-1 text-center">
        @if ($requesttype == 'followup')
            <h2>FOLLOW UP REQUEST</h2>
        @endif
        @if ($requesttype == 'cancel')
            <h2>REQUEST CANCELLATION</h2>
        @endif
        @if ($requesttype == 'missingrecord')
            <h2>MISSING RECORDS</h2>
        @endif
    </div>

    <div class="p-1">
        Date: <strong>{{ date('M d, Y') }}</strong>
        &nbsp; &nbsp; &nbsp; &nbsp;
        WorkOrder: <strong>{{ $workorder->W_WorkOrder }}</strong>
    </div>

    <div class="p-1 border">

        <table class="table-borderless">
            <tr>
                <td>
                    <strong>
                        {{ $hospital->H_Hospital2 ?: $hospital->H_Hospital }}
                        @if ($hospital->H_Affiliate)
                            {{ $hospital->H_Affiliate }}
                            <br />
                        @endif

                        {{ $hospital->H_Address }}
                        <br />
                        {{ $hospital->H_City }}, {{ $hospital->H_State }} {{ $hospital->H_Zip }}
                    </strong>
                    <br />
                    Phone: <strong>{!! Helper::formatPhoneFax($hospital->H_Phone) !!}</strong>
                    <br />
                    Fax: <strong>{!! Helper::formatPhoneFax($hospital->H_Fax) !!}</strong>
                    <br />
                    Contact: <strong>RELEASE OF INFORMATION</strong>
                </td>
                <td nowrap>
                    Patient: <strong>{{ $workorder->W_FirstName }} {{ $workorder->W_MiddleInit }} {{ $workorder->W_LastName }}</strong>
                    <br />
                    DOB: <strong>{{ $workorder->W_DOB?->format('m/d/Y') }}</strong>
                    <br />
                    SSN: <strong>{!! Helper::ssn($usersession, $workorder->W_SS) !!}</strong>
                    <br />
                    MR#: <strong>{{ $workorder->W_RecordNo }}</strong>
                    <br />
                    <br />
                    Workorder Date: <strong>{{ $workorder->W_ReceiveDate?->format('M d, Y') }}</strong>
                </td>
            </tr>
        </table>

    </div>

    <div class="p-1 border">

        @if ($requesttype == 'followup')
            {!! nl2br($message ?? 'Please fax back this form to EIS when request to ready to copy') !!}
        @endif

        @if ($requesttype == 'cancel')
            {!! nl2br($message ?? 'Please cancel this request') !!}
        @endif

        @if ($requesttype == 'missingrecord')
            {!! nl2br($message ?? 'Missing Record') !!}
        @endif

    </div>

    <div class="p-1 border">
        <strong>Please provide new status to avoid unnecessary phone calls:</strong>
        <br />
        <br />
        <br />
        <br />
    </div>

    <div class="p-1 border">
        <strong>Use one of the following options to send records to EIS</strong>
        <br />
        <strong>UPLOAD:</strong> https://{!! Helper::coverPageSubdomain($usersession) !!}.expressimagingservices.com/upload, Enter the Work Order # {{ $workorder->W_WorkOrder }} and the year {{ $workorder->W_DOB?->format('Y') }} as the DOB of the patient.
        <br />
        <strong>EMAIL:</strong> records@expressimagingservices.com
        <br />
        <strong>FAX:</strong> Faxed ___ Pages. Fax: {!! Helper::coverPageFax($usersession) !!} or Alt. Fax {!! Helper::coverPageFaxAlt($usersession) !!}
        <br />
        <strong>MAIL:</strong> P.O. Box 778, Torrance, CA 90508
        <br />
        <strong>
            *In-house copy service - DO NOT copy before you call for fee approval, request subject
            to cancelation according to copy fee charqe. Standard fee is $15.00
        </strong>
    </div>

</x-pdf-layout>
