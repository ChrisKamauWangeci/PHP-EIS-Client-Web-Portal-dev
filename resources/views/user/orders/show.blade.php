<x-user-layout title="Addon Order">

    <div class="row">
        <div class="col-auto">
            <h1>Order</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.orders.index') }}" class="btn btn-sm btn-secondary">View Orders</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>id</td>
            <td>{{ $order->id }} </td>
        </tr>
        <tr>
            <td>workorder_id</td>
            <td>{{ $order->workorder_id }} </td>
        </tr>
        <tr>
            <td>company_id</td>
            <td>{{ $order->company_id }} </td>
        </tr>
        <tr>
            <td>requestorrole_id</td>
            <td>{{ $order->requestorrole_id }} </td>
        </tr>
        <tr>
            <td>company</td>
            <td>{{ $order->company }} </td>
        </tr>
        <tr>
            <td>order_type</td>
            <td>{{ $order->order_type }} </td>
        </tr>
        <tr>
            <td>priority</td>
            <td>{{ $order->priority }} </td>
        </tr>
        <tr>
            <td>agency_name_code</td>
            <td>{{ $order->agency_name_code }} </td>
        </tr>
        <tr>
            <td>requestor_name</td>
            <td>{{ $order->requestor_name }} </td>
        </tr>
        <tr>
            <td>requestor_phone</td>
            <td>{{ $order->requestor_phone }} </td>
        </tr>
        <tr>
            <td>requestor_email</td>
            <td>{{ $order->requestor_email }} </td>
        </tr>
        <tr>
            <td>insurance_company_1</td>
            <td>{{ $order->insurance_company_1 }} </td>
        </tr>
        <tr>
            <td>insurance_company_2</td>
            <td>{{ $order->insurance_company_2 }} </td>
        </tr>
        <tr>
            <td>insurance_company_3</td>
            <td>{{ $order->insurance_company_3 }} </td>
        </tr>
        <tr>
            <td>agent_name</td>
            <td>{{ $order->agent_name }} </td>
        </tr>
        <tr>
            <td>agent_id</td>
            <td>{{ $order->agent_id }} </td>
        </tr>
        <tr>
            <td>agent_phone</td>
            <td>{{ $order->agent_phone }} </td>
        </tr>
        <tr>
            <td>agent_email</td>
            <td>{{ $order->agent_email }} </td>
        </tr>
        <tr>
            <td>underwriter_name</td>
            <td>{{ $order->underwriter_name }} </td>
        </tr>
        <tr>
            <td>underwriter_phone</td>
            <td>{{ $order->underwriter_phone }} </td>
        </tr>
        <tr>
            <td>underwriter_email</td>
            <td>{{ $order->underwriter_email }} </td>
        </tr>
        <tr>
            <td>policy_number</td>
            <td>{{ $order->policy_number }} </td>
        </tr>
        <tr>
            <td>case_number</td>
            <td>{{ $order->case_number }} </td>
        </tr>
        <tr>
            <td>kaiser_number</td>
            <td>{{ $order->kaiser_number }} </td>
        </tr>
        <tr>
            <td>face_amount</td>
            <td>{{ $order->face_amount }} </td>
        </tr>
        <tr>
            <td>applicant_first_name</td>
            <td>{{ $order->applicant_first_name }} </td>
        </tr>
        <tr>
            <td>applicant_middle_initial</td>
            <td>{{ $order->applicant_middle_initial }} </td>
        </tr>
        <tr>
            <td>applicant_last_name</td>
            <td>{{ $order->applicant_last_name }} </td>
        </tr>
        <tr>
            <td>applicant_gender</td>
            <td>{{ $order->applicant_gender }} </td>
        </tr>
        <tr>
            <td>applicant_date_of_birth</td>
            <td>{{ $order->applicant_date_of_birth }} </td>
        </tr>
        <tr>
            <td>applicant_social_security</td>
            <td>{{ $order->applicant_social_security }} </td>
        </tr>
        <tr>
            <td>applicant_email</td>
            <td>{{ $order->applicant_email }} </td>
        </tr>
        <tr>
            <td>applicant_cell_phone</td>
            <td>{{ $order->applicant_cell_phone }} </td>
        </tr>
        <tr>
            <td>applicant_home_phone</td>
            <td>{{ $order->applicant_home_phone }} </td>
        </tr>
        <tr>
            <td>applicant_work_phone</td>
            <td>{{ $order->applicant_work_phone }} </td>
        </tr>
        <tr>
            <td>applicant_street</td>
            <td>{{ $order->applicant_street }} </td>
        </tr>
        <tr>
            <td>applicant_city</td>
            <td>{{ $order->applicant_city }} </td>
        </tr>
        <tr>
            <td>applicant_state</td>
            <td>{{ $order->applicant_state }} </td>
        </tr>
        <tr>
            <td>applicant_zip_code</td>
            <td>{{ $order->applicant_zip_code }} </td>
        </tr>
        <tr>
            <td>authorization_file</td>
            <td>{{ $order->authorization_file }} </td>
        </tr>
        <tr>
            <td>authorization_file_size</td>
            <td>{{ $order->authorization_file_size }} </td>
        </tr>
        <tr>
            <td>facility_name</td>
            <td>{{ $order->facility_name }} </td>
        </tr>
        <tr>
            <td>facility_phone</td>
            <td>{{ $order->facility_phone }} </td>
        </tr>
        <tr>
            <td>facility_fax</td>
            <td>{{ $order->facility_fax }} </td>
        </tr>
        <tr>
            <td>facility_street</td>
            <td>{{ $order->facility_street }} </td>
        </tr>
        <tr>
            <td>facility_city</td>
            <td>{{ $order->facility_city }} </td>
        </tr>
        <tr>
            <td>facility_state</td>
            <td>{{ $order->facility_state }} </td>
        </tr>
        <tr>
            <td>facility_zip_code</td>
            <td>{{ $order->facility_zip_code }} </td>
        </tr>
        <tr>
            <td>facility_years_of_records</td>
            <td>{{ $order->facility_years_of_records }} </td>
        </tr>
        <tr>
            <td>facility_notes</td>
            <td>{{ $order->facility_notes }} </td>
        </tr>
        <tr>
            <td>marketer_last_name</td>
            <td>{{ $order->marketer_last_name }} </td>
        </tr>
        <tr>
            <td>marketer_code_number</td>
            <td>{{ $order->marketer_code_number }} </td>
        </tr>
        <tr>
            <td>general_office_code</td>
            <td>{{ $order->general_office_code }} </td>
        </tr>
        <tr>
            <td>folder_name</td>
            <td>{{ $order->folder_name }} </td>
        </tr>
        <tr>
            <td>status</td>
            <td>{{ $order->status }} </td>
        </tr>
        <tr>
            <td>created_at</td>
            <td>{{ $order->created_at }} </td>
        </tr>
        <tr>
            <td>updated_at</td>
            <td>{{ $order->updated_at }} </td>
        </tr>
    </table>

    <br />
    <br />

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            order
            @php dump(@$order) @endphp
        </div>
    @endif

</x-user-layout>
