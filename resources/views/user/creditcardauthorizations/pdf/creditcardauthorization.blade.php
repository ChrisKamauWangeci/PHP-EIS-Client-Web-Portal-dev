<x-pdf-layout title="">

    <table width="100%">
        <tr>
            <td align="">
                <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::size(60)->generate($workorder->W_WorkOrder)) }}"
                     class="m-2" />
            </td>
        </tr>
    </table>

    <div class="text-center">
        <h1>EXPRESS IMAGING SERVICES</h1>
        P.O. Box 778, Torrance, CA 90508
        <br />
        Phone: <strong>{!! Helper::coverPagePhone($usersession) !!}</strong> &nbsp; &nbsp; Fax: <strong>{!! Helper::coverPageFax($usersession) !!}</strong>
    </div>

    <div class="p-1"></div>

    <div class="p-1 text-center">
        <h2>CREDIT CARD PAYMENT AUTHORIZATION</h2>
    </div>

    <strong>HAVE RECEIVED YOUR INVOICE FOR THE MEDICAL RECORDS OF THE PATIENT BELOW</strong>

    <div class="p-1"></div>

    <div class="p-1">
        Date: <strong>{{ date('M d, Y') }}</strong>
        &nbsp; &nbsp; &nbsp; &nbsp;
        WorkOrder: <strong>{{ $workorder->W_WorkOrder }}</strong>
    </div>

    <div class="p-1 border">
        <table class="table-borderless">
            <tr>
                <td>
                    <strong>{{ $hospital->H_Hospital2 ?? $hospital->H_Hospital }}</strong>
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
                    <br />
                    Fax: <strong>{!! Helper::formatPhoneFax($hospital->H_Fax) !!}</strong>
                    <br />
                    Contact: <strong>RELEASE OF INFORMATION</strong>
                    <br />
                    Dr. Fee: <strong>0.00</strong>
                </td>
                <td nowrap>
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
        <strong>PLEASE USE THE FOLLOWING CREDIT CARD INFORMATION TO PAY FOR THE INVOICE:</strong>
        <br />
        <br />
        Amount: <strong>${{ $dr_fee }}</strong>

        <br />
        <br />

        Card Number: <strong>{{ $creditcard->CC_No }}</strong>
        <br />
        Card Expiration Date: <strong>{{ $creditcard->ExpDate }}</strong>
        <br />
        CVC: <strong>{{ $creditcard->CVC_No }}</strong>
        <br />
        Card Name: <strong>{{ $creditcard->CC_Name }}</strong>
        <br />
        Card Billing Address: <strong>1805 W. 208th Street, Suite 202 Torrance, CA 90501</strong>
        <br />

    </div>

    <div class="p-1 border">

        <strong>For our record, please complete the section below and fax it back to us at {!! Helper::coverPageFax($usersession) !!}, or
            call us at {!! Helper::coverPagePhone($usersession) !!}</strong>

        <br />

        Accept credit card: &nbsp;Yes _____ &nbsp; No _____

        <br />

        Authorization Code: &nbsp;
        ______________________________

        <br />

        Check only, make check payable to: &nbsp;
        ______________________________

        <br />

        Turn around time for records to be sent: &nbsp;
        ______________________________

        <br />

        <strong>Please select from the following options for your preferred method of releasing medical
            records:</strong>

        <br />

        FAX: __________ MAIL: __________ FEDEX: __________ (we will arrange/pay)

        <br />

    </div>

    <div class="text-end small">
        {{ date('Y-m-d H:i:s') }}
    </div>

</x-pdf-layout>
