<x-admin-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Workorder</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('admin.workorders.index') }}"
               class="btn btn-sm btn-secondary">View Workorders</a>
        </div>
    </div>

    <br />

    <table class="table table-bordered table-sm w-auto">
        <tr>
            <td>W_WorkOrder</td>
            <td>{{ $workorder->W_WorkOrder }}</td>
        </tr>
        <tr>
            <td>company_id</td>
            <td>{{ $workorder->company_id }}</td>
        </tr>
        <tr>
            <td>W_PolicyNo</td>
            <td>{{ $workorder->W_PolicyNo }}</td>
        </tr>
        <tr>
            <td>W_Requestor</td>
            <td>{{ $workorder->W_Requestor }}</td>
        </tr>
        <tr>
            <td>W_Agent</td>
            <td>{{ $workorder->W_Agent }}</td>
        </tr>
        <tr>
            <td>W_BillCompany</td>
            <td>{{ $workorder->W_BillCompany }}</td>
        </tr>
        <tr>
            <td>W_ReceiveDate</td>
            <td>{{ $workorder->W_ReceiveDate }}</td>
        </tr>
        <tr>
            <td>W_CompletedDate</td>
            <td>{{ $workorder->W_CompletedDate }}</td>
        </tr>
        <tr>
            <td>W_Contractor</td>
            <td>{{ $workorder->W_Contractor }}</td>
        </tr>
        <tr>
            <td>W_ContractorCd</td>
            <td>{{ $workorder->W_ContractorCd }}</td>
        </tr>
        <tr>
            <td>W_ContractorFee</td>
            <td>{{ $workorder->W_ContractorFee }}</td>
        </tr>
        <tr>
            <td>W_PayrollNo</td>
            <td>{{ $workorder->W_PayrollNo }}</td>
        </tr>
        <tr>
            <td>W_Note</td>
            <td>{{ $workorder->W_Note }}</td>
        </tr>
        <tr>
            <td>W_Note2</td>
            <td>{{ $workorder->W_Note2 }}</td>
        </tr>
        <tr>
            <td>W_Note3</td>
            <td>{{ $workorder->W_Note3 }}</td>
        </tr>
        <tr>
            <td>W_SS</td>
            <td>{{ $workorder->W_SS }}</td>
        </tr>
        <tr>
            <td>W_LastName</td>
            <td>{{ $workorder->W_LastName }}</td>
        </tr>
        <tr>
            <td>W_MiddleInit</td>
            <td>{{ $workorder->W_MiddleInit }}</td>
        </tr>
        <tr>
            <td>W_FirstName</td>
            <td>{{ $workorder->W_FirstName }}</td>
        </tr>
        <tr>
            <td>W_DOB</td>
            <td>{{ $workorder->W_DOB }}</td>
        </tr>
        <tr>
            <td>W_YearsOfRecord</td>
            <td>{{ $workorder->W_YearsOfRecord }}</td>
        </tr>
        <tr>
            <td>W_RecordNo</td>
            <td>{{ $workorder->W_RecordNo }}</td>
        </tr>
        <tr>
            <td>W_Hospital</td>
            <td>{{ $workorder->W_Hospital }}</td>
        </tr>
        <tr>
            <td>W_InsPolicy</td>
            <td>{{ $workorder->W_InsPolicy }}</td>
        </tr>
        <tr>
            <td>W_InsCompany</td>
            <td>{{ $workorder->W_InsCompany }}</td>
        </tr>
        <tr>
            <td>W_Status</td>
            <td>{{ $workorder->W_Status }}</td>
        </tr>
        <tr>
            <td>W_ContractFee</td>
            <td>{{ $workorder->W_ContractFee }}</td>
        </tr>
        <tr>
            <td>W_DrCd</td>
            <td>{{ $workorder->W_DrCd }}</td>
        </tr>
        <tr>
            <td>W_DrFee</td>
            <td>{{ $workorder->W_DrFee }}</td>
        </tr>
        <tr>
            <td>W_DrFee1</td>
            <td>{{ $workorder->W_DrFee1 }}</td>
        </tr>
        <tr>
            <td>W_DrFee2</td>
            <td>{{ $workorder->W_DrFee2 }}</td>
        </tr>
        <tr>
            <td>W_DrCheckNo</td>
            <td>{{ $workorder->W_DrCheckNo }}</td>
        </tr>
        <tr>
            <td>W_DrCheckDate</td>
            <td>{{ $workorder->W_DrCheckDate }}</td>
        </tr>
        <tr>
            <td>W_DrInvoiceNo</td>
            <td>{{ $workorder->W_DrInvoiceNo }}</td>
        </tr>
        <tr>
            <td>W_ImageFile</td>
            <td>{{ $workorder->W_ImageFile }}</td>
        </tr>
        <tr>
            <td>W_ImagePages</td>
            <td>{{ $workorder->W_ImagePages }}</td>
        </tr>
        <tr>
            <td>W_NoFiles</td>
            <td>{{ $workorder->W_NoFiles }}</td>
        </tr>
        <tr>
            <td>W_AuthorizedFile</td>
            <td>{{ $workorder->W_AuthorizedFile }}</td>
        </tr>
        <tr>
            <td>W_FollowUpDt</td>
            <td>{{ $workorder->W_FollowUpDt }}</td>
        </tr>
        <tr>
            <td>W_FollowUpDone</td>
            <td>{{ $workorder->W_FollowUpDone }}</td>
        </tr>
        <tr>
            <td>W_FollowUpStatus</td>
            <td>{{ $workorder->W_FollowUpStatus }}</td>
        </tr>
        <tr>
            <td>W_UpdUser</td>
            <td>{{ $workorder->W_UpdUser }}</td>
        </tr>
        <tr>
            <td>W_UpdDate</td>
            <td>{{ $workorder->W_UpdDate }}</td>
        </tr>
        <tr>
            <td>W_DrCheckNo2</td>
            <td>{{ $workorder->W_DrCheckNo2 }}</td>
        </tr>
        <tr>
            <td>W_DrCheckDate2</td>
            <td>{{ $workorder->W_DrCheckDate2 }}</td>
        </tr>
        <tr>
            <td>W_DrInvoiceNo2</td>
            <td>{{ $workorder->W_DrInvoiceNo2 }}</td>
        </tr>
        <tr>
            <td>W_ShipFee</td>
            <td>{{ $workorder->W_ShipFee }}</td>
        </tr>
        <tr>
            <td>W_ShipFee1</td>
            <td>{{ $workorder->W_ShipFee1 }}</td>
        </tr>
        <tr>
            <td>W_ShipFee2</td>
            <td>{{ $workorder->W_ShipFee2 }}</td>
        </tr>
        <tr>
            <td>W_Tracking1</td>
            <td>{{ $workorder->W_Tracking1 }}</td>
        </tr>
        <tr>
            <td>W_Tracking2</td>
            <td>{{ $workorder->W_Tracking2 }}</td>
        </tr>
        <tr>
            <td>W_CompleteDays</td>
            <td>{{ $workorder->W_CompleteDays }}</td>
        </tr>
        <tr>
            <td>W_Export</td>
            <td>{{ $workorder->W_Export }}</td>
        </tr>
        <tr>
            <td>W_WebUploadID</td>
            <td>{{ $workorder->W_WebUploadID }}</td>
        </tr>
        <tr>
            <td>W_HospitalID</td>
            <td>{{ $workorder->W_HospitalID }}</td>
        </tr>
        <tr>
            <td>W_OrderType</td>
            <td>{{ $workorder->W_OrderType }}</td>
        </tr>
        <tr>
            <td>W_ExamStatus</td>
            <td>{{ $workorder->W_ExamStatus }}</td>
        </tr>
        <tr>
            <td>W_ExamCompleteDate</td>
            <td>{{ $workorder->W_ExamCompleteDate }}</td>
        </tr>
        <tr>
            <td>W_InvoiceIR</td>
            <td>{{ $workorder->W_InvoiceIR }}</td>
        </tr>
        <tr>
            <td>W_Urgent</td>
            <td>{{ $workorder->W_Urgent }}</td>
        </tr>
        <tr>
            <td>W_Owner</td>
            <td>{{ $workorder->W_Owner }}</td>
        </tr>
        <tr>
            <td>W_CompletionType</td>
            <td>{{ $workorder->W_CompletionType }}</td>
        </tr>
        <tr>
            <td>W_MultWO</td>
            <td>{{ $workorder->W_MultWO }}</td>
        </tr>
        <tr>
            <td>W_AuthSignature</td>
            <td>{{ $workorder->W_AuthSignature }}</td>
        </tr>
        <tr>
            <td>W_RequestorNote</td>
            <td>{{ $workorder->W_RequestorNote }}</td>
        </tr>
        <tr>
            <td>W_ImageValidation</td>
            <td>{{ $workorder->W_ImageValidation }}</td>
        </tr>
        <tr>
            <td>W_DateOfDeath</td>
            <td>{{ $workorder->W_DateOfDeath }}</td>
        </tr>
        <tr>
            <td>W_VehicleInfo</td>
            <td>{{ $workorder->W_VehicleInfo }}</td>
        </tr>
        <tr>
            <td>W_AccidentLocation</td>
            <td>{{ $workorder->W_AccidentLocation }}</td>
        </tr>
        <tr>
            <td>W_ClaimAutopsy</td>
            <td>{{ $workorder->W_ClaimAutopsy }}</td>
        </tr>
        <tr>
            <td>W_ClaimPolice</td>
            <td>{{ $workorder->W_ClaimPolice }}</td>
        </tr>
        <tr>
            <td>W_DrFollowup</td>
            <td>{{ $workorder->W_DrFollowup }}</td>
        </tr>
        <tr>
            <td>W_PLIWCLAuthFrm</td>
            <td>{{ $workorder->W_PLIWCLAuthFrm }}</td>
        </tr>
        <tr>
            <td>W_RequestPrinted</td>
            <td>{{ $workorder->W_RequestPrinted }}</td>
        </tr>
        <tr>
            <td>W_RequestPrintedBy</td>
            <td>{{ $workorder->W_RequestPrintedBy }}</td>
        </tr>
        <tr>
            <td>W_RequestVerify</td>
            <td>{{ $workorder->W_RequestVerify }}</td>
        </tr>
        <tr>
            <td>W_RequestVerifyBy</td>
            <td>{{ $workorder->W_RequestVerifyBy }}</td>
        </tr>
        <tr>
            <td>W_PersonCode</td>
            <td>{{ $workorder->W_PersonCode }}</td>
        </tr>
        <tr>
            <td>W_APSSummary</td>
            <td>{{ $workorder->W_APSSummary }}</td>
        </tr>
        <tr>
            <td>W_AccessPointWO</td>
            <td>{{ $workorder->W_AccessPointWO }}</td>
        </tr>
        <tr>
            <td>W_ClaimCorner</td>
            <td>{{ $workorder->W_ClaimCorner }}</td>
        </tr>
        <tr>
            <td>W_Gender</td>
            <td>{{ $workorder->W_Gender }}</td>
        </tr>
        <tr>
            <td>W_TransNo</td>
            <td>{{ $workorder->W_TransNo }}</td>
        </tr>
        <tr>
            <td>W_ShippingMethod</td>
            <td>{{ $workorder->W_ShippingMethod }}</td>
        </tr>
        <tr>
            <td>W_AgencyID</td>
            <td>{{ $workorder->W_AgencyID }}</td>
        </tr>
        <tr>
            <td>post_issue_audit</td>
            <td>{{ $workorder->post_issue_audit }}</td>
        </tr>
    </table>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            workorder
            @php dump(@$workorder) @endphp
        </div>
    @endif

    <br />
    <br />

</x-admin-layout>
