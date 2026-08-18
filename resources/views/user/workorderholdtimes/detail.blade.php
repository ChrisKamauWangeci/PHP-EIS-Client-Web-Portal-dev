<x-user-layout title="">

    <div v-cloak id="workorderholdtimes">

        <div class="row">
            <div class="col-auto">
                <h1>Workorder Hold Times: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }} {{ $workorder->W_LastName }}</h1>
            </div>
        </div>

        <br />

        <button class="btn btn-sm btn-secondary" @click="getworkorderholdtimes">Refresh <span v-if="!workorderholdtimes"><i class="fas fa-sync-alt fa-spin"></i></span></button>

        <br />
        <br />

        <div class="table-responsive" v-if="workorderholdtimes">
            <table class="table table-sm table-hover table-bordered w-auto">
                <thead>
                    <tr>
                        <th>Hold</th>
                        <th>Reason & Status Code</th>
                        <th>Requirement</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Created By</th>
                        <th>Modified By</th>
                        <th>Created</th>
                        <th>Modified</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="workorderholdtimeexisting in workorderholdtimes">
                        <td>@{{ workorderholdtimeexisting.hold_id }}</td>
                        <td>@{{ workorderholdtimeexisting.reason }}<br /><small>@{{ workorderholdtimeexisting.status_code }}</small></td>
                        <td>@{{ workorderholdtimeexisting.requirement }}</td>
                        <td>@{{ workorderholdtimeexisting.date_start }}</td>
                        <td>@{{ workorderholdtimeexisting.date_end }}</td>
                        <td>@{{ workorderholdtimeexisting.created_by }} </td>
                        <td>@{{ workorderholdtimeexisting.modified_by }} </td>
                        <td>@{{ workorderholdtimeexisting.created }} </td>
                        <td>@{{ workorderholdtimeexisting.modified }} </td>
                        <td nowrap>
                            &nbsp;
                            <span v-if="!workorderholdtimeexisting.date_end">
                                <button class="btn btn-xs btn-secondary" @click="close(workorderholdtimeexisting.id)">Close</button>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <br />
        <br />

        <div class="row">
            <div class="col-sm-6">

                <h3>Add Hold Time</h3>

                <form method="post" @submit.prevent="store()" accept-charset="utf-8">

                    <label for="reason">Reason</label>
                    <select name="reason" id="reason" v-model="reason" @change="reasonchange($event)" class="form-select form-select-sm" required>
                        <option v-for="item in reasons" :value="item">@{{ item }}</option>
                    </select>
                    <br />

                    <div v-if="reason == 'Special Authorization Prefill' || reason == 'Special Authorization Non Prefill'">

                        Requirements
                        <br />

                        <input type="checkbox" name="requirements[]" id="requirement_1" v-model="requirements" value="1" />
                        <label for="requirement_1">Rejected for E-Signature</label>

                        <br />

                        <input type="checkbox" name="requirements[]" id="requirement_2" v-model="requirements" value="2" />
                        <label for="requirement_2">TPO Statement Required</label>

                        <br />

                        <input type="checkbox" name="requirements[]" id="requirement_3" v-model="requirements" value="3" />
                        <label for="requirement_3">Revocation Statement Required</label>

                        <br />

                        <input type="checkbox" name="requirements[]" id="requirement_4" v-model="requirements" value="4" />
                        <label for="requirement_4">Facility Information Required</label>

                        <br />

                        <input type="checkbox" name="requirements[]" id="requirement_5" v-model="requirements" value="5" />
                        <label for="requirement_5">Sensitive Information</label>

                        <br />

                        <input type="checkbox" name="requirements[]" id="requirement_6" v-model="requirements" value="6" />
                        <label for="requirement_6">Illegible Form Provided</label>

                        <br />

                        <input type="checkbox" name="requirements[]" id="requirement_8" v-model="requirements" value="8" />
                        <label for="requirement_8">Voice Signature Required</label>

                        <br />

                        <input type="checkbox" name="requirements[]" id="requirement_9" v-model="requirements" value="9" />
                        <label for="requirement_9">Date of Signature Required</label>

                        <br />

                        <input type="checkbox" name="requirements" id="requirement_10" v-model="requirements" value="10" />
                        <label for="requirement_10">Form Requested Per Requestor</label>

                        <br />

                        <input type="checkbox" name="requirements" id="requirement_11" v-model="requirements" value="11" />
                        <label for="requirement_11">Facility Form Required</label>

                        <br />

                        <input type="checkbox" name="requirements" id="requirement_12" v-model="requirements" value="12" />
                        <label for="requirement_12">Rejected for Docu-sign</label>

                        <br />

                        <input type="checkbox" name="requirements" id="requirement_13" v-model="requirements" value="13" />
                        <label for="requirement_13">Disclosure/Redisclosure Statement Required</label>

                        <br />

                        <input type="checkbox" name="requirements" id="requirement_14" v-model="requirements" value="14" />
                        <label for="requirement_14">Additional Patient Information Required</label>

                        <br />

                        <input type="checkbox" name="requirements" id="requirement_15" v-model="requirements" value="15" />
                        <label for="requirement_15">Invalid Form Provided</label>

                        <br />

                        <input type="checkbox" name="requirements" id="requirement_17" v-model="requirements" value="17" />
                        <label for="requirement_17">Rejected For Voice Signature</label>

                        <br />
                        <br />

                    </div>

                    <label for="status-note">Status Note</label>
                    <textarea name="status_note" id="status-note" v-model="status_note" :required="reason != 'Special Authorization Prefill'" rows="3" maxlength="500" class="form-control form-control-sm" aria-required="true"></textarea>
                    <div class="small" id="counter-status-note-start"></div>
                    <br />

                    <label for="date-start">Start Date</label>
                    <input type="date" name="date_start" v-model="date_start" label="Start Date" class="form-control form-control-sm" id="date-start" value="{{ date('Y-m-d') }}" min="{{ now()->subDays(30)->format('Y-m-d') }}" max="{{ now()->addDays(30)->format('Y-m-d') }}" required>
                    <br />

                    @if ($subdomain == 'eisdev' || $subdomain == 'eisuat')

                        <input type="checkbox" name="nohold" id="nohold" v-model="isChecked" :true-value="1" :false-value="0" class="form-check-input border border-black">
                        <label class="form-check-label" for="nohold"> Do not put case on hold </label>

                    @endif

                    <br />
                    <br />

                    <x-form.button>Submit</x-form.button>

                    <div v-if="showStoreMessage" class="small text-success pt-2">Submitted!</div>

                </form>

            </div>

            <div class="col-sm-6">

                <div v-if="workorderholdtime_id">
                    <h3>Close Hold Time</h3>

                    <div class="p-1"></div>

                    Workorder Hold Id: @{{ workorderholdtime_id }}
                    <br />
                    Workorder: @{{ workorderholdtime.workorder_id }}
                    <br />
                    Reason: @{{ workorderholdtime.reason }}
                    <br />
                    Start Date: @{{ workorderholdtime.date_start }}
                    <br />

                    <br />

                    <form method="post" @submit.prevent="update()" accept-charset="utf-8">

                        <label for="status-note-end">Status Note</label>
                        <textarea name="status_note_end" id="status-note-end" v-model="status_note_end" :required="workorderholdtime.reason != 'Special Authorization'" rows="3" maxlength="500" class="form-control form-control-sm" aria-required="true"></textarea>
                        <div class="small" id="counter-status-note-end"></div>
                        <br />

                        <label for="date-end">End Date</label>
                        <input type="date" name="date_end" v-model="date_end" label="End Date" class="form-control form-control-sm" id="date-end" value="{{ date('Y-m-d') }}" :min="workorderholdtime ? workorderholdtime.date_start : '{{ now()->subDays(30)->format('Y-m-d') }}'" max="{{ now()->addDays(30)->format('Y-m-d') }}" required>
                        <br />

                        <x-form.button>Submit</x-form.button>
                        &nbsp;
                        <button class="btn btn-sm btn-secondary" type="reset" @click="workorderholdtime_id = null; workorderholdtime = null;">Reset</button>

                    </form>
                </div>

            </div>
        </div>

        <br />
        <br />

    </div>

    <script type="module">

        function textAreaCharacterCounter(textareaId, counterId) {
            const textarea = document.getElementById(textareaId);
            const counter = document.getElementById(counterId);

            if (textarea && counter) {
                const maxLength = parseInt(textarea.getAttribute('maxLength')) || 500;

                function updateCounter() {
                    const length = textarea.value.length;
                    counter.textContent = `${length}/${maxLength}`;
                }

                textarea.addEventListener('input', updateCounter);
                updateCounter();
            }
        }

        const {
            createApp,
            ref
        } = Vue

        createApp({

            setup() {

                const workorderholdtime_id = ref();
                const workorderholdtime = ref();
                const workorderholdtimes = ref([]);
                const reason = ref('');
                const requirement = ref();
                const requirements = ref([]);
                const date_start = ref("{{ date('Y-m-d') }}");
                const date_end = ref("{{ date('Y-m-d') }}");
                @if ($subdomain == 'eisdev' || $subdomain == 'eisuat')
                    const nohold = ref('');
                    const isChecked = 0;
                @endif
                const showStoreMessage = ref(false);
                const status_note = ref('');
                const status_note_end = ref('');
                const requirementblock = ref(1);

                const reasonsorig = [
                    '',
                    'Additional Facility Information Needed',
                    'Additional Patient Information Needed',
                    'Cancellation Fee Notice',
                    'Cancellation Not Possible',
                    'Facility Unresponsive Uncooperative',
                    'Fee Approval',
                    'No Records',
                    'Order on Hold Per Requestor',
                    'Other',
                    'Patient Assistance Needed',
                    'Patient ID/Drivers License Required',
                    'Patient Refusal To Release Records',
                    'Power of Attorney Required/Rejected',
                    'Special Authorization Non Prefill',
                    'Special Authorization Prefill',
                    'Time Frame Verification Needed',
                    'HIPAA Not Received with Order',
                ];

                const reasons = ref();

                function reasonchange() {
                    if (reason.value != 'Special Authorization Prefill') {
                        this.requirements = [];
                    }
                    if (reason.value != 'Special Authorization Prefill Non Prefill') {
                        this.requirements = [];
                    }
                }

                async function getworkorderholdtimes() {
                    showStoreMessage.value = false;
                    reasons.value = reasonsorig.value;
                    workorderholdtimes.value = null;
                    reasons.value = JSON.parse(JSON.stringify(reasonsorig));
                    try {
                        const response = await fetch('/api/workorderholdtimes?&workorder_id={{ $workorder->W_WorkOrder }}')
                        const result = await response.json()
                        workorderholdtimes.value = result;
                        for (const key in result) {
                            var index = reasons.value.indexOf(result[key]['reason']);
                            if (index >= 0 && !result[key]['date_end']) {
                                reasons.value.splice(index, 1);
                            }
                        }
                    } catch (error) {
                        console.error('There was an error! ', error)
                    }
                }
                getworkorderholdtimes();

                setTimeout(() => {
                    textAreaCharacterCounter('status-note', 'counter-status-note-start');
                }, 100);

                async function store() {

                    const requestOptions = {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            workorder_id: <?= $workorder->W_WorkOrder ?>,
                            reason: this.reason,
                            requirement: this.requirement,
                            requirements: this.requirements,
                            status_note: this.status_note,
                            date_start: this.date_start,
                            <?php if ($subdomain == 'eisdev' || $subdomain == 'eisuat') : ?>
                                nohold: this.isChecked,
                            <?php endif; ?>
                        })
                    };

                    try {
                        const response = await fetch('/api/workorderholdtimes', requestOptions)
                        const result = await response.json();
                        this.reason = '';
                        this.requirement = null;
                        this.status_note = null;

                        <?php if ($subdomain == 'eisdev' || $subdomain == 'eisuat') : ?>
                            this.isChecked = false;
                        <?php endif; ?>

                        this.showStoreMessage = true;
                        this.getworkorderholdtimes();
                        this.showStoreMessage = true;
                    } catch (error) {
                        console.error('There was an error! ', error)
                    }

                }

                async function close(id) {
                    showStoreMessage.value = false;
                    workorderholdtime_id.value = id;
                    for (const key in workorderholdtimes.value) {
                        if (workorderholdtimes.value[key]['id'] == id) {
                            workorderholdtime.value = workorderholdtimes.value[key];
                        }
                    }
                    setTimeout(() => {
                        textAreaCharacterCounter('status-note-end', 'counter-status-note-end');
                    }, 100);
                }

                async function update() {

                    const requestOptions = {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: this.workorderholdtime_id,
                            status_note_end: this.status_note_end,
                            date_end: this.date_end,
                        })
                    };

                    try {
                        const response = await fetch('/api/workorderholdtimes/' + this.workorderholdtime_id, requestOptions)
                        const result = await response.json();
                        status_note_end.value = null;
                        workorderholdtime_id.value = null;
                        this.getworkorderholdtimes();
                    } catch (error) {
                        console.error('There was an error! ', error)
                    }

                }

                return {
                    store,
                    close,
                    update,
                    getworkorderholdtimes,
                    workorderholdtime,
                    workorderholdtimes,
                    workorderholdtime_id,
                    reasons,
                    reasonsorig,
                    reasonchange,
                    reason,
                    // requirementblock,
                    requirement,
                    requirements,
                    date_start,
                    date_end,

                    @if ($subdomain == 'eisdev' || $subdomain == 'eisuat')
                        nohold,
                        isChecked,
                    @endif

                    showStoreMessage,
                    status_note,
                    status_note_end,
                }

            }

        }).mount('#workorderholdtimes');
    </script>

</x-user-layout>