<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Edit Workorder: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }} {{ $workorder->W_LastName }}</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}" class="btn btn-sm btn-secondary">View Workorder</a>
        </div>
    </div>

    <br />

    <div class="col-md-6">

        <form method="post" action="{{ route('user.workorders.update', $workorder->W_WorkOrder) }}">
            @csrf
            @method('PATCH')

            <input type="hidden" name="Company_C_WebID" value="{{ $requestor->Company_C_WebID }}">

            <x-form.input name="W_FirstName" label="First Name" :value="old('W_FirstName', $workorder->W_FirstName)" required maxlength="50" />
            <br />

            <x-form.input name="W_MiddleInit" label="Middle Initial" :value="old('W_MiddleInit', $workorder->W_MiddleInit)" maxlength="1" />
            <br />

            <x-form.input name="W_LastName" label="Last Name" :value="old('W_LastName', $workorder->W_LastName)" required maxlength="50" />
            <br />

            @if($workorder->W_Gender == 'M' || $workorder->W_Gender == 'F')
                <x-form.select name="W_Gender" label="Gender" :options="['M' => 'M', 'F' => 'F']" empty="-" :default="$workorder->W_Gender" required />
                <br />
            @endif

            @if ($usersession['contractor']['accesslevel'])
                <x-form.input name="W_DOB" label="Date of Birth" type="date" :value="old('W_DOB', $workorder->W_DOB?->format('Y-m-d'))" />
                <br />

                <x-form.input name="W_SS" label="Applicant Social Security" type="text" :value="old('W_SS', $workorder->W_SS)" maxlength="11" />
                <br />

                <x-form.select name="W_InsCompany" label="Insurance Company" :options="$insurancecompanies" empty="-" :default="$workorder->W_InsCompany" required />
                <br />

                <x-form.input name="W_Agent" label="Agent" :value="old('W_Agent', $workorder->W_Agent)" maxlength="50" />
                <br />

                <x-form.input name="W_PolicyNo" label="Case Number" :value="old('W_PolicyNo', $workorder->W_PolicyNo)" maxlength="50" />
                <br />

                <x-form.input name="W_InsPolicy" label="Policy Number" :value="old('W_InsPolicy', $workorder->W_InsPolicy)" maxlength="50" />
                <br />

                <x-form.input name="W_RecordNo" label="Medical Record Number" :value="old('W_RecordNo', $workorder->W_RecordNo)" maxlength="50" />
                <br />

                <x-form.input name="W_TransNo" label="Trans Number" type="text" :value="old('W_TransNo', $workorder->W_TransNo)" maxlength="9" />
                <br />

                <x-form.input name="W_NoFiles" label="No Files" :value="old('W_NoFiles', $workorder->W_NoFiles)" maxlength="10" />
                <br />

                <x-form.input name="W_ImageFile" label="Image File" :value="old('W_ImageFile', $workorder->W_ImageFile)" maxlength="50" />
                <br />

                <x-form.input name="W_ImagePages" label="Image Pages" :value="old('W_ImagePages', $workorder->W_ImagePages)" maxlength="10" />
                <br />
            @endif

            <x-form.select name="W_Contractor" label="Case Manager" :options="$contractors" empty="-" :default="$workorder->W_Contractor" required />
            <br />

            <x-form.input type="number" name="W_ContractorFee" label="Contractor Fee" :value="old('W_ContractorFee', $workorder->W_ContractorFee)" min="0" max="1000" step=".01" />
            <br />

            <x-form.input type="number" name="W_ShipFee1" label="Ship Fee 1" :value="old('W_ShipFee1', $workorder->W_ShipFee1)" min="0" max="1000" step=".01" />
            <br />

            <x-form.input name="W_Tracking1" label="Send Tracking 1" :value="old('W_Tracking1', $workorder->W_Tracking1)" maxlength="30" />
            <br />

            <x-form.input type="number" name="W_ShipFee2" label="Ship Fee 2" :value="old('W_ShipFee2', $workorder->W_ShipFee2)" min="0" max="1000" step=".01" />
            <br />

            <x-form.input name="W_Tracking2" label="Send Tracking 2" :value="old('W_Tracking2', $workorder->W_Tracking2)" maxlength="30" />
            <br />

            <x-form.select name="W_YearsOfRecord" label="Years of Records" id="W_YearsOfRecord" :options="Helper::recordYears()" empty="-" :default="$workorder->W_YearsOfRecord" />
            <br />

            <x-form.textarea name="W_ExamStatus" label="Header Instructions for PDF Cover Page" :value="old('W_ExamStatus', $workorder->W_ExamStatus)" :rows="2" />
            <br />

            Requestor Note
            <br />
            <textarea name="" class="form-control form-control-sm" readonly disabled rows="3">{{ $workorder->W_RequestorNote }}</textarea>
            <br />

            <x-form.textarea name="W_Note2" label="Special Instructions for PDF Cover Page" :value="old('W_Note2', $workorder->W_Note2)" :rows="8" />
            <br />

            <x-form.input name="W_FollowUpDt" label="Follow Up Date" type="date" :value="old('W_FollowUpDt', $workorder->W_FollowUpDt?->format('Y-m-d'))" />
            <br />

            @if ($usersession['contractor']['C_Location'] == 'US Onsite' && ($workorder->W_Status == 'Complete' || $workorder->W_Status == 'Cancel'))
                <x-form.input name="W_CompletedDate" label="Complete Date" type="date" :value="old('W_CompletedDate', $workorder->W_CompletedDate?->format('Y-m-d'))" :min="now()->subYears(10)->format('Y-m-d')" :max="now()->addDays(365)->format('Y-m-d')" />
                <br />
            @endif

            <x-form.checkbox name="W_Urgent" id="W_Urgent" label="Urgent" :checked="$workorder->W_Urgent" />
            <br />

            <x-form.errors />

            <x-form.button>Submit</x-form.button>

            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}" class="btn btn-sm btn-light">Cancel</a>

        </form>

    </div>

    <br />
    <br />

</x-user-layout>
