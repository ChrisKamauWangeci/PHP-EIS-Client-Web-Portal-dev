<x-user-layout title="">

    <script>
        function popup(url) {
            window.open(url, "popup1", "scrollbars=yes,width=1280,height=800,resizable=yes,left=50,top=50")
        }
    </script>

    <div id="app"
         v-cloak>

        <script>
            // window.onunload = refreshParent;
            function refreshCloseWindow() {
                window.opener.location.reload();
                self.close();
            }
        </script>

        <div class="row">
            <div class="col">
                <h1>Hospital: {{ $hospital->H_Hospital }}</h1>
            </div>
            <div class="col-auto text-end">
                <a href="/user/hospitals/{{ $hospital->H_ID }}/edit"
                   onclick="popup(this.href); return false;"
                   class="btn btn-sm btn-secondary">Edit</a>
                &nbsp;
                <button type="button"
                        class="btn btn-sm btn-secondary"
                        onclick="refreshCloseWindow()">Close Window</button>
            </div>
        </div>

        <br />
        <br />

        <h5>Related workorders and facilities</h5>

        <button class="btn btn-xs btn-secondary"
                type="submit"
                id="search"
                @click="relatedworkorderssearch('workordername');">Related workorders with matching name</button>

        @if ($hospital->H_Phone)
            &nbsp;
            <button class="btn btn-xs btn-secondary"
                    type="submit"
                    id="search"
                    @click="relatedworkorderssearch('hospitalphone');">Related facilities with matching phone</button>
        @endif

        @if ($hospital->H_Fax)
            &nbsp;
            <button class="btn btn-xs btn-secondary"
                    type="submit"
                    id="search"
                    @click="relatedworkorderssearch('hospitalfax');">Related facilities with matching fax</button>
        @endif

        <br />
        <br />

        <div class="loading"
             v-if="relatedworkordersloading">
            <i class="fas fa-sync-alt fa-spin"></i>
        </div>

        <div class="table-responsive"
             v-if="relatedworkordersdiv">
            <table class="table table-sm table-bordered w-auto">
                <thead>
                    <tr>
                        <th>WO</th>
                        <th>Applicant First Name</th>
                        <th>Applicant Last Name</th>
                        <th>Authorized File</th>
                        <th>Hospital</th>
                        <th>Status</th>
                        <th>Received</th>
                        <th>Last Updated</th>
                        <th>Completed</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(relatedworkorder, index) in relatedworkorders"
                        :class="{ 'bg-primary': (relatedworkorder == this.workorder) }">
                        <td>@{{ relatedworkorder.W_WorkOrder }}</td>
                        <td>@{{ relatedworkorder.W_FirstName }}</td>
                        <td>@{{ relatedworkorder.W_LastName }}</td>
                        <td>@{{ relatedworkorder.W_AuthorizedFile }}</td>
                        <td>@{{ relatedworkorder.W_Hospital }}</td>
                        <td>@{{ relatedworkorder.W_Status }}</td>
                        <td>@{{ relatedworkorder.W_ReceiveDate }}</td>
                        <td>@{{ relatedworkorder.W_UpdDate }}</td>
                        <td>@{{ relatedworkorder.W_CompletedDate }}</td>
                        <td nowrap>
                            <button class="btn btn-xs btn-success"
                                    :class="{ 'bg-primary': (relatedworkorder == this.workorder) }"
                                    v-on:click="workordershow(index);"
                                    v-on:mouseover="workordershow(index);">Details</button>
                            &nbsp;
                            <a :href="'/user/workorders/' + relatedworkorder.W_WorkOrder"
                               target="_blank"
                               class="btn btn-xs btn-secondary">Workorder</a>
                            &nbsp;
                            <a :href="'/user/hospitals/' + relatedworkorder.H_ID"
                               target="_blank"
                               class="btn btn-xs btn-secondary">View Hospital</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="p-3"
             v-if="relatedworkordershow">

            <div class="row">
                <div class="col-3 col-md-2 border px-1">
                    Workorder
                    <br />
                    <strong>@{{ workorder.W_WorkOrder }}</strong>
                </div>
                <div class="col-3 col-md-3 border px-1">
                    Insurance Company
                    <br />
                    <strong>@{{ workorder.W_InsCompany }}</strong>
                </div>
                <div class="col-3 col-md-1 border px-1">
                    Urgent
                    <br />
                    <strong>@{{ workorder.W_Urgent }}</strong>
                </div>
                <div class="col-3 col-md-3 border px-1">
                    Requestor
                    <br />
                    <strong>@{{ workorder.W_Requestor }}</strong>
                </div>
                <div class="col-3 col-md-3 border px-1">
                    Contractor
                    <br />
                    <strong>@{{ workorder.W_Contractor }}</strong>
                </div>
                <div class="col-3 col-md-2 border px-1">
                    Assigned to
                    <br />
                    <strong>@{{ workorder.W_Owner }}</strong>
                </div>
                <div class="col-3 col-md-2 border px-1">
                    Agent
                    <br />
                    <strong>@{{ workorder.W_Agent }}</strong>
                </div>
                <div class="col-3 col-md-2 border px-1">
                    Case #
                    <br />
                    <strong>@{{ workorder.W_PolicyNo }}</strong>
                </div>
                <div class="col-3 col-md-2 border px-1">
                    Policy #
                    <br />
                    <strong>@{{ workorder.W_InsPolicy }}</strong>
                </div>
                <div class="col-3 col-md-2 border px-1">
                    Record #
                    <br />
                    <strong>@{{ workorder.W_RecordNo }}</strong>
                </div>
                <div class="col-3 col-md-2 border px-1">
                    EHR WO #
                    <br />
                    <strong>@{{ workorder.W_TransNo }}</strong>
                </div>
                <div class="col-3 col-md-2 border px-1">
                    Number of Files
                    <br />
                    <strong>@{{ workorder.W_NoFiles }}</strong>
                </div>
                <div class="col-3 col-md-2 border px-1">
                    Number of Pages
                    <br />
                    <strong>@{{ workorder.W_ImagePages }}</strong>
                </div>
                <div class="col-3 col-md-2 border px-1">
                    Shipping Fee 1
                    <br />
                    <strong>@{{ workorder.W_ShipFee1 }}</strong>
                </div>
                <div class="col-3 col-md-2 border px-1">
                    Tracking 1
                    <br />
                    <strong>@{{ workorder.W_Tracking1 }}</strong>
                </div>
                <div class="col-3 col-md-2 border px-1">
                    Shipping Fee 2
                    <br />
                    <strong>@{{ workorder.W_ShipFee2 }}</strong>
                </div>
                <div class="col-3 col-md-2 border px-1">
                    Tracking 2
                    <br />
                    <strong>@{{ workorder.W_Tracking2 }}</strong>
                </div>
                <div class="col-3 col-md-2 border px-1">
                    Contractor Fee
                    <br />
                    <strong>@{{ workorder.W_ContractorFee }}</strong>
                </div>
                <div class="col-3 col-md-2 border px-1">
                    Received Date
                    <br />
                    <strong>@{{ workorder.W_ReceiveDate }}</strong>
                </div>
                <div class="col-3 col-md-2 border px-1">
                    Updated Date
                    <br />
                    <strong>@{{ workorder.W_UpdDate }}</strong>
                </div>
                <div class="col-3 col-md-2 border px-1">
                    Updated By
                    <br />
                    <strong>@{{ workorder.W_UpdUser }}</strong>
                </div>
                <div class="col-3 col-md-2 border px-1">
                    Follow up Date
                    <br />
                    <strong>@{{ workorder.W_FollowUpDt }}</strong>
                </div>
                <div class="col-3 col-md-2 border px-1">
                    Completed Date
                    <br />
                    <strong>@{{ workorder.W_CompletedDate }}</strong>
                </div>
            </div>

            <div class="row">
                <div class="col-4 col-md-3 border px-1">
                    Applicant First Name
                    <br />
                    <strong>@{{ workorder.W_FirstName }}</strong>
                </div>
                <div class="col-4 col-md-2 border px-1">
                    Applicant Middle Initial
                    <br />
                    <strong>@{{ workorder.W_MiddleInit }}</strong>
                </div>
                <div class="col-4 col-md-3 border px-1">
                    Applicant Last Name
                    <br />
                    <strong>@{{ workorder.W_LastName }}</strong>
                </div>
                <div class="col-6 col-md-2 border px-1">
                    Applicant Date of Birth
                    <br />
                    <strong>@{{ workorder.W_DOB }}</strong>
                </div>
                <div class="col-6 col-md-2 border px-1">
                    Applicant Social Security
                    <br />
                    <strong>@{{ workorder.W_SS }}</strong>
                </div>
            </div>

            <div class="p-1"></div>

            <div class="row">
                <div class="col-12 col-sm-4 border p-2">
                    <strong>Workorder Note</strong>
                    <br />
                    @{{ workorder.W_Note2 }}
                </div>
                <div class="col-12 col-sm-4 border p-2">
                    <strong>Requestor Note</strong>
                    <br />
                    @{{ workorder.W_RequestorNote }}
                </div>
                <div class="col-12 col-sm-4 border p-2">
                    <strong>Follow-Up Note</strong>
                    <br />
                    @{{ workorder.W_Note3 }}
                </div>
            </div>

            <div class="p-1"></div>

            <div class="row">
                <div class="col-12 col-sm-6 border p-2">
                    <strong>Status Note</strong>
                    <textarea rows="11"
                              readonly
                              class="form-control form-control-sm">@{{ workorder.W_Note }}</textarea>
                </div>
                <div class="col-12 col-sm-6 border p-2">
                    <strong>Follow-Up Status</strong>
                    <textarea rows="11"
                              readonly
                              class="form-control form-control-sm">@{{ workorder.W_FollowUpStatus }}</textarea>
                </div>
            </div>

        </div>

        <div class="alert alert-danger"
             v-if="relatedworkordershowerror">
            @{{ relatedworkordershowerrormessage }}
        </div>

        <br />
        <br />

    </div>

    <script type="module">
        const {
            createApp,
            ref
        } = Vue

        createApp({

            setup() {

                const relatedworkorders = ref({});
                const workorder = ref({});
                const domain = ref('<?= $subdomain ?>');
                const relatedworkordersdiv = ref(false);
                const relatedworkordersloading = ref(false);
                const relatedworkordershow = ref(false);
                const relatedworkordershowerror = ref(false);
                const relatedworkordershowerrormessage = ref('not found');

                function relatedworkorderssearch(type = null) {

                    var searchterm = null;

                    if (type == "workordername") {
                        searchterm =
                            "condition=workordername&W_FirstName=<?= addslashes($workorder->W_FirstName) ?? null ?>&W_LastName=<?= addslashes($workorder->W_LastName) ?? null ?>";
                    }
                    if (type == "hospitalphone") {
                        searchterm = "condition=hospitalphone&H_Phone=" + "<?= $hospital->H_Phone ?? null ?>";
                    }
                    if (type == "hospitalfax") {
                        searchterm = "condition=hospitalfax&H_Fax=" + "<?= $hospital->H_Fax ?? null ?>";
                    }

                    this.relatedworkordersdiv = false;
                    this.relatedworkordershow = false;
                    this.relatedworkordersloading = true;

                    const options = {
                        method: "GET",
                        headers: {
                            "Accept": "application/json",
                            "Content-Type": "application/json",

                        },
                    };

                    const res = fetch(
                            '/api/workorders/related?search=1&' + searchterm, options)
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            this.relatedworkorders = data.data;
                            console.log(this.relatedworkorders);
                            this.relatedworkordersloading = false;
                            this.relatedworkordersdiv = true;
                            // Vue.nextTick(() => {
                            //     // Initialize Bootstrap 5 tooltips
                            //     const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                            //     tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                            //         new bootstrap.Tooltip(tooltipTriggerEl);
                            //     });
                            // });
                        })
                        .catch(error => {
                            console.error("There was an error! ", error)
                        });
                }

                function workordershow(index) {
                    this.workorder = this.relatedworkorders[index];
                    console.log(this.workorder);
                    this.relatedworkordershow = true;
                }

                return {
                    relatedworkorders,
                    workorder,
                    domain,
                    relatedworkordersdiv,
                    relatedworkordersloading,
                    relatedworkordershow,
                    relatedworkordershowerror,
                    relatedworkordershowerrormessage,
                    relatedworkorderssearch,
                    workordershow,
                }

            }

        }).mount('#app');
    </script>

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            workorder
            @php dump(@$workorder) @endphp
            hospital
            @php dump(@$hospital) @endphp
        </div>
    @endif

</x-user-layout>
