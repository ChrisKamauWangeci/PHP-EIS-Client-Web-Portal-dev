<x-user-layout title="">

    <style>
        .prewrap {
            white-space: pre-wrap;
        }
    </style>

    <div id="app"
         v-cloak>

        <div class="row">
            <div class="col-auto">
                <h1>Workorder: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }}
                    {{ $workorder->W_LastName }}</h1>
            </div>
            <div class="col text-end">
                <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}"
                   class="btn btn-sm btn-secondary">View Workorder</a>
            </div>
        </div>

        <br />

        @if ($hospitalcurrent)
            <div class="row">
                <div class="col-auto">
                    Current Facility / Hospital:
                    <br />
                    <strong>{{ $workorder->W_Hospital }}</strong>
                    <br />
                    <br />
                </div>
                <div class="col-auto">
                    Hospital 2:
                    <br />
                    <strong>{{ $workorder->W_Hospital2 }}</strong>
                    <br />
                    <br />
                </div>
                <div class="col-auto">
                    {{ $hospitalcurrent->H_Address }}
                    <br />
                    {{ $hospitalcurrent->H_City }},
                    {{ $hospitalcurrent->H_State }}
                    {{ $hospitalcurrent->H_Zip }}
                    <br />
                </div>
                <div class="col-auto">
                    {{ $hospitalcurrent->H_Phone }}, ext: {{ $hospitalcurrent->H_PhoneExt }} (phone)
                    <br />
                    {{ $hospitalcurrent->H_Fax }} (fax)
                    <br />
                </div>
                <div class="col-auto">
                    <a href="{{ route('user.hospitals.edit', $hospitalcurrent->H_ID) }}"
                       class="btn btn-sm btn-secondary">Edit Hospital</a>
                    <br />
                </div>
            </div>
        @endif

        <hr>

        <div class="row">
            <div class="col-auto">
                <h3>Search Facility</h3>
            </div>
            <div class="col text-end">
                <a href="/user/hospitals/create"
                   onclick="popup(this.href); return false;">Create New Hospital</a>
            </div>
        </div>

        <div class="row">

            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                Hospital <span v-if="search.H_Hospital"
                      @click="resetfield('H_Hospital')"><i class="fa-solid fa-xmark"></i></span>
                <br />
                <input type="text"
                       name="H_Hospital"
                       v-model="search.H_Hospital"
                       v-on:change="searchHospitals();"
                       class="form-control form-control-sm"
                       autocomplete="off">
                <br />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                Address <span v-if="search.H_Address"
                      @click="resetfield('H_Address')"><i class="fa-solid fa-xmark"></i></span>
                <br />
                <input type="text"
                       name="H_Address"
                       v-model="search.H_Address"
                       v-on:change="searchHospitals();"
                       class="form-control form-control-sm"
                       autocomplete="off">
                <br />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                City <span v-if="search.H_City"
                      @click="resetfield('H_City')"><i class="fa-solid fa-xmark"></i></span>
                <br />
                <input type="text"
                       name="H_City"
                       v-model="search.H_City"
                       v-on:change="searchHospitals();"
                       class="form-control form-control-sm"
                       autocomplete="off">
                <br />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-1">
                State <span v-if="search.H_State"
                      @click="resetfield('H_State')"><i class="fa-solid fa-xmark"></i></span>
                <br />
                <input type="text"
                       name="H_State"
                       v-model="search.H_State"
                       v-on:change="searchHospitals();"
                       class="form-control form-control-sm"
                       autocomplete="off"
                       maxlength="2">
                <br />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-1">
                Zip <span v-if="search.H_Zip"
                      @click="resetfield('H_Zip')"><i class="fa-solid fa-xmark"></i></span>
                <br />
                <input type="text"
                       name="H_Zip"
                       v-model="search.H_Zip"
                       v-on:change="searchHospitals();"
                       class="form-control form-control-sm"
                       autocomplete="off">
                <br />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-1">
                Phone <span v-if="search.H_Phone"
                      @click="resetfield('H_Phone')"><i class="fa-solid fa-xmark"></i></span>
                <br />
                <input type="text"
                       name="H_Phone"
                       v-model="search.H_Phone"
                       v-on:change="searchHospitals();"
                       class="form-control form-control-sm"
                       autocomplete="off">
                <br />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-1">
                Fax <span v-if="search.H_Fax"
                      @click="resetfield('H_Fax')"><i class="fa-solid fa-xmark"></i></span>
                <br />
                <input type="text"
                       name="H_Fax"
                       v-model="search.H_Fax"
                       v-on:change="searchHospitals();"
                       class="form-control form-control-sm"
                       autocomplete="off">
                <br />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <label>Action</label>
                <br />
                <button class="btn btn-sm btn-secondary"
                        type="submit"
                        id="search"
                        v-on:click="searchHospitals();">
                    <span v-if="searching">
                        <i class="fas fa-sync-alt fa-spin"></i>
                    </span>
                    <span v-if="!searching">
                        <i class="fas fa-search"></i>
                    </span>
                    Search
                </button> <button class="btn btn-sm btn-secondary"
                        type="submit"
                        id="reset"
                        v-on:click="reset();">Reset</button>
                <br />
            </div>

        </div>

        <span v-if="searching">
            <div>
                <i class="fas fa-sync-alt fa-spin"></i>
            </div>
        </span>

        <div class="table-responsive"
             v-if="hospitals">
            <table class="table table-sm table-hover table-bordered w-auto">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th @click="sort('H_Hospital')">Facility / Hospital</th>
                        <th @click="sort('H_Address')">Address</th>
                        <th @click="sort('H_Phone')">Phone</th>
                        <th @click="sort('H_Fax')">Fax</th>
                        <th @click="sort('H_UpdUser')">Updated</th>
                        <th @click="sort('H_UpdDate')">Updated</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="h in sortedHospitals">
                        <td>@{{ h.H_ID }}</td>
                        <td>
                            <div data-bs-toggle="tooltip"
                                 data-bs-placement="top"
                                 data-bs-html="true"
                                 :data-bs-title="'hospital: ' + h.H_Hospital + '<br />affiliate: ' + h.H_Affiliate +
                                     '<br />copyservice: ' + h.H_CopyService + '<br />contact: ' + h.H_ContactName">
                                @{{ h.H_Hospital }}
                            </div>
                        </td>
                        <td>@{{ h.H_Address }}, @{{ h.H_City }}, @{{ h.H_State }}
                            @{{ h.H_Zip }}</td>
                        <td>@{{ h.H_Phone }}</td>
                        <td>@{{ h.H_Fax }}</td>
                        <td class="small">@{{ h.H_UpdUser }}</td>
                        <td class="small"
                            nowrap>@{{ h.H_UpdDate }}</td>
                        <td nowrap>
                            <button class="btn btn-xs btn-success"
                                    v-on:click="getHospital(h.H_ID);">Select</button>&nbsp;
                            <a :href="'/user/hospitals/' + h.H_ID"
                               target="_blank"
                               class="btn btn-xs btn-secondary">View</a>
                            <a :href="'/user/hospitals/' + h.H_ID"
                               target="_blank"
                               class="btn btn-xs btn-secondary">Edit</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <small>sort=@{{ currentSort }}, dir=@{{ currentSortDir }}</small>

        <br />
        <span id="ready"></span>

        <hr>

        <div class="row">

            <div class="col-12 col-md-6">
                <h3>Change Facility</h3>

                @if ($workorder->W_Status == 'Incomplete')

                    <form method="post"
                          action="{{ route('user.workorders.workorderhospitalupdate', $workorder->W_WorkOrder) }}">
                        @csrf
                        @method('PATCH')

                        <input type="hidden"
                               name="W_WorkOrder"
                               value="{{ $workorder->W_WorkOrder }}">

                        <x-form.input name="H_ID"
                                      label="Hospital ID"
                                      :value="old('H_ID')"
                                      class="form-control form-control-sm readonly bg-light"
                                      readonly
                                      style="pointer-events: none;"
                                      required />
                        <br />

                        <x-form.input name="hospital_name"
                                      label="Hospital"
                                      :value="old('hospital_name')"
                                      maxlength="50"
                                      required />
                        <br />

                        @if (!$workorder->W_Owner)
                            <x-form.select name="W_Owner"
                                           label="Transfer Assigned To"
                                           :options="$contractorsselects"
                                           empty="-"
                                           :value="old('W_Owner')"
                                           required />
                            <br />
                        @endif

                        Address: @{{ hospitaladdress }}
                        <br />
                        City: @{{ hospitalcity }}
                        <br />
                        State: @{{ hospitalstate }}
                        <br />
                        Zip: @{{ hospitalzip }}
                        <br />
                        Phone: @{{ hospitalphone }}
                        <br />
                        Phone Ext: @{{ hospitalphoneext }}
                        <br />
                        Fax: @{{ hospitalfax }}
                        <br />
                        <br />

                        <x-form.button>Submit</x-form.button>
                        &nbsp;
                        <a href="#"
                           @click="resethospital()"
                           class="btn btn-sm btn-secondary">Reset</a>

                        <br />
                        <br />
                        Note:
                        <div class="prewrap bg-light p-2">@{{ hospitalnote }}</div>
                        <br />

                    </form>
                    <br />
                    <br />
                @else
                    Workorder status is: {{ $workorder->W_Status }}
                @endif

            </div>

            <div class="col-12 col-md-6">

                <h3>Requestor Note</h3>
                {{ $workorder->W_RequestorNote }}
                <br />
                <br />

                @if ($hospitalraw && $workorder->W_WebUploadID)
                    <h3>Save New Facility</h3>
                    <form method="post"
                          action="{{ route('user.workorders.workorderhospitalstore') }}">
                        @csrf
                        @method('PATCH')

                        <input type="hidden"
                               name="W_WorkOrder"
                               value="{{ $workorder->W_WorkOrder }}">

                        <span @click="copyRawHospital('H_Hospital');">Hospital <i class="fas fa-search"></i></span>
                        <x-form.input name="H_Hospital"
                                      :value="old('H_Hospital', $hospitalraw->R_Hospital)"
                                      maxlength="50"
                                      required />

                        <br />

                        <span @click="copyRawHospital('H_Address');">Address <i class="fas fa-search"></i></span>
                        <x-form.input name="H_Address"
                                      :value="old('H_Address', $hospitalraw->R_Address)"
                                      maxlength="50" />

                        <br />

                        <div class="row">
                            <div class="col-4 col-md-6">
                                <span @click="copyRawHospital('H_City');">City <i class="fas fa-search"></i></span>
                                <x-form.input name="H_City"
                                              :value="old('H_City', $hospitalraw->R_City)"
                                              maxlength="50" />
                                <br />
                            </div>
                            <div class="col-4 col-md-3">
                                <span @click="copyRawHospital('H_State');">State <i class="fas fa-search"></i></span>
                                <x-form.input name="H_State"
                                              :value="old('H_State', $hospitalraw->R_State)"
                                              maxlength="2" />
                                <br />
                            </div>
                            <div class="col-4 col-md-3">
                                <span @click="copyRawHospital('H_Zip');">Zip <i class="fas fa-search"></i></span>
                                <x-form.input name="H_Zip"
                                              :value="old('H_Zip', $hospitalraw->R_Zip)"
                                              maxlength="50" />
                                <br />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-5">
                                <span @click="copyRawHospital('H_Phone');">Phone <i class="fas fa-search"></i></span>
                                <x-form.input name="H_Phone"
                                              :value="old('H_Phone', $hospitalraw->R_Phone)"
                                              maxlength="50" />
                                <br />
                            </div>
                            <div class="col-4 col-md-4 col-lg-3">
                                Phone Ext
                                <x-form.input name="H_PhoneExt"
                                              :value="old('H_PhoneExt', $hospitalraw->R_PhoneExt)"
                                              maxlength="50" />
                                <br />
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <span @click="copyRawHospital('H_Fax');">Fax <i class="fas fa-search"></i></span>
                                <x-form.input name="H_Fax"
                                              :value="old('H_Fax', $hospitalraw->R_Fax)"
                                              maxlength="50" />
                                <br />
                            </div>
                        </div>

                        <x-form.textarea name="H_Note"
                                         label="Note"
                                         :value="old('H_Note', $workorder->H_Note)"
                                         :rows="4" />
                        <br />

                        <x-form.button>Submit</x-form.button>
                        &nbsp;
                        <a href="{{ route('user.workorders.hospitalchange', $workorder->W_WorkOrder) }}"
                           class="btn btn-sm btn-secondary">Reset</a>
                    </form>
                    <br />
                    <br />
                @endif
            </div>

        </div>

    </div>

    <script>
        // $(document).ready(function() {
        //     $(".readonly").keydown(function(e) {
        //         e.preventDefault();
        //     });
        // });
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".readonly").forEach(function(element) {
                element.addEventListener("keydown", function(e) {
                    e.preventDefault();
                });
            });
        });

        function popup(url) {
            window.open(url, "popup", "scrollbars=yes,width=1280,height=800,resizable=yes,left=50,top=50")
        }
    </script>

    <script>
        let app = Vue.createApp({
            data() {
                return {
                    searching: false,
                    search: {
                        H_Hospital: '',
                        H_Address: '',
                        H_City: '',
                        H_State: '',
                        H_Zip: '',
                        H_Phone: '',
                        H_Fax: '',
                    },
                    hospitals: null,
                    hospitaladdress: '',
                    hospitalcity: '',
                    hospitalstate: '',
                    hospitalzip: '',
                    hospitalphone: '',
                    hospitalphoneext: '',
                    hospitalfax: '',
                    hospitalnote: '',
                    currentSort: 'H_Hospital',
                    currentSortDir: 'asc',
                }
            },
            computed: {
                sortedHospitals: function() {
                    return this.hospitals.sort((a, b) => {
                        let modifier = 1;
                        if (this.currentSortDir === 'desc') modifier = -1;
                        if (a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
                        if (a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
                        return 0;
                    });
                }
            },
            methods: {
                sort: function(s) {
                    if (s === this.currentSort) {
                        this.currentSortDir = this.currentSortDir === 'asc' ? 'desc' : 'asc';
                    }
                    this.currentSort = s;
                },
                resethospital() {
                    this.hospitaladdress = '';
                    this.hospitalcity = '';
                    this.hospitalstate = '';
                    this.hospitalzip = '';
                    this.hospitalphone = '';
                    this.hospitalphoneext = '';
                    this.hospitalfax = '';
                    this.hospitalnote = '';
                },
                resetfield(field) {
                    this.search[field] = '';
                    this.hospitals = null;
                    this.searchHospitals();
                },
                reset() {
                    this.search = {
                        H_Hospital: '',
                        H_Address: '',
                        H_City: '',
                        H_State: '',
                        H_Zip: '',
                        H_Phone: '',
                        H_Fax: '',
                    };
                    this.hospitals = null;
                },
                searchHospitals() {

                    this.hospitals = null;

                    const emptySearch = Object.values(this.search).every(x => x === null || x === '');
                    if (emptySearch) {
                        return;
                    }

                    this.searching = true;
                    const res = fetch(
                            '/api/hospitals?' +
                            '&H_Hospital=' + this.search.H_Hospital.trim() +
                            '&H_Address=' + this.search.H_Address.trim() +
                            '&H_City=' + this.search.H_City.trim() +
                            '&H_State=' + this.search.H_State.trim() +
                            '&H_Zip=' + this.search.H_Zip.trim() +
                            '&H_Phone=' + this.search.H_Phone.trim() +
                            '&H_Fax=' + this.search.H_Fax.trim()
                        )
                        .then(response => response.json())
                        .then(data => {
                            this.hospitals = data;
                            this.searching = false;

                            this.$nextTick(() => {
                                const tooltipTriggerList = document.querySelectorAll(
                                    '[data-bs-toggle="tooltip"]')
                                const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl =>
                                    new bootstrap.Tooltip(tooltipTriggerEl))
                            });
                        })
                        .catch(error => {
                            console.error("There was an error! ", error)
                        });
                },
                getHospital: function(H_ID) {
                    const res = fetch('/api/hospitals/' + encodeURIComponent(H_ID))
                        .then(response => response.json())
                        .then(data => {
                            // console.log(data);
                            document.getElementById('H_ID').value = data.H_ID;
                            document.getElementById('hospital_name').value = data.H_Hospital;
                            this.hospitaladdress = data.H_Address;
                            this.hospitalcity = data.H_City;
                            this.hospitalstate = data.H_State;
                            this.hospitalzip = data.H_Zip;
                            this.hospitalphone = data.H_Phone;
                            this.hospitalphoneext = data.H_PhoneExt;
                            this.hospitalfax = data.H_Fax;
                            // this.hospitalnote = nl2br(data.H_Note);
                            this.hospitalnote = data.H_Note;
                            document.querySelector('#ready').scrollIntoView({
                                behavior: "smooth"
                            });
                        })
                        .catch(error => {
                            console.error("There was an error! ", error)
                        });
                },
                copyRawHospital: function(from) {
                    if (from == 'H_Hospital') {
                        this.search.H_Hospital = document.getElementById('H_Hospital').value;
                    }
                    if (from == 'H_Address') {
                        this.search.H_Address = document.getElementById('H_Address').value;
                    }
                    if (from == 'H_City') {
                        this.search.H_City = document.getElementById('H_City').value;
                    }
                    if (from == 'H_State') {
                        this.search.H_State = document.getElementById('H_State').value;
                    }
                    if (from == 'H_Zip') {
                        this.search.H_Zip = document.getElementById('H_Zip').value;
                    }
                    if (from == 'H_Phone') {
                        this.search.H_Phone = document.getElementById('H_Phone').value;
                    }
                    if (from == 'H_Fax') {
                        this.search.H_Fax = document.getElementById('H_Fax').value;
                    }
                    this.searchHospitals();
                }
            }
        });

        app.mount('#app');
    </script>

</x-user-layout>
