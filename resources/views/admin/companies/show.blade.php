<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Company</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.companies.index') }}" class="btn btn-sm btn-secondary">View Companies</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $company->id }}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{ $company->C_Name }}</td>
        </tr>
        <tr>
            <td>ID</td>
            <td>{{ $company->C_ID }}</td>
        </tr>
        <tr>
            <td>Address</td>
            <td>{{ $company->C_Address }}</td>
        </tr>
        <tr>
            <td>City</td>
            <td>{{ $company->C_City }}</td>
        </tr>
        <tr>
            <td>State</td>
            <td>{{ $company->C_State }}</td>
        </tr>
        <tr>
            <td>Zip</td>
            <td>{{ $company->C_Zip }}</td>
        </tr>
        <tr>
            <td>Contact</td>
            <td>{{ $company->C_Contact }}</td>
        </tr>
        <tr>
            <td>ContactMail</td>
            <td>{{ $company->C_ContactMail }}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{ $company->C_Phone }}</td>
        </tr>
        <tr>
            <td>PhoneExt</td>
            <td>{{ $company->C_PhoneExt }}</td>
        </tr>
        <tr>
            <td>Fax</td>
            <td>{{ $company->C_Fax }}</td>
        </tr>
        <tr>
            <td>Note</td>
            <td>
                {!! nl2br(e($company->C_Note)) !!}
            </td>
        </tr>
        <tr>
            <td>Fee</td>
            <td>{{ $company->C_Fee }}</td>
        </tr>
        <tr>
            <td>Web ID</td>
            <td>{{ $company->C_WebID }}</td>
        </tr>
        <tr>
            <td>Web Password</td>
            <td>{{ $company->C_WebPassword }}</td>
        </tr>
        <tr>
            <td>Web Address</td>
            <td>{{ $company->C_WebAddress }}</td>
        </tr>
        <tr>
            <td>Update User</td>
            <td>{{ $company->C_UpdUser }}</td>
        </tr>
        <tr>
            <td>Update Date</td>
            <td>{{ $company->C_UpdDate }}</td>
        </tr>
        <tr>
            <td>Email Status</td>
            <td>{{ $company->C_EmailStatus }}</td>
        </tr>
        <tr>
            <td>Email Recap</td>
            <td>{{ $company->C_EmailRecap }}</td>
        </tr>
        <tr>
            <td>Email Recap To</td>
            <td>{{ $company->C_EmailRecapTo }}</td>
        </tr>
        <tr>
            <td>Contact Note</td>
            <td>
                {!! nl2br(e($company->C_ContactNote)) !!}
            </td>
        </tr>
        <tr>
            <td>Contact Date</td>
            <td>{{ $company->C_ContactDate }}</td>
        </tr>
        <tr>
            <td>Contact Agenda</td>
            <td>{{ $company->C_ContactAgenda }}</td>
        </tr>
        <tr>
            <td>Instruction</td>
            <td>
                {!! nl2br(e($company->C_Instruction)) !!}
            </td>
        </tr>
        <tr>
            <td>Status Email Audit</td>
            <td>{{ $company->C_StatusEmailAudit }}</td>
        </tr>
        <tr>
            <td>Hold</td>
            <td>{{ $company->C_Hold }}</td>
        </tr>
        <tr>
            <td>Web Chat</td>
            <td>{{ $company->C_WebChat }}</td>
        </tr>
        <tr>
            <td>Full Status</td>
            <td>{{ $company->C_FullStatus }}</td>
        </tr>
        <tr>
            <td>MFA</td>
            <td>{{ $company->C_MFA }}</td>
        </tr>
        <tr>
            <td>Password Life</td>
            <td>{{ $company->C_PWLife }}</td>
        </tr>
        <tr>
            <td>Password Length</td>
            <td>{{ $company->C_PWLength }}</td>
        </tr>
        <tr>
            <td>APS Only</td>
            <td>{{ $company->C_APSOnly }}</td>
        </tr>
        <tr>
            <td>Email Action Require To</td>
            <td>{{ $company->C_EmailActionRequireTo }}</td>
        </tr>
        <tr>
            <td>Email Fee Approval To</td>
            <td>{{ $company->C_EmailFeeApprovalTo }}</td>
        </tr>
        <tr>
            <td>LOR</td>
            <td>{{ $company->C_LOR }}</td>
        </tr>
        <tr>
            <td>LOR Expiration Date</td>
            <td>{{ $company->C_LORExpirationDate }}</td>
        </tr>
        <tr>
            <td>EHR</td>
            <td>{{ $company->C_EHR }}</td>
        </tr>
        <tr>
            <td>eHealthLink</td>
            <td>{{ $company->C_eHealthLink }}</td>
        </tr>
        <tr>
            <td>Summary</td>
            <td>{{ $company->summary }}</td>
        </tr>
        <tr>
            <td>Smart Access</td>
            <td>{{ $company->smartaccess_active }}</td>
        </tr>
        <tr>
            <td>CareMap 360</td>
            <td>{{ $company->caremap360_active }}</td>
        </tr>
        <tr>
            <td>Inquiry Exp Days</td>
            <td>{{ $company->C_InquiryExpDays }}</td>
        </tr>
        <tr>
            <td>Spec Auth Exp Days</td>
            <td>{{ $company->C_SpecAuthExpDays }}</td>
        </tr>
        <tr>
            <td>Summary Page Limit</td>
            <td>{{ $company->summary_page_limit }}</td>
        </tr>
        <tr>
            <td>Inquiry Reminder Days</td>
            <td>{{ $company->inquiry_reminder_days }}</td>
        </tr>
        <tr>
            <td>Follow Up Days</td>
            <td>{{ $company->followup_days }}</td>
        </tr>
        <tr>
            <td>Years of Records</td>
            <td>{{ $company->years_of_records }}</td>
        </tr>
        <tr>
            <td>Created</td>
            <td>{{ $company->created }}</td>
        </tr>
        <tr>
            <td>Created By</td>
            <td>{{ $company->created_by }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('admin.companies.edit', $company->id) }}" class="btn btn-sm btn-secondary">Edit Company</a>

    <br />
    <br />

    <br />
    <br />

    @if ($adminsession['debug']) :
        <div class="bg-light small p-2 d-print-none">
            company
            @dump(@$company)
        </div>
    @endif

    <br />
    <br />

</x-admin-layout>