<x-pdf-layout title="">

    <table width="100%">
        <tr>
            <td align="">
                <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::size(60)->generate($workorder->W_WorkOrder)) }}"
                     class="m-2" />
            </td>
            <td align="right">
                <strong>{{ $requestnote ?? '1st' }} request</strong>

                <div class="text-center">
                    <h1>EXPRESS IMAGING SERVICES</h1>
                    <strong>P.O. Box 778, Torrance, CA 90508</strong>
                    -
                    Phone: <strong>{!! Helper::coverPagePhone($usersession) !!}</strong> &nbsp; &nbsp; Fax:
                    <strong>{!! Helper::coverPageFax($usersession) !!}</strong>
                </div>

            </td>
        </tr>
    </table>

    <div class="text-center">
        <strong>{!! nl2br($workorder->W_ExamStatus ?? '') !!}</strong>
    </div>

    <div class="p-1">

        <table width="100%">
            <tr>
                <td align="center">
                    <h2>REQUEST FOR MEDICAL RECORDS</h2>
                    Date: <strong>{{ date('M d, Y') }}</strong>
                    &nbsp; &nbsp; &nbsp; &nbsp;
                    WorkOrder: <strong> *** {{ $workorder->W_WorkOrder }} ***</strong>
                </td>
            </tr>
        </table>

    </div>

    <div class="p-1 border">
        <table class="table-borderless">
            <tr>
                <td valign="top">
                    <strong>{{ $hospital->H_Hospital2 ?: $hospital->H_Hospital }}</strong>
                    <br />
                    @if ($hospital->H_Affiliate)
                        <strong>{{ $hospital->H_Affiliate }}</strong>
                        <br />
                    @endif

                    Address:
                    <strong>
                        {{ $hospital->H_Address }}
                        {{ $hospital->H_City }}, {{ $hospital->H_State }} {{ $hospital->H_Zip }}
                    </strong>
                    <br />
                    Phone: <strong>{!! Helper::formatPhoneFax($hospital->H_Phone) !!}</strong>
                    -
                    Fax: <strong>{!! Helper::formatPhoneFax($hospital->H_Fax) !!}</strong>
                    <br />
                    Contact: <strong>RELEASE OF INFORMATION</strong>
                </td>
                <td nowrap
                    valign="top">
                    Patient: <strong>{{ $workorder->W_FirstName }} {{ $workorder->W_MiddleInit }}
                        {{ $workorder->W_LastName }}</strong>
                    <br />
                    DOB: <strong>{{ $workorder->W_DOB?->format('m/d/Y') }}</strong>
                    <br />
                    SSN: <strong>{!! Helper::ssn($usersession, $workorder->W_SS) !!}</strong>
                    <br />
                    MR#: <strong>{{ $workorder->W_RecordNo }}</strong>
                    <br />
                    Note: <strong>URGENT PLEASE!</strong>
                </td>
            </tr>
        </table>
    </div>

    <div class="p-1 border">
        <strong>Special Instructions:</strong>
        <div class="p-1"></div>
        Request For <strong>{!! Helper::recordYearsFromTo($workorder->W_YearsOfRecord, $workorder->W_ReceiveDate, '', $usersession) !!}</strong>
        <div class="p-1"></div>
        {!! nl2br($workorder->W_Note2 ?? '') !!}
    </div>

    <div class="p-1 border">
        <strong>Use one of the following options to send records to EIS</strong>
        <br />
        <strong>- UPLOAD</strong> https://{!! Helper::coverPageSubdomain($usersession) !!}.expressimagingservices.com/upload, Enter the Work
        Order # {{ $workorder->W_WorkOrder }} and the year {{ $workorder->W_DOB?->format('Y') }} as the DOB of the
        patient.
        <br />
        <strong>- EMAIL</strong> records@expressimagingservices.com
        <br />
        <strong>- FAX</strong> Faxed ___ Pages. Fax: {!! Helper::coverPageFax($usersession) !!} or Alt. Fax {!! Helper::coverPageFaxAlt($usersession) !!}
        <br />
        <strong>- MAIL</strong> P.O. BOX 778, TORRANCE, CA 90508
        <br />
        <strong>
            *In-house copy service - DO NOT copy before you call for fee approval, request subject
            to cancelation according to copy fee charqe. Standard fee is $15.00
        </strong>
    </div>

    <div class="p-1 border">
        <strong>Please initial next to the appropriate response.</strong>

        <table>
            <tr>
                <td class="p-1">
                    Authorization approved:
                    <br />
                    Yes ___ No ___
                </td>
                <td class="p-1">
                    Letter of Representation (LOR) required:
                    <br />
                    Yes ___ No ___
                </td>
                <td class="p-1">
                    Facility Authorization required:
                    <br />
                    Yes ___ No ___
                </td>
            </tr>
        </table>

    </div>

    If payment is required, please call us at {!! Helper::coverPagePhone($usersession) !!} or fax to {!! Helper::coverPageFax($usersession) !!} (alt. fax
    {!! Helper::coverPageFaxAlt($usersession) !!}). We can pay by credit card.

    <div class="pt-2 float-end small">
        {{ date('Y-m-d H:i:s') }}
    </div>

</x-pdf-layout>
