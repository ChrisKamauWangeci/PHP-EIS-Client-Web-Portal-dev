<x-user-layout title="">

    <br />
    <br />

    <form method="POST"
          action="{{ route('user.docusigns.setup') }}">
        @csrf
        @method('POST')

        <input type="hidden"
               name="workorder_id"
               value="{{ $workorder->W_WorkOrder }}">
        <input type="hidden"
               name="db"
               value="{{ $subdomain }}">

        <input type="hidden"
               name="environment"
               value="production">

        <input type="hidden"
               name="signingtype"
               value="embedded">

        <input type="hidden"
               name="slug"
               value="{{ $hospital->H_Docusign }}">

        <input type="hidden"
               name="client"
               value="{{ $workorder->Company_C_Name }}">
        <input type="hidden"
               name="company"
               value="{{ $workorder->Company_C_Name }}">

        <input type="hidden"
               name="requestor_name"
               value="{{ $workorder->Requestor_R_Name }}">
        <input type="hidden"
               name="requestor_email"
               value="{{ $workorder->Requestor_R_Email }}">

        <input type="hidden"
               name="agent"
               value="{{ $agent }}">
        <input type="hidden"
               name="agent_email"
               value="{{ $agent_email }}">

        <input type="hidden"
               name="insurance"
               value="{{ $workorder->W_InsCompany }}">

        <input type="hidden"
               name="eis_insurance"
               value="EIS / {{ $workorder->W_InsCompany }}">
        <input type="hidden"
               name="eis_fax"
               value="{!! Helper::coverPageFax($usersession) !!} / {!! Helper::coverPageFaxAlt($usersession) !!}">

        <input type="hidden"
               name="patient_first_name"
               value="{{ $workorder->W_FirstName }}">
        <input type="hidden"
               name="patient_middle_name"
               value="{{ $workorder->W_MiddleInit }}">
        <input type="hidden"
               name="patient_last_name"
               value="{{ $workorder->W_LastName }}">
        <input type="hidden"
               name="patient_birth_date"
               value="{{ $workorder->W_DOB->format('Y-m-d') ?? '' }}">
        <input type="hidden"
               name="patient_birth_date_mdy"
               value="{{ $workorder->W_DOB->format('m/d/Y') ?? '' }}">
        <input type="hidden"
               name="patient_social_security"
               value="{{ substr($workorder->W_SS ?? '', -4) }}">
        <input type="hidden"
               name="patient_social_security_full"
               value="{{ $workorder->W_SS }}">

        <input type="hidden"
               name="patient_phone"
               value="{{ $workorder->Examrequest_E_HomePhone ?? '' }}">
        <input type="hidden"
               name="patient_email"
               value="{{ $workorder->Examrequest_E_ApplicantEmail ?? 'sign@expressimagingservices.com' }}">

        <input type="hidden"
               name="patient_address"
               value="{{ $workorder->Examrequest_E_Address ?? '' }}">
        <input type="hidden"
               name="patient_city"
               value="{{ $workorder->Examrequest_E_City ?? '' }}">
        <input type="hidden"
               name="patient_state"
               value="{{ $workorder->Examrequest_E_State ?? '' }}">
        <input type="hidden"
               name="patient_zip_code"
               value="{{ $workorder->Examrequest_E_Zip ?? '' }}">

        <input type="hidden"
               name="patient_city_state_zip"
               value="{{ $workorder->Examrequest_E_City ?? '' }} {{ $workorder->Examrequest_E_State ?? '' }} {{ $workorder->Examrequest_E_Zip ?? '' }}">

        <input type="hidden"
               name="patient_full_address"
               value="{{ $workorder->Examrequest_E_Address ?? '' }} {{ $workorder->Examrequest_E_City ?? '' }} {{ $workorder->Examrequest_E_State ?? '' }} {{ $workorder->Examrequest_E_Zip ?? '' }}">

        <input type="hidden"
               name="email"
               value="sign@expressimagingservices.com">

        <input type="hidden"
               name="access_code"
               value="{{ substr($workorder->W_DOB ?? '', 0, 4) }}">

        <input type="hidden"
               name="W_ReceiveDate"
               value="{{ $workorder->W_ReceiveDate }}">
        <input type="hidden"
               name="W_YearsOfRecord"
               value="{{ $workorder->W_YearsOfRecord }}">

        <input type="hidden"
               name="dates_of_service_from"
               value="{!! Helper::recordYearsFrom($workorder->W_YearsOfRecord, $workorder->W_ReceiveDate, $workorder->W_DOB) !!}">

        @if ($usersession['subdomain'] != 'usaa')
            <input type="hidden"
                   name="dates_of_service_to"
                   value="PRESENT">
        @else
            <input type="hidden"
                   name="dates_of_service_to"
                   value="{!! Helper::recordYearsTo($workorder->W_YearsOfRecord, $workorder->W_ReceiveDate) !!}">
        @endif

        <input type="hidden"
               name="dates_of_service_combined"
               value="{!! Helper::recordYearsFromTo(
                   $workorder->W_YearsOfRecord,
                   $workorder->W_ReceiveDate,
                   $workorder->W_DOB,
                   $usersession,
               ) !!}">
        <input type="hidden"
               name="dates_of_service_combined_ymd"
               value="{!! Helper::recordYearsFromTo(
                   $workorder->W_YearsOfRecord,
                   $workorder->W_ReceiveDate,
                   $workorder->W_DOB,
                   $usersession,
                   'Y-m-d',
               ) !!}">

        <input type="hidden"
               name="facility_dr"
               value="{{ $hospital->H_Hospital }}">
        <input type="hidden"
               name="facility_name"
               value="{{ $hospital->H_Hospital2 }}">
        <input type="hidden"
               name="facility_phone"
               value="{{ $hospital->H_Phone }}">

        <input type="hidden"
               name="facility_address"
               value="{{ $hospital->H_Address }}">
        <input type="hidden"
               name="facility_city"
               value="{{ $hospital->H_City }}">
        <input type="hidden"
               name="facility_state"
               value="{{ $hospital->H_State }}">
        <input type="hidden"
               name="facility_zip_code"
               value="{{ $hospital->H_Zip }}">

        <input type="hidden"
               name="facility_city_state_zip"
               value="{{ $hospital->H_City }} {{ $hospital->H_State }} {{ $hospital->H_Zip }}">

        <input type="hidden"
               name="facility_full_address"
               value="{{ $hospital->H_Address }} {{ $hospital->H_City }} {{ $hospital->H_State }} {{ $hospital->H_Zip }}">

        <button type="submit"
                class="btn btn-sm btn-success">SARA Client with Docusign</button>
    </form>

    <br />
    <br />

</x-user-layout>
