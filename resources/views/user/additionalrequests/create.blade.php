<x-user-layout title="">

    <script>
        var requesttypes = new Array();

        requesttypes['followup'] =
            "As of today, {{ date('m/d/Y') }}, we have not received confirmation that the request has been received and processed by your office. We kindly request your assistance in confirming whether the request has been received and if the patient, {{ $workorder->W_FirstName }} {{ $workorder->W_MiddleInit }} {{ $workorder->W_LastName }}, has been seen by your office.\r\n\r\nAdditionally, we would appreciate it if you could provide an estimated timeline for processing the request and the contact information of the individual(s) responsible for handling medical record requests, so we may follow \r\n\r\nPlease acknowledge receipt of this notice returning this form via email to records@expressimagingservices.com or fax to {!! Helper::coverPageFax($usersession) !!}.";
        requesttypes['cancel'] =
            "I am writing to confirm the cancellation of the request. We apologize for any inconvenience this may have caused.\r\n\r\nReason for cancellation: The insurance company has closed the case, and therefore, the records are no longer needed.\r\n\r\nPlease acknowledge receipt of this cancellation notice and confirm that the request has been canceled by signing and returning this form via email to {{ $usersession['contractor']['C_Email'] }} or fax to {!! Helper::coverPageFax($usersession) !!}.";
        requesttypes['missingrecord'] =
            "We recently received records from your office, and we appreciate your prompt response. However, upon review, it has come to our attention that crucial information, specifically regarding [specify missing information, e.g., X], was not included in the records provided on [X].\r\n\r\nAs the insurance company requires complete documentation to proceed with the underwriting process, we kindly request that you resend the missing records immediately. Your cooperation in this matter is greatly appreciated";

        function setTextArea(dropDown) {
            var curOption = dropDown.options[dropDown.selectedIndex];
            document.getElementById('message').value = requesttypes[curOption.value];
        }
    </script>

    <div class="row">
        <div class="col-auto">
            <h1>Additional Requests File Submission: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }}
                {{ $workorder->W_LastName }}</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}"
               class="btn btn-sm btn-secondary">View Workorder</a>
            <a href="{{ route('user.workorderfiles.show', $workorder->W_WorkOrder) }}"
               class="btn btn-sm btn-secondary">View Workorder Files</a>
        </div>
    </div>

    <br />
    <br />

    <div class="row">

        <h4>Additional Requests File Submission</h4>

        <div class="col-6">

            <form method="post"
                  action="{{ route('user.additionalrequests.store') }}">
                @csrf

                <input type="hidden"
                       name="workorder_id"
                       value="{{ $workorder->W_WorkOrder }}">

                @php
                    $options = [
                        'followup' => 'Follow Up',
                        'cancel' => 'Cancel',
                        'missingrecord' => 'Missing Record',
                    ];
                @endphp
                <x-form.select name="requesttype"
                               label="Request Type"
                               id="requesttype"
                               :options="$options"
                               empty="-"
                               :default="old('requesttype')"
                               onchange="setTextArea(this)"
                               required />

                <br />

                <x-form.select name="lor"
                               label="LOR Type"
                               id="lor"
                               :options="$loroptions"
                               empty="-"
                               :default="old('lor')" />

                <br />

                <x-form.textarea name="message"
                                 label="Message"
                                 id="message"
                                 :rows="8"
                                 minlength="5"
                                 maxlength="1000"
                                 required />

                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>

    </div>

</x-user-layout>
