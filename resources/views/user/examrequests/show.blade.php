<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Exam Request</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.examrequests.index') }}"
               class="btn btn-sm btn-secondary">View Exam Requests</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>E_WorkOrder</td>
            <td>{{ $examrequest->E_WorkOrder }}</td>
        </tr>
        <tr>
            <td>E_CompleteDate</td>
            <td>{{ $examrequest->E_CompleteDate }}</td>
        </tr>
        <tr>
            <td>E_FaceAmount</td>
            <td>{{ $examrequest->E_FaceAmount }}</td>
        </tr>
        <tr>
            <td>E_Address</td>
            <td>{{ $examrequest->E_Address }}</td>
        </tr>
        <tr>
            <td>E_City</td>
            <td>{{ $examrequest->E_City }}</td>
        </tr>
        <tr>
            <td>E_State</td>
            <td>{{ $examrequest->E_State }}</td>
        </tr>
        <tr>
            <td>E_Zip</td>
            <td>{{ $examrequest->E_Zip }}</td>
        </tr>
        <tr>
            <td>E_HomePhone</td>
            <td>{{ $examrequest->E_HomePhone }}</td>
        </tr>
        <tr>
            <td>E_CellPhone</td>
            <td>{{ $examrequest->E_CellPhone }}</td>
        </tr>
        <tr>
            <td>E_WorkPhone</td>
            <td>{{ $examrequest->E_WorkPhone }}</td>
        </tr>
        <tr>
            <td>E_WorkPhoneExt</td>
            <td>{{ $examrequest->E_WorkPhoneExt }}</td>
        </tr>
        <tr>
            <td>E_Instruction</td>
            <td>{{ $examrequest->E_Instruction }}</td>
        </tr>
        <tr>
            <td>E_Blood</td>
            <td>{{ $examrequest->E_Blood }}</td>
        </tr>
        <tr>
            <td>E_UA</td>
            <td>{{ $examrequest->E_UA }}</td>
        </tr>
        <tr>
            <td>E_Paramed</td>
            <td>{{ $examrequest->E_Paramed }}</td>
        </tr>
        <tr>
            <td>E_EKG</td>
            <td>{{ $examrequest->E_EKG }}</td>
        </tr>
        <tr>
            <td>E_MDExam</td>
            <td>{{ $examrequest->E_MDExam }}</td>
        </tr>
        <tr>
            <td>E_TreadmillEKG</td>
            <td>{{ $examrequest->E_TreadmillEKG }}</td>
        </tr>
        <tr>
            <td>E_ChoiceDate1</td>
            <td>{{ $examrequest->E_ChoiceDate1 }}</td>
        </tr>
        <tr>
            <td>E_ChoiceDate2</td>
            <td>{{ $examrequest->E_ChoiceDate2 }}</td>
        </tr>
        <tr>
            <td>E_Note</td>
            <td>{{ $examrequest->E_Note }}</td>
        </tr>
        <tr>
            <td>E_InvoicelNo</td>
            <td>{{ $examrequest->E_InvoicelNo }}</td>
        </tr>
        <tr>
            <td>E_ServiceFee</td>
            <td>{{ $examrequest->E_ServiceFee }}</td>
        </tr>
        <tr>
            <td>E_Examiner</td>
            <td>{{ $examrequest->E_Examiner }}</td>
        </tr>
        <tr>
            <td>E_ExamFee</td>
            <td>{{ $examrequest->E_ExamFee }}</td>
        </tr>
        <tr>
            <td>E_ImageFile</td>
            <td>{{ $examrequest->E_ImageFile }}</td>
        </tr>
        <tr>
            <td>E_ImagePages</td>
            <td>{{ $examrequest->E_ImagePages }}</td>
        </tr>
        <tr>
            <td>E_Complete</td>
            <td>{{ $examrequest->E_Complete }}</td>
        </tr>
        <tr>
            <td>E_IRWorkOrder</td>
            <td>{{ $examrequest->E_IRWorkOrder }}</td>
        </tr>
        <tr>
            <td>E_ApplicantEmail</td>
            <td>{{ $examrequest->E_ApplicantEmail }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('user.examrequests.edit', $examrequest->E_WorkOrder) }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />
    <br />
    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            examrequest
            @php dump(@$examrequest) @endphp
        </div>
    @endif

</x-user-layout>
