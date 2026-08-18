<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Existing Signatures for Workorder: {{ $workorder->W_WorkOrder }}</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}" class="btn btn-sm btn-secondary">View Workorder</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>id</th>
                    <th>db</th>
                    <th>workorder_id</th>
                    <th>facility</th>
                    <th>company</th>
                    <th>requestor</th>
                    <th>
                        first_name
                        last_name
                    </th>
                    <th>status</th>
                    <th>created_at</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($docusigndocuments as $docusigndocument)
                    <tr>
                        <td>{{ $docusigndocument->id }}</td>
                        <td>{{ $docusigndocument->db }}</td>
                        <td>{{ $docusigndocument->workorder_id }}</td>
                        <td>
                            {{ $docusigndocument->facility }}
                            <br />
                            <small>{{ $docusigndocument->slug }}</small>
                        </td>
                        <td>{{ $docusigndocument->company }}</td>
                        <td>{{ $docusigndocument->requestor }}</td>
                        <td>
                            {{ $docusigndocument->first_name }}
                            {{ $docusigndocument->last_name }}
                        </td>
                        <td>{{ $docusigndocument->status }}</td>
                        <td>{{ $docusigndocument->created_at }}</td>
                        <td class="actions">
                            <a href="{{ route('user.docusigndocuments.show', $docusigndocument->id) }}" class="btn btn-xs btn-secondary">view</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br />
    <br />

    <h2>In-house Prefill</h2>

    <div class="col-md-5">

        <form method="get" action="{{ route('user.signforms.create') }}">
            <input type="hidden" name="path" value="{{ $subdomain }}">
            <input type="hidden" name="workorder_id" value="{{ $workorder->W_WorkOrder }}">
            <input type="hidden" name="db" value="{{ $subdomain }}">
            <input type="hidden" name="environment" value="production">
            <input type="hidden" name="signingtype" value="embedded">

            <input type="hidden" name="slug" value="{{ $hospital->H_Docusign }}">

            <input type="hidden" name="client" value="{{ $workorder->Requestor_R_Company }}">

            <!-- eis_insurance -->
            <!-- <br /> -->
            <input type="hidden" name="eis_insurance" value="EIS / {{ $workorder->W_InsCompany }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- eis_name -->
            <!-- <br /> -->
            <input type="hidden" name="eis_name" value="EIS" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- eis_info -->
            <!-- <br /> -->
            <input type="hidden" name="eis_info" value="EIS INFO" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- eis_address -->
            <!-- <br /> -->
            <input type="hidden" name="eis_address" value="P.O. Box 778 Torrance CA 90508" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- eis_street -->
            <!-- <br /> -->
            <input type="hidden" name="eis_street" value="P.O. Box 778" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- eis_city -->
            <!-- <br /> -->
            <input type="hidden" name="eis_city" value="Torrance" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- eis_state -->
            <!-- <br /> -->
            <input type="hidden" name="eis_state" value="CA" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- eis_zip -->
            <!-- <br /> -->
            <input type="hidden" name="eis_zip" value="90508" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- eis_phone -->
            <!-- <br /> -->
            <input type="hidden" name="eis_phone" value="(888) 846-8804" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- eis_fax -->
            <!-- <br /> -->
            <input type="hidden" name="eis_fax" value="{!! Helper::coverPageFax($usersession) !!} / {!! Helper::coverPageFaxAlt($usersession) !!}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- eis_email -->
            <!-- <br /> -->
            <input type="hidden" name="eis_email" value="records@expressimagingservices.com" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- patient_first_name -->
            <!-- <br /> -->
            <input type="hidden" name="patient_first_name" value="{!! $workorder->W_FirstName !!}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- patient_middle_name -->
            <!-- <br /> -->
            <input type="hidden" name="patient_middle_name" value="{!! $workorder->W_MiddleInit !!}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- patient_last_name -->
            <!-- <br /> -->
            <input type="hidden" name="patient_last_name" value="{!! $workorder->W_LastName !!}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- patient_full_name -->
            <!-- <br /> -->
            <input type="hidden" name="patient_full_name" value="{!! $workorder->W_FirstName !!} {!! $workorder->W_MiddleInit !!} {!! $workorder->W_LastName !!}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- patient_birth_date -->
            <!-- <br /> -->
            <input type="hidden" name="patient_birth_date" value="{{ substr($workorder->W_DOB ?? '', 0, 10) }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- patient_birth_date_mdy -->
            <!-- <br /> -->
            <input type="hidden" name="patient_birth_date_mdy" value="{{ date('m/d/Y', strtotime($workorder->W_DOB ?? '')) }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- patient_social_security -->
            <!-- <br /> -->

            @php
                $patientSocialSecurity = ($workorder->Requestor_R_Company ?? '') === 'MAGNA SERVICING LLC' ? $workorder->W_SS ?? '' : substr($workorder->W_SS ?? '', -4);
            @endphp

            <input type="hidden" name="patient_social_security" value="{{ $patientSocialSecurity }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- patient_social_security_full -->
            <!-- <br /> -->
            <input type="hidden" name="patient_social_security_full" value="{{ $workorder->W_SS }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- patient_email -->
            <!-- <br /> -->
            <input type="hidden" name="patient_email" value="{{ $workorder->Examrequest_E_ApplicantEmail }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- patient_phone -->
            <!-- <br /> -->
            <input type="hidden" name="patient_phone" value="{{ $workorder->Examrequest_E_HomePhone }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- patient_address -->
            <!-- <br /> -->
            <input type="hidden" name="patient_address" value="{{ $workorder->Examrequest_E_Address }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- patient_city -->
            <!-- <br /> -->
            <input type="hidden" name="patient_city" value="{{ $workorder->Examrequest_E_City }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- patient_state -->
            <!-- <br /> -->
            <input type="hidden" name="patient_state" value="{{ $workorder->Examrequest_E_State }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- patient_zip_code -->
            <!-- <br /> -->
            <input type="hidden" name="patient_zip_code" value="{{ $workorder->Examrequest_E_Zip }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- patient_city_state_zip -->
            <!-- <br /> -->
            <input type="hidden" name="patient_city_state_zip" value="{{ $workorder->Examrequest_E_City }} {{ $workorder->Examrequest_E_State }} {{ $workorder->Examrequest_E_Zip }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- patient_full_address -->
            <!-- <br /> -->
            <input type="hidden" name="patient_full_address" value="{{ $workorder->Examrequest_E_Address }} {{ $workorder->Examrequest_E_City }} {{ $workorder->Examrequest_E_State }} {{ $workorder->Examrequest_E_Zip }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- W_ReceiveDate -->
            <!-- <br /> -->
            <input type="hidden" name="W_ReceiveDate" value="{{ $workorder->W_ReceiveDate->format('m/d/Y') }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- W_YearsOfRecord -->
            <!-- <br /> -->
            <input type="hidden" name="W_YearsOfRecord" value="{{ $workorder->W_YearsOfRecord }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- dates_of_service_from -->
            <!-- <br /> -->
            <input type="hidden" name="dates_of_service_from" value="{!! Helper::recordYearsFrom($workorder->W_YearsOfRecord, $workorder->W_ReceiveDate) !!}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- dates_of_service_from_ymd -->
            <!-- <br /> -->
            <input type="hidden" name="dates_of_service_from_ymd" value="{!! Helper::recordYearsFrom($workorder->W_YearsOfRecord, $workorder->W_ReceiveDate, null, 'Y-m-d') !!}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- dates_of_service_to -->
            <!-- <br /> -->
            <input type="hidden" name="dates_of_service_to" value="{!! Helper::recordYearsTo($workorder->W_YearsOfRecord, $workorder->W_ReceiveDate) !!}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- dates_of_service_to_ymd -->
            <!-- <br /> -->
            <input type="hidden" name="dates_of_service_to_ymd" value="{!! Helper::recordYearsTo($workorder->W_YearsOfRecord, $workorder->W_ReceiveDate, null, 'Y-m-d') !!}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- dates_of_service_combined -->
            <!-- <br /> -->
            <input type="hidden" name="dates_of_service_combined" value="{!! Helper::recordYearsFromTo($workorder->W_YearsOfRecord, $workorder->W_ReceiveDate) !!}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- dates_of_service_combined_ymd -->
            <!-- <br /> -->
            <input type="hidden" name="dates_of_service_combined_ymd" value="{!! Helper::recordYearsFromTo($workorder->W_YearsOfRecord, $workorder->W_ReceiveDate, null, null, 'Y-m-d') !!}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- dates_of_service_combined_present -->
            <!-- <br /> -->
            <input type="hidden" name="dates_of_service_combined_present" value="{!! Helper::recordYearsFrom($workorder->W_YearsOfRecord, $workorder->W_ReceiveDate) !!} - PRESENT" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- dates_of_service_combined_present_ymd -->
            <!-- <br /> -->
            <input type="hidden" name="dates_of_service_combined_present_ymd" value="{!! Helper::recordYearsFrom($workorder->W_YearsOfRecord, $workorder->W_ReceiveDate, null, 'Y-m-d') !!} - PRESENT" class="form-control form-control-sm">
            <!-- <br /> -->

            @php
                $expirationYears = ($workorder->Requestor_R_Company ?? '') == 'MAGNA SERVICING LLC' ? 5 : 1;
            @endphp

            <!-- expiration_date -->
            <!-- <br /> -->
            <input type="hidden" name="expiration_date" value="{{ now()->addYear($expirationYears)->format('m/d/Y') }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- expiration_date_ymd -->
            <!-- <br /> -->
            <input type="hidden" name="expiration_date_ymd" value="{{ now()->addYear($expirationYears)->toDateString() }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- facility_dr -->
            <!-- <br /> -->
            <input type="hidden" name="facility_dr" value="{{ $hospital->H_Hospital }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- facility_name -->
            <!-- <br /> -->
            <input type="hidden" name="facility_name" value="{{ $hospital->H_Hospital2 }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- facility_address -->
            <!-- <br /> -->
            <input type="hidden" name="facility_address" value="{{ $hospital->H_Address }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- facility_city -->
            <!-- <br /> -->
            <input type="hidden" name="facility_city" value="{{ $hospital->H_City }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- facility_state -->
            <!-- <br /> -->
            <input type="hidden" name="facility_state" value="{{ $hospital->H_State }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- facility_zip_code -->
            <!-- <br /> -->
            <input type="hidden" name="facility_zip_code" value="{{ $hospital->H_Zip }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- facility_city_state_zip -->
            <!-- <br /> -->
            <input type="hidden" name="facility_city_state_zip" value="{{ $hospital->H_City }} {{ $hospital->H_State }} {{ $hospital->H_Zip }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- facility_full_address -->
            <!-- <br /> -->
            <input type="hidden" name="facility_full_address" value="{{ $hospital->H_Address }} {{ $hospital->H_City }} {{ $hospital->H_State }} {{ $hospital->H_Zip }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <!-- facility_phone -->
            <!-- <br /> -->
            <input type="hidden" name="facility_phone" value="{{ $hospital->H_Phone }}" class="form-control form-control-sm">
            <!-- <br /> -->

            <button type="submit" class="btn btn-sm btn-primary">In-house Prefill</button>
        </form>

    </div>

</x-user-layout>
