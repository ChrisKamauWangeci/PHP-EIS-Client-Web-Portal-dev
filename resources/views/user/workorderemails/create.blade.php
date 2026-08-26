<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Workorder: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }} {{ $workorder->W_LastName }}
            </h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}"
               class="btn btn-sm btn-secondary">View Workorder</a>
        </div>
    </div>

    <br />

    <h1>Send {{ $type }} Email</h1>

    <br />

    <div class="row">
        <div class="col-12 col-sm-6">

            <form method="post"
                  action="{{ route('user.workorderemails.store') }}">
                @csrf

                <input type="hidden"
                       name="workorder_id"
                       value="{{ $workorder->W_WorkOrder }}">
                <input type="hidden"
                       name="type"
                       value="{{ $type }}">

                <x-form.input type="email"
                              name="sender"
                              id="sender"
                              label="Sender"
                              :value="old('sender', $sender)"
                              required />
                <br />

                <x-form.input type="text"
                              name="recipient"
                              id="recipient"
                              label="Recipient"
                              :value="old('recipient', $recipient)"
                              required />
                <br />

                <x-form.input type="subject"
                              name="subject"
                              id="subject"
                              label="Subject"
                              :value="old('subject', $subject)"
                              maxlength="80"
                              required />
                <br />

                <span class="py-1 text-black-50">{!! nl2br($bodyheader) !!}</span>
                <x-form.textarea name="body"
                                 id="body"
                                 :value="old('body', $body)"
                                 rows="6"
                                 maxlength="500" />
                <span class="py-1 text-black-50">{!! nl2br($bodyfooter) !!}</span>
                <input type="hidden"
                       name="bodyheader"
                       value="{!! $bodyheader !!}">
                <input type="hidden"
                       name="bodyfooter"
                       value="{!! $bodyfooter !!}">
                <br />
                <br />

                Change Assigned to <small><i> - Please note the last assigned to set as default</i></small>
                <x-form.select name="W_Owner"
                               :options="$contractors"
                               :default="old('W_Owner', $workorder->W_Owner)"
                               empty="-"
                               required />

                <br />

                Change Follow up Date
                <x-form.input name="W_FollowUpDt"
                              type="date"
                              :value="old('W_FollowUpDt', $workorder->W_FollowUpDt?->format('Y-m-d'))" />
                <br />

                <br />
                <x-form.button>Submit</x-form.button>

            </form>

        </div>

        <div class="col-12 col-sm-6">

            <strong class="h6 fw-bold">Status Note</strong>

            <div class="overflow-auto bg-white p-2 border expandables"
                 style="height: 300px;  word-break: break-all;"
                 id="statusnotetext">
                <strong>New Status Notes:</strong>
                <br />
                @foreach ($statustriggers as $statustrigger)
                    {{ $statustrigger->Created?->format('m-d-Y') }} : {{ $statustrigger->laststatus }}
                    <hr>
                @endforeach
                <strong>Old Status Notes:</strong>
                <br />
                {!! nl2br($workorder->W_Note ?? '') !!}
            </div>

            <br />
            <br />

            <strong class="h6 fw-bold">Follow-Up Status</strong>

            <div class="overflow-auto bg-white p-2 border expandables"
                 style="height: 300px; word-break: break-all;"
                 id="followupstatustext">
                {!! nl2br($workorder->W_FollowUpStatus ?? '') !!}
            </div>

        </div>

    </div>

    <br />
    <br />
    <br />

    <h2>Emails</h2>

    <br />
    <br />

</x-user-layout>
