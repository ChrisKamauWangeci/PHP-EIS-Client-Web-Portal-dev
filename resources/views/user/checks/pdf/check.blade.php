<x-pdf-layout title="">

    <div id="date"
         class="text-right fw-bold">
        {{ date('M d, Y') }}
    </div>

    <div class="p-5"></div>

    <table class="w-100 table">
        <tr>
            <td class="pl-10 fw-bold">
                RECIPIENT
            </td>
            <td align="right"
                class="pr-1 fw-bold">
                ${{ number_format($amount, 2) }}
            </td>
        </tr>
    </table>

    <div class="p-2"></div>

    <div class="pl-1 fw-bold">
        {{ Number::spell($amount) }}
    </div>

    <div class="p-5"></div>

    <table class="w-100 table">
        <tr>
            <td class="pl-8 fw-bold">
                {{ $workorder->W_FirstName }} {{ $workorder->W_MiddleInit }} {{ $workorder->W_LastName }}
            </td>
            <td align="right">
                <img src="img/signature.png"
                     height="70"
                     class="">
            </td>
        </tr>
    </table>

    <br />
    <br />
    <br />

    Express Imaging Services
    <br />
    P.O. Box 778, Torrance, CA 90508
    <br />
    Email: records@expressimagingservices.com

    <br />
    <br />

    <div class="text-md">

        {{ date('M d, Y') }}

        <br />
        <br />

        {{ empty($hospital->H_Hospital2) ? $hospital->H_Hospital : $hospital->H_Hospital2 }}
        <br />
        {{ !empty(trim($hospital->H_Affiliate)) ? $hospital->H_Affiliate . '<br />' : '' }}

        {{ $hospital->H_Address }}
        <br />
        {{ $hospital->H_City }}, {{ $hospital->H_State }} {{ $hospital->H_Zip }}

        <br />
        <br />
        <br />

        Dear Sir/Madam,
        <br />
        <br />
        Enclosed is tear-away check for the retrieval of medical records belonging to {{ $workorder->W_FirstName }}
        {{ $workorder->W_MiddleInit }} {{ $workorder->W_LastName }}.
        <br />
        Please process this request promptly. Contact us if further information is needed.
        <br />
        <br />
        Sincerely,
        <br />
        Express Imaging Services

        <br />
        <br />

        <div class="mt-2 text-right text-xs">
            {{ date('Y-m-d H:i:s') }}
        </div>

    </div>

</x-pdf-layout>
