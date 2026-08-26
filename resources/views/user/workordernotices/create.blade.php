<x-user-layout title="">

    <script>
        function hidediv() {
            var checkbox = document.getElementById("sendemail");
            var div = document.getElementById("emailblock");

            if (checkbox.checked == true) {
                div.style.display = "block";
            } else {
                div.style.display = "none";
            }
        }
    </script>

    <div class="row">
        <div class="col-auto">
            <h1>Workorder {{ $days }} Day Notice: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }}
                {{ $workorder->W_LastName }}</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}"
               class="btn btn-sm btn-secondary">View Workorder</a>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-12 col-sm-6">

            <form method="post"
                  action="{{ route('user.workordernotices.store') }}">
                @csrf

                <input type="hidden"
                       name="workorder_id"
                       value="{{ $workorder->W_WorkOrder }}">
                <input type="hidden"
                       name="workordernotice_id"
                       value="{{ $workordernotice->id }}">
                <input type="hidden"
                       name="days"
                       value="{{ $days }}">

                <h5>Send Email</h5>

                <x-form.checkbox name="sendemail"
                                 label="Send Email ?"
                                 id="sendemail"
                                 checked
                                 onchange="hidediv();" />
                <br />

                <div id="emailblock">

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

                    <label for="body">Message</label>
                    <br />
                    <span class="py-1 text-black-50">{!! nl2br($bodyheader) !!}</span>
                    <x-form.textarea name="body"
                                     id="body"
                                     value="{!! old('body', $body) !!}"
                                     rows="8"
                                     maxlength="800" />
                    <span class="py-1 text-black-50">{!! nl2br($bodyfooter) !!}</span>
                    <input type="hidden"
                           name="bodyheader"
                           value="{!! $bodyheader !!}">
                    <input type="hidden"
                           name="bodyfooter"
                           value="{!! $bodyfooter !!}">
                    <br />
                    <br />

                </div>

                Change Assigned to <small><i> - Please note the last assigned to set as default</i></small>

                <x-form.select name="W_Owner"
                               :options="$contractors"
                               :default="old('W_Owner', $workordernotice->user_before ?? '')"
                               empty="-"
                               required />

                <br />

                Change Follow up Date
                <x-form.input type="date"
                              name="W_FollowUpDt"
                              :value="old('W_FollowUpDt', $workorder->W_FollowUpDt?->format('Y-m-d'))" />
                <br />

                @if (is_file('//ftpserver/documents/sign/' . $workorder->W_WorkOrder . '-prefill-gs.pdf'))
                    Special Authorization: <a
                       href="/user/files?file=//ftpserver/documents/sign/{{ $workorder->W_WorkOrder }}-prefill-gs.pdf&amp;download=0"
                       target="_blank">{{ $workorder->W_WorkOrder }}-prefill-gs.pdf</a>
                    <br />
                    <input type="hidden"
                           name="file"
                           value="//ftpserver/documents/sign/{{ $workorder->W_WorkOrder }}-prefill-gs.pdf">
                    <x-form.checkbox name="send_attachment"
                                     label="Send email with Special Authorization ?"
                                     checked />
                    <br />
                @else
                    <div class="fw-bold text-danger">File not found! Cannot attach file!</div>
                    <br />
                @endif

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

    <h2>Workorder Notices</h2>

    <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm table-hover w-auto small">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Assigned before</th>
                    <th>Assigned after</th>
                    <th>Recipient</th>
                    <th>Subject</th>
                    <th>Body</th>
                    <th>Emailed at</th>
                    <th>Created by</th>
                    <th>Updated by</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workordernotices as $workordernotice)
                    <tr>
                        <td>{{ $workordernotice->type }}</td>
                        <td>{{ $workordernotice->user_before }}</td>
                        <td>{{ $workordernotice->user_after }}</td>
                        <td>{{ $workordernotice->recipient }}</td>
                        <td>{{ $workordernotice->subject }}</td>
                        <td>{!! nl2br($workordernotice->body ?? '') !!}</td>
                        <td>{{ $workordernotice->emailed_at }}</td>
                        <td>{{ $workordernotice->created_by }}</td>
                        <td>{{ $workordernotice->updated_by }}</td>
                        <td>{{ $workordernotice->created_at }}</td>
                        <td>{{ $workordernotice->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            workorder
            @php dump(@$workorder) @endphp
            hospital
            @php dump(@$hospital) @endphp
            hospitalraw
            @php dump(@$hospitalraw) @endphp
        </div>
    @endif

</x-user-layout>
