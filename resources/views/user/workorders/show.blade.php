<x-user-layout title="">

    <style>
        #hospitalnote {
            display: none;
        }

        #applicantinfo {
            display: none;
        }

        .expanded {
            height: 700px !important;
        }

        .oob-flash {
            animation: fadeHighlight 2s ease forwards;
            background-color: yellow;
        }

        @keyframes fadeHighlight {
            to {
                background-color: transparent;
            }
        }

        .markdown-content strong {
            color: #0f5132;
            display: inline-block;
            margin-top: 0.25rem;
        }

        .markdown-content ul {
            padding-left: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .markdown-content p {
            margin-bottom: 0.5rem;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {

            document.getElementById('statusnoteform')?.addEventListener('submit', function(event) {
                this.querySelector('button[type="submit"]').disabled = true;
                this.getElementsByClassName("spin")[0].classList.add("fas", "fa-sync-alt", "fa-spin");
            });

            document.getElementById('followupstatusnoteform')?.addEventListener('submit', function(event) {
                this.querySelector('button[type="submit"]').disabled = true;
                this.getElementsByClassName("spin")[0].classList.add("fas", "fa-sync-alt", "fa-spin");
            });

            @if ($subdomain == 'eisdev1')
                document.getElementById('requestlogform')?.addEventListener('submit', function(event) {
                    this.querySelector('button[type="submit"]').disabled = true;
                    this.getElementsByClassName("spin")[0].classList.add("fas", "fa-sync-alt", "fa-spin");
                });
            @endif

            document.getElementById('transferassignedtoform')?.addEventListener('submit', function(event) {
                this.querySelector('button[type="submit"]').disabled = true;
                this.getElementsByClassName("spin")[0].classList.add("fas", "fa-sync-alt", "fa-spin");
            });

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Utility: Textarea counter
            function addCounter(textareaId, counterId) {
                const textarea = document.getElementById(textareaId);
                const counter = document.getElementById(counterId);
                const maxLength = parseInt(textarea?.getAttribute('maxLength')) || 500;

                if (!textarea || !counter) return;

                function updateCounter() {
                    counter.textContent = `${textarea.value.length}/${maxLength}`;
                }

                textarea.addEventListener('input', updateCounter);
                updateCounter();
            }

            function initCounters() {
                addCounter("note", "counter1");
                addCounter("W_FollowUpStatus", "counter2");
                addCounter("W_Note3", "counter3");
            }

            initCounters();

            document.body.addEventListener("htmx:afterSwap", function(e) {
                initCounters();
            });

            document.body.addEventListener('htmx:afterSwap', function(evt) {
                if (evt.detail.target.id === 'llm-eis-response') {
                    const target = evt.detail.target;
                    const rawText = target.innerText;

                    if (rawText.trim()) {
                        // Convert markdown text to clean HTML
                        const parsedHtml = typeof marked !== 'undefined' ? marked.parse(rawText) : rawText;

                        // Wrap inside a styled Bootstrap panel
                        target.innerHTML = `
                            <div class="card border-info shadow-sm mb-3">
                                <div class="card-header bg-info-subtle fw-bold d-flex justify-content-between align-items-center">
                                    <span><i class="fa-solid fa-robot me-1"></i> EIS Analysis Results</span>
                                    <button type="button" class="btn-close btn-sm" onclick="document.getElementById('llm-eis-response').innerHTML=''"></button>
                                </div>
                                <div class="card-body p-3 text-dark small leading-relaxed markdown-content">
                                    ${parsedHtml}
                                </div>
                            </div>
                        `;
                    }
                }
            });

            @if ($subdomain == 'eisdev')
                let llm1Start = 0;
                document.body.addEventListener("htmx:beforeRequest", function(e) {
                    if (e.detail.target && e.detail.target.id === "llm1") {
                        llm1Start = Date.now();
                    }
                });
                document.body.addEventListener("htmx:afterRequest", function(e) {
                    if (e.detail.target && e.detail.target.id === "llm1" && llm1Start) {
                        document.getElementById("llm1-timer").textContent = ((Date.now() - llm1Start) /
                            1000).toFixed(2) + "s";
                    }
                });

                let llm2Start = 0;
                document.body.addEventListener("htmx:beforeRequest", function(e) {
                    if (e.detail.target && e.detail.target.id === "llm2") {
                        llm2Start = Date.now();
                    }
                });
                document.body.addEventListener("htmx:afterRequest", function(e) {
                    if (e.detail.target && e.detail.target.id === "llm2" && llm2Start) {
                        document.getElementById("llm2-timer").textContent = ((Date.now() - llm2Start) /
                            1000).toFixed(2) + "s";
                    }
                });
            @endif

            // Toggle sections
            function setupToggle(buttonId, targetId) {
                const btn = document.getElementById(buttonId);
                const target = document.getElementById(targetId);

                if (btn && target) {
                    btn.addEventListener('click', () => {
                        target.style.display = (target.style.display === 'none' || !target.style.display) ?
                            'block' : 'none';
                    });
                }
            }

            setupToggle('hospitalnotedisplay', 'hospitalnote');
            setupToggle('applicantinfodisplay', 'applicantinfo');

            // Modal label/text preview
            function setupModal(viewBtnId, labelId, textId, sourceId) {
                const viewBtn = document.getElementById(viewBtnId);
                const label = document.getElementById(labelId);
                const text = document.getElementById(textId);
                const source = document.getElementById(sourceId);

                if (viewBtn && label && text && source) {
                    viewBtn.addEventListener('click', () => {
                        label.innerHTML = viewBtn.dataset.label || '';
                        text.innerHTML = source.innerHTML || '';
                    });
                }
            }

            setupModal('statusnoteview', 'modallabel', 'modaltext', 'statusnotetext');
            setupModal('followupstatusview', 'modallabel', 'modaltext', 'followupstatustext');

            // Format date MM/DD/YYYY
            function formatDateInput(inputId, outputId) {
                const input = document.getElementById(inputId);
                const output = document.getElementById(outputId);

                if (!input || !output) return;

                input.addEventListener('change', () => {
                    const val = input.value;
                    if (val.length === 10) {
                        const formatted = `${val.slice(5, 7)}/${val.slice(8, 10)}/${val.slice(0, 4)}`;
                        output.textContent = formatted;
                    }
                });
            }

            formatDateInput('w-note-date', 'w-note-date2');
            formatDateInput('w-follow-up-status-date', 'w-follow-up-status-date2');

        });

        $(document).ready(function() {

            $("#note").prop('disabled', true);

            $('#statusnoteid').on('change', function(event) {
                var selected = $("#statusnoteid option:selected").text().split(': ');

                if (selected[1]) {
                    $("#note").prop('disabled', false);
                } else {
                    $("#note").prop('disabled', true);
                }

                $("#note").val(selected[1]);
            });

            $('#followupstatuslists').on('change', function(event) {
                var selected = $("#followupstatuslists option:selected").text().split(': ');
                $("#W_FollowUpStatus").val(selected[1]);
            });

        });

        function popup(url) {
            window.open(url, "popup", "scrollbars=yes,width=1280,height=800,resizable=yes,left=40,top=40")
        }

        function showModal(url) {
            $.get(url, function(data) {
                $('.modal-body').html(data);
            });
        }

        function expand() {
            document.querySelectorAll(".expandables").forEach(el => el.classList.toggle('expanded'));
            document.querySelectorAll(".fa-maximize").forEach(el => el.classList.toggle('fa-minimize'));
        }
    </script>

    <div id="app" v-cloak class="container-fluid">

        <div class="row sticky-top bg-body pt-1 border shadow-sm">
            <div class="col px-1">

                @if ($workorderholdtimescount)
                    <div class="bg-warning px-1">
                        <h2>Workorder ON HOLD: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }}
                            {{ $workorder->W_MiddleInit }} {{ $workorder->W_LastName }}</h2>
                    </div>
                @else
                    <h2>Workorder: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }}
                        {{ $workorder->W_MiddleInit }} {{ $workorder->W_LastName }}</h2>
                @endif

                <strong>DOB:</strong> {{ $workorder->W_DOB?->format('m/d/Y') }} - <strong>SSN:</strong>
                {!! Helper::ssn($usersession, $workorder->W_SS) !!} - <strong>GENDER:</strong> {{ $workorder->W_Gender }}

            </div>
            <div class="col-auto float-end d-print-none px-1">

                <a href="{{ route('user.workorders.edit', $workorder->W_WorkOrder) }}"
                    class="btn btn-sm btn-secondary">Edit</a>
                &nbsp;
                @if ($usersession['contractor']['access_files'])
                    <a href="{{ route('user.workorderfiles.show', $workorder->W_WorkOrder) }}"
                        class="btn btn-sm btn-secondary">Files</a>
                    &nbsp;
                @endif
                <a href="{{ route('user.workorderprefills.index', ['workorder_id' => $workorder->W_WorkOrder]) }}"
                    class="btn btn-sm btn-secondary">Prefills</a>
                &nbsp;
                <a href="{{ url()->full() }}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-rotate"></i></a>
                &nbsp;
                <a href="#bottom" class="btn btn-sm btn-secondary"><i class="fa-solid fa-angles-down"></i></a>

            </div>
        </div>

        <br />

        <div class="row">
            <div class="col-12 py-1 bg-secondary-subtle border border-secondary">
                <strong>Workorder {!! Helper::statusesIcons($workorder->W_Status) !!}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Workorder
                <br />
                <strong>{{ $workorder->W_WorkOrder }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Company
                <span data-bs-trigger="click" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="{{ $workorder->Company_C_Instruction ?? '-' }}"><i
                        class="fa-solid fa-circle-info"></i></span>
                <br />
                <strong>{{ $workorder->Company_C_Name }}</strong>
            </div>
            <div class="col-6 col-md-3 border px-1">
                Insurance Company
                <br />
                <strong>{{ $workorder->W_InsCompany }}</strong>
            </div>
            <div class="col-6 col-md-3 border px-1">
                Billing Company
                <br />
                <strong>{{ $workorder->W_BillCompany }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Fee Limit:
                $<strong>{{ $workorder->BillToPickList_BL_MaxAmt ? number_format($workorder->BillToPickList_BL_MaxAmt ?? 0, 2) : '' }}</strong>
                <br />
                EIS Fee:
                $<strong>{{ $workorder->Billingfeeeis_B_Fee ? number_format($workorder->Billingfeeeis_B_Fee ?? 0, 2) : '' }}</strong>
            </div>

            <div class="col-6 col-md-2 border px-1">
                Urgent
                <br />
                <strong>{!! Helper::urgent($workorder->W_Urgent) !!}</strong>&nbsp; {!! Helper::UrgentIcons($workorder->W_Urgent) !!}
            </div>
            <div class="col-6 col-md-2 border px-1">
                Requestor
                <span data-bs-trigger="click" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="{{ $workorder->Requestor_R_Email ?? '-' }}"><i
                        class="fa-solid fa-circle-info"></i></span>

                @if (in_array($workorder->W_Status, ['Incomplete', 'Complete'], true) &&
                        ($usersession['contractor']['C_SysAdmin'] ?? false))
                    <small><a
                            href="{{ route('user.workorders.changerequestor', $workorder->W_WorkOrder) }}">Change</a></small>
                @endif

                <br />
                <strong>{{ $workorder->W_Requestor }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Case Manager
                <br />
                <strong>{{ $workorder->W_Contractor }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Assigned to -
                <small><a href="#bottom">Transfer</a></small>

                <br />
                <strong>{{ $workorder->W_Owner }}</strong>
                @if (!$workorder->W_Owner)
                    <div class="text-danger">NOT ASSIGNED !</div>
                @endif
            </div>
            <div class="col-6 col-md-2 border px-1">
                Agent
                <br />
                <strong>{{ $workorder->W_Agent }}</strong>
                @if ($workorder->W_Agent == 'TORRIE ROGERS')
                    &nbsp;<i class="fa-solid fa-circle-exclamation fa-beat-fade text-danger"></i>
                @endif
            </div>
            <div class="col-6 col-md-2 border px-1">
                {{ $subdomain == 'usaa' ? 'Member #' : 'Case #' }}
                <br />
                <strong>{{ $workorder->W_PolicyNo }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Policy #
                <br />
                <strong>{{ $workorder->W_InsPolicy }}</strong>
            </div>

            <div class="col-6 col-md-2 border px-1">
                Request ID #
                <br />
                <strong>{{ $workorder->W_TransNo }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Contractor Fee
                <br />
                <strong>{{ $workorder->W_ContractorFee }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                @if ($usersession['contractor']['access_files'])
                    Authorization File
                    <br />
                    <strong>
                        @php
                            $authform = '\\\\server2\eisaccess\\' . $subdomain . '\\AuthForms\\';
                            if ($subdomain == 'eis') {
                                $authform = '\\\\server2\eisaccess\\AuthForms\\';
                            }
                        @endphp
                        <a href="/user/workorderfiles/file?file={{ urlencode($authform . $workorder->W_AuthorizedFile) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=1"
                            target="_blank">{{ $workorder->W_AuthorizedFile }}</a>
                    </strong>
                @endif
            </div>
            <div class="col-6 col-md-2 border px-1">
                Image File

                {{-- <a href="#" id="" data-bs-toggle="modal" data-bs-target="#modal" onclick="showModal('{{ route('user.workorderfiledownloads.index', ['order_type' => 'aps', 'workorder_id' => $workorder->W_WorkOrder]) }}')" class="small">Downloads</a> --}}

                <a href="#" id="" data-bs-toggle="modal" data-bs-target="#modal"
                    onclick="showModal('{{ route('user.workorderfiletransfers.index', ['order_type' => 'aps', 'workorder_id' => $workorder->W_WorkOrder]) }}')"
                    class="small">Download History</a>

                <br />
                <strong>{{ $workorder->W_ImageFile }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Number of Files
                <br />
                <strong>{{ $workorder->W_NoFiles }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Number of Pages
                <br />
                <strong>{{ $workorder->W_ImagePages }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Shipping Fee 1
                <br />
                <strong>{{ $workorder->W_ShipFee1 }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Send Tracking 1
                <br />
                <strong>{!! Helper::tracking($workorder->W_Tracking1) !!}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Shipping Fee 2
                <br />
                <strong>{{ $workorder->W_ShipFee2 }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Return Tracking 1
                <br />
                <strong>{!! Helper::tracking($workorder->W_Tracking2) !!}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Shipping Fee
                <br />
                <strong>{{ $workorder->W_ShipFee }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Status
                <br />
                {!! Helper::statusesIcons($workorder->W_Status) !!} <strong>{{ $workorder->W_Status }}</strong>

                @if ($workorder->W_Status != 'Incomplete')
                    <br />
                    <small>
                        <a href="{{ route('user.workorders.reopen', $workorder->W_WorkOrder) }}">Reopen Workorder</a>
                    </small>
                @endif

                @if ($workorder->W_Status == 'Incomplete')
                    <br />
                    <small>
                        <a href="{{ route('user.workorders.cancel', $workorder->W_WorkOrder) }}">Cancel Workorder</a>
                    </small>
                @endif
            </div>
            <div class="col-6 col-md-2 border px-1">
                Received Date
                <br />
                <strong>{{ $workorder->W_ReceiveDate?->format('m/d/Y') }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Updated Date
                <br />
                <strong>{{ $workorder->W_UpdDate?->format('m/d/Y g:i a') }} pst</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Updated By
                <br />
                <strong>{{ $workorder->W_UpdUser }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Follow up Date - <a href="{{ route('user.workorders.edit', $workorder->W_WorkOrder) }}"
                    class="small">Edit</a>
                <br />
                <strong>{{ $workorder->W_FollowUpDt?->format('m/d/Y') }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Completed Date
                <br />
                <strong>{{ $workorder->W_CompletedDate?->format('m/d/Y') }}</strong>
            </div>

            <div class="col-6 col-md-2 border px-1">
                Workorder Age
                <br />
                <strong>
                    @if ($workorder->W_ReceiveDate)
                        @php
                            $start = \Carbon\Carbon::parse($workorder->W_ReceiveDate);
                            $end = null;

                            if ($workorder->W_Status === 'Incomplete') {
                                $end = now();
                            } elseif (
                                in_array($workorder->W_Status, ['Complete', 'Cancel']) &&
                                $workorder->W_CompletedDate
                            ) {
                                $end = \Carbon\Carbon::parse($workorder->W_CompletedDate);
                            }

                            $days = $end ? (int) $start->diffInDays($end) : null;
                        @endphp

                        {{ $days ?? '—' }}
                    @endif
                </strong>
            </div>

            <div class="col-6 col-md-2 border px-1">
                Source System
                <br />
                <strong>{!! Helper::integrationid($workorder->W_HospitalID) !!}</strong> <small>{{ $workorder->W_HospitalID }}</small>
            </div>

            @php
                $preissueuw = $workorder->W_HospitalID == 55 && $workorder->post_issue_audit == 0 ? 'Yes' : 'No';
            @endphp
            <div class="col-6 col-md-2 border px-1 {{ $preissueuw == 'Yes' ? 'bg-danger text-white fw-bold' : '' }}">
                Pre Issue UW
                <br />
                <strong>
                    {{ $preissueuw }}
                </strong>
            </div>

            <div
                class="col-6 col-md-2 border px-1 {{ $workorder->post_issue_audit ? 'bg-danger text-white fw-bold' : '' }}">
                Post Issue Audit Case
                <br />
                <strong>
                    {{ $workorder->post_issue_audit ? 'Yes' : 'No' }}
                </strong>
            </div>
            <div
                class="col-6 col-md-2 border px-1 {{ (float) ($workorder->W_DrFee1 ?? 0) + (float) ($workorder->W_DrFee2 ?? 0) != (float) ($workorder->W_DrFee ?? 0) ? 'bg-danger-subtle' : '' }}">
                Dr Fee
                <br />
                <small>{{ $workorder->W_DrFee1 }} + {{ $workorder->W_DrFee2 }} =
                </small><strong>{{ $workorder->W_DrFee }}</strong>
            </div>

            <div class="col-6 col-md-2 border px-1">
                Group (Requestor Role)
                <br />
                <strong>{!! Helper::highlightGroup($requestorrole->name ?? '') !!}</strong>
            </div>

            @if ($workorder->Company_C_Name == 'FFR')
                <div class="col-6 col-md-2 border px-1">
                    Company Producer ID
                    <br />
                    <strong>{{ $apsorder?->CompanyProducerID ?? 'N/A' }}</strong>
                </div>
            @endif

        </div>

        <br />

        <div class="row">
            <div class="col-12 bg-light border py-1 border-secondary bg-primary-subtle">
                <strong>Applicant</strong> <button class="btn btn-xs btn-secondary" id="applicantinfodisplay">Display
                    Applicant Info</button>
                @php
                    $class = 'btn btn-xs btn-info float-end';
                    if ($workorder->W_MultWO) {
                        $class = 'btn btn-xs btn-danger float-end';
                    }
                @endphp
                @if ($subdomain == 'eisdev')
                    <a href="/user/workorders?search=1&database=eis&amp;W_FirstName={{ $workorder->W_FirstName }}&amp;W_LastName={{ $workorder->W_LastName }}&amp;W_SS={{ $workorder->W_SS }}&amp;W_DOB={{ $workorder->W_DOB?->format('Y-m-d') }}"
                        class="{{ $class }}" target="_blank">Search Matching Orders</a>
                @endif
            </div>
            <div class="col-4 col-md-2 border px-1">
                Applicant First Name
                <br />
                <strong>{{ $workorder->W_FirstName }}</strong>
            </div>
            <div class="col-4 col-md-2 border px-1">
                Applicant Middle Initial
                <br />
                <strong>{{ $workorder->W_MiddleInit }}</strong>
            </div>
            <div class="col-4 col-md-2 border px-1">
                Applicant Last Name
                <br />
                <strong>{{ $workorder->W_LastName }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Applicant DOB
                <br />
                <strong>{{ $workorder->W_DOB?->format('m/d/Y') }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Applicant Gender
                <br />
                <strong>{{ $workorder->W_Gender }}</strong>
            </div>
            <div class="col-6 col-md-2 border px-1">
                Applicant Social Security
                <br />
                <strong>{!! Helper::ssn($usersession, $workorder->W_SS) !!}</strong>
            </div>
        </div>
        <div id="applicantinfo">
            <div class="row">

                <div class="col-6 col-md-2 border px-1">
                    Record #
                    <br />
                    <strong>{{ $workorder->W_RecordNo }}</strong>
                </div>

                @if ($workorder->Examrequest_E_WorkOrder)
                    <div class="col-6 col-md-3 border px-1">
                        Applicant Address
                        <br />
                        <strong>
                            {{ $workorder->Examrequest_E_Address }}
                            <br />
                            {{ $workorder->Examrequest_E_City }}
                            {{ $workorder->Examrequest_E_State }}
                            {{ $workorder->Examrequest_E_Zip }}
                        </strong>
                    </div>
                    <div class="col-6 col-md-2 border px-1">
                        Applicant Home Phone
                        <br />
                        <strong>{{ $workorder->Examrequest_E_HomePhone }}</strong>
                    </div>
                    <div class="col-6 col-md-2 border px-1">
                        Applicant Cell Phone
                        <br />
                        <strong>{{ $workorder->Examrequest_E_CellPhone }}</strong>
                    </div>
                    <div class="col-6 col-md-2 border px-1">
                        Applicant Email
                        <br />
                        <strong>{{ $workorder->Examrequest_E_ApplicantEmail }}</strong>
                        <br />
                        <br />
                    </div>
                    <div class="col-6 col-md-1 border p-1">
                        @if (str_contains($usersession['contractor']['C_Email'] ?? '', 'expressimagingservices.com'))
                            <a href="{{ route('user.examrequests.edit', $workorder->W_WorkOrder) }}"
                                class="btn btn-sm btn-secondary">Edit</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <br />

        <div class="row">
            <div class="col-12 bg-light border py-1 border-secondary bg-danger-subtle">
                <strong>Facility</strong>
            </div>
            <div class="col-md-3 border p-1">
                @if ($hospital)
                    <strong>{{ $hospital->H_Hospital }}</strong>
                    <br />
                    <strong>{{ $hospital->H_Hospital2 }}</strong>
                    <br />
                    {{ $hospital->H_Address }}
                    <br />
                    {{ $hospital->H_City }}.
                    {{ $hospital->H_State }}
                    {{ $hospital->H_Zip }}
                    <br />
                    <a href="tel:+1{{ preg_replace('/\D/', '', $hospital->H_Phone) }}">{{ $hospital->H_Phone }}</a>
                    @if ($hospital->H_PhoneExt)
                        ext: {{ $hospital->H_PhoneExt }}
                    @endif
                    (phone)
                    <br />
                    <a href="/user/hospitals?H_Fax={{ $hospital->H_Fax }}"
                        onclick="popup(this.href); return false;">{{ $hospital->H_Fax }}</a> (fax)
                    <div class="p-1"></div>
                    Copy Service:
                    @if ($hospital->H_CopyService)
                        <br />
                        <a href="/user/copyservices?C_CopyService={{ e($hospital->H_CopyService) }}"
                            onclick="popup(this.href); return false;"
                            class="fw-bold">{{ $hospital->H_CopyService }}</a>
                        <span class="btn btn-xs btn-success"
                            @click="getCopyservice(@js($hospital->H_CopyService ?? ''))">show</span>
                        <br />
                    @endif
                    <br />
                    Roi:
                    @if ($hospital->H_ROI)
                        <br />
                        <a href="/user/rois?R_ROIname={{ $hospital->H_ROI }}"
                            onclick="popup(this.href); return false;" class="fw-bold">{{ $hospital->H_ROI }}</a>
                        <span class="btn btn-xs btn-success" @click="getRoi(@js($hospital->H_ROI ?? ''))">show</span>
                        <br />
                    @endif
                    <br />

                    {{ $workorder->Company_C_Name }}

                    @if ($workorder->W_Status == 'Incomplete' && $hospital->H_Docusign)
                        docusign: {{ $hospital->H_Docusign }}

                        @if (!$inhouseprefill)

                            @if ($workorder->Company_C_Name != 'PLICO-WCL')
                                <br />
                                <a href="/user/workorders/docusign/{{ $workorder->W_WorkOrder }}"
                                    class="btn btn-xs btn-success">SARA Client with Docusign</a>
                                <br />
                            @endif

                        @endif

                        <div class="p-1"></div>

                        @php
                            $docusignCompanies = [
                                'EIS TEST',
                                'PLICO-WCL',
                                'PRUDENTIAL INSURANCE COMPANY OF AMERICA',
                                'BESTOW AGENCY LLC',
                                'MASSMUTUAL TEST',
                                'MASSMUTUAL',
                                'NORTHWESTERN MUTUAL',
                                'NORTHWESTERN MUTUAL LTC',
                                'CATHOLIC ORDER OF FORESTERS1',
                            ];

                            if ($subdomain === 'eisdev' || $subdomain === 'eisuat') {
                                $docusignCompanies[] = 'NATIONWIDE LIFE UNDERWRITING';
                                $docusignCompanies[] = 'CATHOLIC ORDER OF FORESTERS';
                            }
                        @endphp

                        @if (in_array($workorder->Company_C_Name, $docusignCompanies))
                            <a href="/user/workorders/docusign/{{ $workorder->W_WorkOrder }}"
                                class="btn btn-xs btn-success">SARA Client with Docusign</a>
                            <div class="p-1"></div>
                        @endif

                        <a href="{{ route('user.docusigndocuments.index', ['workorder_id' => $workorder->W_WorkOrder]) }}"
                            class="btn btn-xs btn-secondary">Docusign Documents</a>
                        <div class="p-1"></div>

                    @endif

                    @if ($inhouseprefill)
                        <a href="{{ route('user.signforms.index', ['W_WorkOrder' => $workorder->W_WorkOrder]) }}"
                            class="btn btn-xs btn-primary">In-house Prefill</a>
                        <div class="p-1"></div>
                    @endif

                @endif

                @if (!$hospital)
                    <strong class="text-danger">{{ $workorder->W_Hospital }}</strong>
                    <br />
                    <span class="text-danger">Workorder -> Hospital relationship is incorrect</span>
                @endif

                @if ($hospital && !empty(trim($hospital->H_Note ?? '')))
                    <div class="p-1"></div>
                    <button class="btn btn-xs btn-secondary" id="hospitalnotedisplay">Display Caller
                        Instructions</button>
                @endif

                <div class="p-1"></div>
                <button class="btn btn-xs btn-secondary" @click="getHospitalraw(@js($workorder->W_WorkOrder))">Display
                    Facility Raw</button>

                @if ($hospital)
                    <div class="p-1"></div>
                    <a href="/user/hospitals/{{ $hospital->H_ID }}" onclick="popup(this.href); return false;"
                        class="btn btn-xs btn-secondary">Facility View</a>

                    <a href="#" id="" data-bs-toggle="modal" data-bs-target="#modal"
                        onclick="showModal('/user/hospitals/{{ $hospital->H_ID }}')"
                        class="btn btn-xs btn-secondary">Facility View Modal</a>
                    <div class="p-1"></div>
                    <a href="/user/workorders/related/{{ $workorder->W_WorkOrder }}"
                        onclick="popup(this.href); return false;" class="btn btn-xs btn-secondary">Workorder Facility
                        Related</a>
                @endif

                @if ($workorder->W_Status != 'Incomplete1')
                    <div class="p-1"></div>
                    @if (!$workorder->W_Hospital || $usersession['contractor']['C_SysAdmin'])
                        <a href="{{ route('user.workorders.hospitalchange', $workorder->W_WorkOrder) }}"
                            class="btn btn-xs btn-secondary">Facility Upload</a>
                    @else
                        Facility already uploaded
                    @endif
                @endif

                <div class="p-1"></div>

                <a href="/user/faxes?workorder={{ $workorder->W_WorkOrder }}"
                    onclick="popup(this.href); return false;" class="btn btn-xs btn-secondary">Fax Logs</a>

            </div>
            <div class="col-md-9 border p-1">
                Timeframe <strong>{!! Helper::recordYearsFromTo($workorder->W_YearsOfRecord, $workorder->W_ReceiveDate, '', $usersession) !!}</strong>
                <hr>
                Header Instructions for PDF Cover Page
                <br />
                <strong>{!! nl2br(e($workorder->W_ExamStatus ?? '')) !!}</strong>
                <hr>
                Special Instructions for PDF Cover Page
                <br />
                <strong>{!! nl2br(e($workorder->W_Note2 ?? '')) !!}</strong>
                <hr>
                Requestor Note
                <br />
                <strong>{!! nl2br(e($workorder->W_RequestorNote ?? '')) !!}</strong>
            </div>
        </div>

        @if ($hospital)
            @if (trim($hospital->H_Note ?? ''))
                <div class="row border mt-2 p-2" id="hospitalnote">
                    <h5>Facility Note</h5>
                    {!! nl2br(e($hospital->H_Note ?? '')) !!}
                </div>
            @endif
        @endif

        <div class="row mt-2 border" v-if="infowindow">
            <div class="col-12 p-2">
                <button type="button" class="btn btn-xs mb-2 btn-danger" @click="infowindowhide()">hide</button>
                <h5 v-html="infowindowlabel"></h5>
                <div v-html="infowindow"></div>
            </div>
        </div>

        @if ($hospital)
            <br />

            <div class="row p-1 border bg-warning bg-opacity-10">
                <div class="col-12 p-1">
                    @php $variable = null; @endphp

                    @if ($hospital->H_SendMethod == 1)
                        @php $variable = 'Faxed request to ' . $hospital->H_Fax . ', '; @endphp
                    @endif

                    @if ($hospital->H_SendMethod == 2)
                        @php $variable = 'FedEx request, '; @endphp
                    @endif

                    @if ($hospital->H_SendMethod == 3 || $hospital->H_SendMethod == 4)
                        @php $variable = 'Mailed request to ' . $hospital->H_Address . ' ' . $hospital->H_City . ' ' . $hospital->H_State . ' ' . $hospital->H_Zip . ', '; @endphp
                    @endif

                    @if ($hospital->H_SendMethod == 5)
                        @php $variable = 'Email request to ' . $hospital->H_SendMethodEmail . ', '; @endphp
                    @endif

                    <h5>First Note</h5>

                    {{ $hospital->H_Hospital2 ?? $hospital->H_Hospital }}
                    @if (trim($hospital->H_Affiliate ?? ''))
                        (part of {{ $hospital->H_Affiliate }})
                    @endif
                    is contracting {{ $hospital->H_CopyService }} and their estimated turnaround time is
                    {{ $hospital->H_TurnOverDays }} business days.
                    Takes {{ $hospital->H_ResponseTime }} business days to log request.

                    @if ($hospital->H_SpecialAuth)
                        Special authorization may be required if the chart contains sensitive information.
                    @endif

                    {{ $variable }} LOR and @if ($hospital->H_SpecialAuth)
                        special
                        @endif authorization @if ($hospital->H_PayAdvance)
                            with prepayment
                        @endif are completed,
                        call back to {!! Helper::formatPhoneFax($hospital->H_Phone) !!}
                        set for {{ date('m/d/Y', strtotime($hospital->H_ResponseTime . ' weekdays')) }}.

                        @if (preg_match('/ACTON/i', $hospital->H_CopyService ?? ''))
                            {{ $hospital->H_CopyService }} does not accept cancellations once they receive a request
                            and ALL FEES MUST BE PAID IN FULL. Please let us know if you would like to proceed with this
                            request.
                        @endif

                        @if (preg_match('/MEDI COPY/i', $hospital->H_CopyService ?? ''))
                            {{ $hospital->H_CopyService }} cancellation fee policy is 50% of the total invoice. Please
                            let us know if you would like to proceed with this request.
                        @endif

                        <br />
                        <br />

                        <h5>Facility Note</h5>

                        {{ $workorder->W_FirstName }} {{ $workorder->W_LastName }}, DOB:
                        {{ $workorder->W_DOB?->format('m/d/Y') }}, SSN: {!! Helper::ssn($usersession, $workorder->W_SS) !!}
                        <br />
                        RELEASE FROM {{ $hospital->H_Hospital2 ?? $hospital->H_Hospital }}
                        <br />
                        {{ $hospital->H_Address }} {{ $hospital->H_City }}, {{ $hospital->H_State }}
                        {{ $hospital->H_Zip }}
                        <br />
                        RELEASE TO EIS PROCESSING CENTER / {{ $workorder->W_InsCompany }}
                        <br />
                        PO BOX 778, TORRANCE, CA 90508
                        <br />
                        @if (preg_match('/STANDARD INSURANCE COMPANY/', $workorder->W_InsCompany ?? ''))
                            FOR THE PURPOSE OF DISABILITY INSURANCE
                        @elseif (preg_match('/TRANSAMERICA LTC/', $workorder->W_InsCompany ?? ''))
                            FOR THE PURPOSE OF LONG TERM CARE
                        @else
                            FOR THE PURPOSE OF LIFE INSURANCE
                        @endif
                        <br />
                        REQUEST FOR: {!! Helper::recordYearsFromTo($workorder->W_YearsOfRecord, $workorder->W_ReceiveDate, '', $usersession) !!}

                        <br />
                        <br />

                </div>
            </div>
        @endif

        <br />

        <div class="modal modal-xl fade" id="modal" tabindex="-1" aria-labelledby="modallabel"
            aria-hidden="true" hx-push-url="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modallabel"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body overflow-auto" id="modaltext">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6 mt-auto">
                <a href="#" id="" data-bs-toggle="modal" data-bs-target="#modal"
                    onclick="showModal('/user/workorderholdtimes/detail?workorder_id={{ $workorder->W_WorkOrder }}')"
                    class="btn btn-sm btn-warning position-relative">
                    <i class="fa-regular fa-clock"></i> Hold Times
                    @if ($workorderholdtimescount)
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $workorderholdtimescount }}</span>
                    @else
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">{{ $workorderholdtimescount }}
                            <i class="fa-solid fa-thumbs-up"></i></span>
                    @endif
                </a>

                @if ($subdomain == 'eisdev1')
                    &nbsp;
                    <button class='btn btn-sm btn-secondary'
                        hx-get="/user/workorderholdtimes/detail?workorder_id={{ $workorder->W_WorkOrder }}"
                        hx-select="#content" hx-on:click="htmx.toggleClass('#holdtimes', 'd-none')"
                        hx-target="#holdtimes">
                        Hold Times - HTMX
                    </button>

                    <div class="p-2"></div>

                    <div id="holdtimes" class="d-none"></div>
                @endif

                <div class="p-2"></div>

            </div>
            <div class="col-6">
                @if ($incomingapslog)
                    <strong>Incoming APS Log</strong>
                    &nbsp;
                    <a href="#" id="" data-bs-toggle="modal" data-bs-target="#modal"
                        onclick="showModal('/user/incoming_aps_logs?workorder={{ $workorder->W_WorkOrder }}')"
                        class="btn btn-xs btn-secondary">view all logs</a>
                    <br />
                    Source: <strong>{{ $incomingapslog->source }}</strong><br />
                    New file: <strong>{{ $incomingapslog->new_file }}</strong><br />
                    Page count: <strong>{{ $incomingapslog->page_count }}</strong><br />
                    Invoice number: <strong>{{ $incomingapslog->invoice_number }}</strong><br />
                    Created at: <strong>{{ $incomingapslog->created_at->format('m/d/Y g:i a') }}</strong><br />
                    <div class="p-1"></div>
                @endif
            </div>

        </div>
        <div class="row">

            <div class="col-12 col-sm-6 border border-4 border-white p-2 bg-success bg-opacity-10">

                <strong class="h6 fw-bold">Status Note</strong>
                &nbsp;
                <span data-bs-toggle="modal" data-bs-target="#modal" data-label="Status Note" id="statusnoteview"><i
                        class="fa-solid fa-magnifying-glass"></i></span>
                &nbsp;
                <i class="fa-solid fa-maximize" onclick="expand();"></i>

                <div class="p-1"></div>

                <div class="overflow-auto bg-body p-2 border expandables"
                    style="height: 300px;  word-break: break-all;" id="statusnotetext">
                    <strong>New Status Notes:</strong>
                    <br />
                    @foreach ($statustriggers as $statustrigger)
                        {{ $statustrigger->Created?->format('m-d-Y') }} : {{ $statustrigger->laststatus }}
                        <hr>
                    @endforeach
                    <strong>Old Status Notes:</strong>
                    <br />
                    {!! nl2br(e($workorder->W_Note ?? '')) !!}
                </div>

                <br />

                <form method="post"
                    action="{{ route('user.workorders.updatestatusnote', $workorder->W_WorkOrder) }}"
                    id="statusnoteform">
                    @method('PATCH')
                    @csrf

                    Follow up Date <span id="w-note-date2"></span>
                    <input type="date" name="w_note_date" id="w-note-date"
                        class="form-control form-control-sm required" value="{{ date('Y-m-d') }}"
                        min="{{ now()->subMonths(3)->toDateString() }}"
                        max="{{ now()->addMonths(3)->toDateString() }}" autocomplete="off" required />
                    <br />

                    <x-form.select name="statusnoteid" id="statusnoteid" label="Status" :options="$statusnotes"
                        empty="-" :default="old('statusnoteid')" required />
                    <br />

                    <x-form.textarea name="note" id="note" label="Note" :value="old('note')" :rows="5"
                        minlength="5" maxlength="900" required />
                    <div class="small counter" id="counter1"></div>
                    <br />

                    <button class="btn btn-sm btn-secondary submitbutton" type="submit">Submit <i
                            class="spin"></i></button>

                </form>

                @if ($subdomain == 'eisdev')
                    <br />

                    <div id="llm1"></div>

                    <button hx-indicator="#spinner" hx-post="/user/spell/chat"
                        hx-headers='{"X-CSRF-TOKEN":"{{ csrf_token() }}"}'
                        hx-vals='js:{ text: document.getElementById("note").value, prompt: "basic" }'
                        hx-target="#llm1" hx-swap="innerHTML" hx-disabled-elt="self" class="btn btn-xs btn-success">
                        AI Azure OpenAI - Basic<span id="spinner" class="htmx-indicator"><i
                                class="fa-solid fa-spinner fa-spin"></i></span>
                    </button>
                    &nbsp;
                    <!-- Display Container for EIS Analysis -->
                    <div id="llm-eis-response" class="my-2"></div>

                    <!-- HTMX Button -->
                    <button hx-indicator="#spinner-eis" hx-post="/user/spell/chat"
                        hx-headers='{"X-CSRF-TOKEN":"{{ csrf_token() }}"}'
                        hx-vals='js:{ text: document.getElementById("note").value, prompt: "eis" }'
                        hx-target="#llm-eis-response" hx-swap="innerHTML" hx-disabled-elt="self"
                        class="btn btn-xs btn-success">
                        AI Azure OpenAI - EIS
                        <span id="spinner-eis" class="htmx-indicator ms-1">
                            <i class="fa-solid fa-spinner fa-spin"></i>
                        </span>
                    </button>
                    &nbsp;
                    <span id="llm1-timer" class="ms-2 text-muted"></span>
                @endif

            </div>

            <div class="col-12 col-sm-6 border border-4 border-white p-2 bg-success bg-opacity-10">

                <strong class="h6 fw-bold">Follow-Up Status</strong>
                &nbsp;
                <span data-bs-toggle="modal" data-bs-target="#modal" data-label="Follow-Up Status"
                    id="followupstatusview"><i class="fa-solid fa-magnifying-glass"></i></span>
                &nbsp;
                <i class="fa-solid fa-maximize" onclick="expand();"></i>

                <div class="p-1"></div>

                <div class="overflow-auto bg-body p-2 border expandables"
                    style="height: 300px; word-break: break-all;" id="followupstatustext">
                    {!! nl2br(e($workorder->W_FollowUpStatus ?? '')) !!}
                </div>

                <br />

                <form method="post"
                    action="{{ route('user.workorders.updatefollowupstatus', $workorder->W_WorkOrder) }}"
                    id="followupstatusnoteform">
                    @method('PATCH')
                    @csrf

                    Follow up Date <span id="w-follow-up-status-date2"></span>
                    <input type="date" name="w_follow_up_status_date" id="w-follow-up-status-date"
                        class="form-control form-control-sm required" autocomplete="off"
                        value="{{ date('Y-m-d') }}" min="{{ now()->subMonths(3)->toDateString() }}"
                        max="{{ now()->addMonths(3)->toDateString() }}" required />
                    <br />

                    <x-form.select name="followupstatuslists" id="followupstatuslists" label="Status"
                        :options="$followupstatuslists" empty="-" required />
                    <br />

                    <x-form.textarea name="W_FollowUpStatus" id="W_FollowUpStatus" label="Note" :value="old('W_FollowUpStatus')"
                        :rows="5" minlength="5" maxlength="500" required />
                    <div class="small counter" id="counter2"></div>
                    <br />

                    <button class="btn btn-sm btn-secondary submitbutton" type="submit">Submit <i
                            class="spin"></i></button>

                </form>

            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-6 border border-4 border-white p-2 bg-success bg-opacity-10">
                <h5>Follow-Up Note</h5>

                <br />

                <div id="form-container">
                    @include('user.workorders.partials._followupnote', ['workorder' => $workorder])
                </div>

                @if ($subdomain == 'eisdev')
                    <br />

                    <div id="llm2"></div>

                    <button hx-indicator="#spinner" hx-post="/user/spell/chat"
                        hx-headers='{"X-CSRF-TOKEN":"{{ csrf_token() }}"}'
                        hx-vals='js:{ text: document.getElementById("W_Note3").value, prompt: "basic" }'
                        hx-target="#llm2" hx-swap="innerHTML" hx-disabled-elt="self" class="btn btn-xs btn-success">
                        AI Azure OpenAI - Basic<span id="spinner" class="htmx-indicator"><i
                                class="fa-solid fa-spinner fa-spin"></i></span>
                    </button>
                    &nbsp;
                    <button hx-indicator="#spinner" hx-post="/user/spell/chat"
                        hx-headers='{"X-CSRF-TOKEN":"{{ csrf_token() }}"}'
                        hx-vals='js:{ text: document.getElementById("W_Note3").value, prompt: "eis" }'
                        hx-target="#llm2" hx-swap="innerHTML" hx-disabled-elt="self" class="btn btn-xs btn-success">
                        AI Azure OpenAI - EIS<span id="spinner" class="htmx-indicator"><i
                                class="fa-solid fa-spinner fa-spin"></i></span>
                    </button>
                    &nbsp;
                    <span id="llm2-timer" class="ms-2 text-muted"></span>
                @endif

            </div>
            <div class="col-12 col-sm-6 border border-4 border-white p-2 bg-success bg-opacity-10">

                @if (count($tickets))
                    <h5>Support Tickets</h5>

                    <br />

                    @if (count($tickets))
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-bordered w-auto">
                                <thead>
                                    <tr>
                                        <th>Requestor</th>
                                        <th>Title</th>
                                        <th>Assigned To</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <td>{{ $ticket->requestor_name }}</td>
                                            <td>{{ $ticket->title }}</td>
                                            <td>{{ $ticket->assigned_to }}</td>
                                            <td>
                                                {{ $ticket->created_at->format('m/d/Y') }}
                                                <br />
                                                {{ $ticket->created_at->diffForHumans() }}
                                            </td>
                                            <td>
                                                {{ $ticket->updated_at->format('m/d/Y') }}
                                                <br />
                                                {{ $ticket->updated_at->diffForHumans() }}
                                            </td>
                                            <td>
                                                {!! Helper::ticketStatusIcon($ticket->status) !!}
                                                <a href="{{ route('user.tickets.show', $ticket->id) }}"
                                                    class="btn btn-xs btn-secondary">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endif

                @if ($subdomain == 'eisdev1')
                    <h5>Requestlog</h5>

                    <a href="/user/requestlogs/?workorder_id={{ $workorder->W_WorkOrder }}"
                        onclick="popup(this.href); return false;" class="btn btn-xs btn-secondary">Requestlogs
                        Popup</a>

                    <div class="p-2"></div>

                    <form method="post" action="{{ route('user.requestlogs.store') }}" id="requestlogform">
                        @csrf
                        @method('POST')

                        <input type="hidden" name="workorder_id" value="{{ $workorder->W_WorkOrder }}">

                        <x-form.select name="request_type" label="Request Type" id="request_type" :options="Helper::requesttypes()"
                            empty="-" required />
                        <br />

                        <x-form.textarea name="notes" label="Notes" :value="old('notes')" :rows="8"
                            minlength="5" required />
                        <br />

                        <br />

                        <button class="btn btn-sm btn-secondary" type="submit">Submit <i
                                class="spin"></i></button>
                    </form>
                @endif
            </div>
        </div>

        <br />

        <a name="bottom"></a>

        <div class="row">
            <div class="col-12 bg-light border py-1 border-secondary bg-warning-subtle">
                <strong>Payment - Dr Fee: ${{ $workorder->W_DrFee }}</strong>
            </div>

            <div class="col-sm-2 border p-1">
                Dr Fee 1
                <br />
                <strong>{{ $workorder->W_DrFee1 }}</strong>
            </div>
            <div class="col-sm-2 border p-1">
                Dr Check Number
                <br />
                <strong>{{ $workorder->W_DrCheckNo }}</strong>
            </div>
            <div class="col-sm-2 border p-1">
                Dr Check Date
                <br />
                <strong>{{ $workorder->W_DrCheckDate?->format('m/d/Y') }}</strong>
            </div>
            <div class="col-sm-2 border p-1">
                Dr Invoice Number
                <br />
                <strong>{{ $workorder->W_DrInvoiceNo }}</strong>
            </div>
            <div class="col-sm-3 border p-1">
                <br />
            </div>
            <div class="col-sm-1 border p-1">

                @if ($hospital && $workorder->W_Status == 'Incomplete')
                    <a href="{{ route('user.workorders.payment', [$workorder->W_WorkOrder, 'dr' => 1]) }}"
                        class="btn btn-xs btn-secondary">Edit</a>
                @endif
                @if ($hospital && $workorder->W_Status != 'Incomplete' && $usersession['contractor']['C_Invoice'])
                    <a href="{{ route('user.workorders.paymentnote', [$workorder->W_WorkOrder, 'dr' => 1]) }}"
                        class="btn btn-xs btn-secondary">Edit Note</a>
                @endif

            </div>

            <div class="col-sm-2 border p-1">
                Dr Fee 2
                <br />
                <strong>{{ $workorder->W_DrFee2 }}</strong>
            </div>
            <div class="col-sm-2 border p-1">
                Dr Check Number 2
                <br />
                <strong>{{ $workorder->W_DrCheckNo2 }}</strong>
            </div>
            <div class="col-sm-2 border p-1">
                Dr Check Date 2
                <br />
                <strong>{{ $workorder->W_DrCheckDate2?->format('m/d/Y') }}</strong>
            </div>
            <div class="col-sm-2 border p-1">
                Dr Invoice Number 2
                <br />
                <strong>{{ $workorder->W_DrInvoiceNo2 }}</strong>
            </div>
            <div class="col-sm-3 border p-1">
                <br />
            </div>
            <div class="col-sm-1 border p-1">

                @if ($hospital && $workorder->W_Status == 'Incomplete')
                    <a href="{{ route('user.workorders.payment', [$workorder->W_WorkOrder, 'dr' => 2]) }}"
                        class="btn btn-xs btn-secondary">Edit</a>
                @endif
                @if ($hospital && $workorder->W_Status != 'Incomplete' && $usersession['contractor']['C_Invoice'])
                    <a href="{{ route('user.workorders.paymentnote', [$workorder->W_WorkOrder, 'dr' => 2]) }}"
                        class="btn btn-xs btn-secondary">Edit Note</a>
                @endif

            </div>
        </div>

        <div class="p-1"></div>

        @if ($subdomain == 'eisdev')

            @if ($hospital)
                <a href="/user/checks?type=envelope&workorder_id={{ $workorder->W_WorkOrder }}" target="_blank"
                    class="btn btn-sm btn-secondary">Envelope Facility PDF</a>
                &nbsp;
                <a href="/user/checks?type=copyservice&workorder_id={{ $workorder->W_WorkOrder }}" target="_blank"
                    class="btn btn-sm btn-secondary">Envelope Copy Service PDF</a>
                &nbsp;
                @if ($hospital && $workorder->W_DrFee1 > 0)
                    <a href="/user/checks?type=check&workorder_id={{ $workorder->W_WorkOrder }}&amount={{ $workorder->W_DrFee1 }}"
                        target="_blank" class="btn btn-sm btn-secondary">Check PDF - Dr Fee 1</a>
                    &nbsp;
                @endif
                @if ($hospital && $workorder->W_DrFee2 > 0)
                    <a href="/user/checks?type=check&workorder_id={{ $workorder->W_WorkOrder }}&amount={{ $workorder->W_DrFee2 }}"
                        target="_blank" class="btn btn-sm btn-secondary">Check PDF - Dr Fee 2</a>
                    &nbsp;
                @endif
            @endif

            <a href="/user/shipments?workorder_id={{ $workorder->W_WorkOrder }}"
                onclick="popup(this.href); return false;" class="btn btn-sm btn-secondary">Shipments NEW</a>
            &nbsp;
            <a href="/user/workorderpayments?workorder_id={{ $workorder->W_WorkOrder }}"
                onclick="popup(this.href); return false;" class="btn btn-sm btn-secondary">Workorder Payments NEW</a>
            &nbsp;
            <a href="/user/bankstatements/?B_Workorder={{ $workorder->W_WorkOrder }}"
                onclick="popup(this.href); return false;" class="btn btn-sm btn-secondary">Check Issued Log</a>

        @endif

        <div class="p-1"></div>

        <div class="row d-print-none p-3 bg-body-secondary">
            <div class="col-4 col-md-2">
                <strong>Shipping Labels</strong>
                <br />
                <a href="/user/shippinglabels/create?W_WorkOrder={{ $workorder->W_WorkOrder }}"
                    class="btn btn-sm btn-secondary">Shipping Labels</a>
                <br />
            </div>
            <div class="col-6 col-md-2">
                <strong>Change History</strong>
                <br />
                <a href="/user/datachanges?search=1&w=1&foreign_key={{ $workorder->W_WorkOrder }}"
                    onclick="popup(this.href); return false;" class="btn btn-sm btn-secondary">Change History</a>
                <br />
            </div>
            <div class="col-6 col-md-2">
                <strong>Email Logs</strong>
                <br />
                <a href="/user/emails?w=1&workorder_id={{ $workorder->W_WorkOrder }}"
                    onclick="popup(this.href); return false;" class="btn btn-sm btn-secondary">Email Logs</a>
                <br />
            </div>
            <div class="col-6 col-md-4">
                <strong>Transfer Assigned To</strong>
                <br />
                <form method="post" action="{{ route('user.workorders.update', $workorder->W_WorkOrder) }}"
                    id="transferassignedtoform">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="W_WorkOrder" value="{{ $workorder->W_WorkOrder }}">
                    <div class="row">
                        <div class="col">
                            <x-form.select name="W_Owner" :options="$contractorsselects" :default="$workorder->W_Owner" empty="-"
                                required />
                        </div>
                        <div class="col">
                            <button class="btn btn-sm btn-secondary submitbutton" type="submit">Submit <i
                                    class="spin"></i></button>
                        </div>
                    </div>
                </form>
                <br />
            </div>
        </div>

        <br />

        <a href="{{ route('user.workorders.duplicate', $workorder->W_WorkOrder) }}"
            class="b1tn btn-sm btn-light">Duplicate workorder</a>

        <div class="p-2"></div>

        @if ($hospital)

            @if ($workorder->W_Owner == '45 DAYS NOTICE')
                <a href="/user/workordernotices/create?workorder_id={{ $workorder->W_WorkOrder }}">45 Day Notice</a>
                <div class="p-2"></div>
            @endif

            @if ($workorder->W_Owner == '25 DAYS NOTICE')
                <a href="/user/workordernotices/create?workorder_id={{ $workorder->W_WorkOrder }}">25 Day Notice</a>
                <div class="p-2"></div>

                {{-- <button
                    class='btn btn-sm btn-secondary'
                    hx-get="/user/workordernotices/create?workorder_id={{ $workorder->W_WorkOrder }}"
                    hx-select="#content"
                    hx-on:click="htmx.toggleClass('#twentyfive', 'd-none')"
                    hx-target="#twentyfive">
                    25 Day Notice - HTMX
                </button> --}}
            @endif

            @if (in_array($workorder->Company_C_Name, ['NORTHWESTERN MUTUAL', 'NORTHWESTERN MUTUAL LTC', 'MASSMUTUAL']))
                <a href="/user/workorderemails/create?workorder_id={{ $workorder->W_WorkOrder }}&type=roadblock&">Roadblock
                    notice email</a>
                <div class="p-2"></div>
            @endif

            <a href="/user/workorderemailsend/create?type=confirmation&workorder_id={{ $workorder->W_WorkOrder }}">Medical
                Records Request Confirmation</a>
            <div class="p-2"></div>

            <a href="/user/workorderemailsend/create?type=follow_up&workorder_id={{ $workorder->W_WorkOrder }}">Medical
                Records Request Follow Up</a>
            <div class="p-2"></div>

        @endif

        @if (in_array($workorder->Company_C_Name, ['NORTHWESTERN MUTUAL', 'NORTHWESTERN MUTUAL LTC']))
            @if ($workorder->Examrequest_E_ApplicantEmail)
                <a href="{{ route('user.addonorders.create', ['workorder_id' => $workorder->W_WorkOrder]) }}">Create
                    Addon Order</a>
            @else
                Create Addon Order: <span class="text-danger">Applicant Email is Required</span>
            @endif
            <div class="p-2"></div>
        @endif

        @php
            $feeapprovals = [
                'GUARDIAN BERKSHIRE' => 'DIFeeApproval@glic.com',
                'GUARDIAN INDIVIDUAL LIFE' => 'Guardian_uw_vmo@glic.com',
                'JOHN HANCOCK' => 'medfees@jhancock.com',
                'MUTUAL OF OMAHA' => 'statuslines@mutualofomaha.com',
            ];
            $recipient = $feeapprovals[$workorder->W_BillCompany] ?? ($feeapprovals[$workorder->W_InsCompany] ?? null);
        @endphp

        @if ($recipient)
            <a
                href="{{ route('user.emails.create', ['email_type' => 'fee_approval', 'workorder_id' => $workorder->W_WorkOrder, 'recipient' => $recipient]) }}">Fee
                Approval Email</a>
            <div class="p-2"></div>
        @endif

        @if ($subdomain == 'eisdev')
            <a href="#" id="" data-bs-toggle="modal" data-bs-target="#modal"
                onclick="showModal('{{ route('user.synodextransmissions.index', ['WorkOrderID' => $workorder->W_WorkOrder]) }}')">Synodex
                Transmissions</a>
            <div class="p-2"></div>
        @endif

        <a hx-get="{{ route('user.synodextransmissions.acordreferenceid', ['WorkOrderID' => $workorder->W_WorkOrder]) }}"
            hx-target="#synodextransmission" href="#">Synodex Transmission Acord Reference ID</a>
        <div id="synodextransmission" class="fw-bold"></div>
        <div class="p-2"></div>

        <div class="text-end">
            <a href="#top" class="btn btn-sm btn-secondary"><i class="fa-solid fa-angles-up"></i></a>
        </div>

    </div>

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            workorder
            @php dump(@$workorder); @endphp
            hospital
            @php dump(@$hospital); @endphp
        </div>
    @endif

    <script type="module">
        const {
            createApp,
            ref
        } = Vue

        createApp({

            setup() {

                const R_WorkOrder = ref(null);
                const infowindow = ref(false);
                const infowindowlabel = ref(false);
                const copyservice = ref({});
                const roi = ref({});
                const hospitalraw = ref({});

                function infowindowspin() {
                    this.infowindow = '<i class="fas fa-sync fa-spin"></i>';
                }

                function getCopyservice(H_ID) {
                    this.infowindowspin();
                    const res = fetch('/api/copyservices/show?C_CopyService=' + encodeURIComponent(H_ID))
                        .then(response => response.json())
                        .then(data => {
                            if (data) {
                                console.log(data);
                                this.copyservice = data;
                                this.infowindowlabel = 'Copy Service';
                                this.infowindow = "Copy Service: <strong>" + this.copyservice.C_CopyService +
                                    "</strong><br />" +
                                    "Address: " + this.copyservice.C_Address + "<br />" +
                                    "City: " + this.copyservice.C_City + "<br />" +
                                    "State: " + this.copyservice.C_State + "<br />" +
                                    "Zip: " + this.copyservice.C_Zip + "<br />" +
                                    "Phone: " + this.copyservice.C_Phone + "<br />" +
                                    "PhoneExt: " + this.copyservice.C_PhoneExt + "<br />" +
                                    "Fax: " + this.copyservice.C_Fax + "<br />" +
                                    "Note: " + this.copyservice.C_Note_br + "<br />";
                            } else {
                                this.infowindowlabel = 'Copy Service';
                                this.infowindow = '<span class="text-danger">not found</span>';
                            }
                        })
                        .catch(error => {
                            console.error("There was an error! ", error)
                        });
                }

                function getRoi(H_ID) {
                    this.infowindowspin();
                    const res = fetch('/api/rois/show?R_ROIname=' + H_ID)
                        .then(response => response.json())
                        .then(data => {
                            if (data) {
                                console.log(data);
                                this.roi = data;
                                this.infowindowlabel = 'ROI';
                                this.infowindow = "ROI: <strong>" + this.roi.R_ROIname + "</strong><br />" +
                                    "State: " + this.roi.R_State + "<br />" +
                                    "Zip: " + this.roi.R_Zip + "<br />" +
                                    "Phone: " + this.roi.R_Phone + "<br />" +
                                    "PhoneExt: " + this.roi.R_PhoneExt + "<br />" +
                                    "Fax: " + this.roi.R_Fax + "<br />" +
                                    "Note: " + this.roi.R_Note_br + "<br />";
                            } else {
                                this.infowindowlabel = 'ROI';
                                this.infowindow = '<span class="text-danger">not found</span>';
                            }
                        })
                        .catch(error => {
                            console.error("There was an error! ", error)
                        });
                }

                function getHospitalraw(R_WorkOrder) {
                    this.infowindowspin();
                    try {
                        const res = fetch('/api/hospitalraws/' + R_WorkOrder)
                            .then(response => response.json())
                            .then(data => {
                                if (data) {
                                    this.hospitalraw = data;
                                    this.infowindowlabel = 'Facility Raw';
                                    this.infowindow = "Facility Raw: <strong>" + this.hospitalraw.R_Hospital +
                                        "</strong><br />" +
                                        "Dr First Name: " + this.hospitalraw.R_DrFirstName + "<br />" +
                                        "Dr Last Name: " + this.hospitalraw.R_DrLastName + "<br />" +
                                        "City: " + this.hospitalraw.R_City + "<br />" +
                                        "Address: " + this.hospitalraw.R_Address + "<br />" +
                                        "State: " + this.hospitalraw.R_State + "<br />" +
                                        "Zip: " + this.hospitalraw.R_Zip + "<br />" +
                                        "Phone: " + this.hospitalraw.R_Phone + "<br />" +
                                        "PhoneExt: " + this.hospitalraw.R_PhoneExt + "<br />" +
                                        "Fax: " + this.hospitalraw.R_Fax + "<br />";
                                } else {
                                    this.infowindowlabel = 'Hospital Raw';
                                    this.infowindow = '<span class="text-danger">not found</span>';
                                }
                            })
                            .catch(error => {
                                console.error("There was an error! ", error)
                            });
                    } catch (error) {
                        console.error("There was an error! ", error)
                    }
                }

                function infowindowhide() {
                    this.infowindowlabel = false;
                    this.infowindow = false;
                }

                return {
                    R_WorkOrder,
                    infowindow,
                    infowindowlabel,
                    copyservice,
                    roi,
                    hospitalraw,
                    infowindowhide,
                    infowindowspin,
                    getCopyservice,
                    getRoi,
                    getHospitalraw,
                }

            }

        }).mount('#app');
    </script>

</x-user-layout>
