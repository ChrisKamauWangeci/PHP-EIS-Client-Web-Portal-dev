<x-user-layout title="">

    <div id="app" v-cloak>

        <div class="row">
            <div class="col">
                <h1>Add Facility / Hospital</h1>
            </div>
            <div class="col-auto text-end">
                <a href="{{ route('user.hospitals.index') }}" class="btn btn-sm btn-secondary">Hospitals</a>
            </div>
        </div>

        <br />
        <br />

        <form method="post" action="{{ route('user.hospitals.store') }}" id="hospitalform">
            @csrf

            <div class="row">
                <div class="col-sm-3 py-1">
                    <x-form.input name="H_Hospital" label="Hospital" :value="old('H_Hospital')" maxlength="50" required />
                </div>
                <div class="col-sm-3 py-1">
                    <x-form.input name="H_Hospital2" label="Hospital 2" :value="old('H_Hospital2')" maxlength="50" />
                </div>
                <div class="col-sm-3 py-1">
                    <x-form.input name="H_Affiliate" label="Hospital / Affiliate" :value="old('H_Affiliate')" maxlength="50" />
                </div>
                <div class="col-sm-3 py-1">
                    <x-form.input name="H_ContactName" label="Contact Name" :value="old('H_ContactName')" maxlength="50" />
                </div>
                <div class="col-sm-3 py-1">
                    <x-form.input name="H_Address" label="Address" :value="old('H_Address')" maxlength="50" />
                </div>
                <div class="col-sm-3 py-1">
                    <x-form.input name="H_City" label="City" :value="old('H_City')" maxlength="50" />
                </div>
                <div class="col-sm-3 py-1">
                    <x-form.input name="H_State" label="State" :value="old('H_State')" maxlength="2" />
                </div>
                <div class="col-sm-3 py-1">
                    <x-form.input name="H_Zip" label="Zip" :value="old('H_Zip')" maxlength="10" />
                </div>
                <div class="col-sm-3 py-1">
                    <x-form.input name="H_Phone" label="Phone" :value="old('H_Phone')" maxlength="14" />
                </div>
                <div class="col-sm-3 py-1">
                    <x-form.input name="H_PhoneExt" label="Ph Ext" :value="old('H_PhoneExt')" maxlength="5" />
                </div>
                <div class="col-sm-3 py-1">
                    <x-form.input name="H_Fax" label="Fax" :value="old('H_Fax')" maxlength="14" />
                </div>

                <div class="col-sm-3 py-1">
                    @php
                        $options = [
                            0 => 'No',
                            1 => 'Yes',
                        ];
                    @endphp
                    <x-form.select name="H_SpecialAuth" label="Special Auth Form Required" id="H_SpecialAuth" :options="$options" empty="-" :default="old('H_SpecialAuth')" />
                </div>

                <div class="col-sm-3 py-1">
                    @php
                        $options = [
                            0 => 'No',
                            1 => 'Yes',
                        ];
                    @endphp
                    <x-form.select name="H_LOR" label="LOR" id="H_LOR" :options="$options" empty="-" :default="old('H_LOR')" />
                </div>

                <div class="col-sm-3 py-1">
                    @php
                        $options = array_combine(range(1, 50), range(1, 50));
                    @endphp
                    <x-form.select name="H_ResponseTime" label="Response Time (days)" id="H_ResponseTime" :options="$options" empty="-" :default="old('H_ResponseTime')" />
                </div>

                <div class="col-sm-3 py-1">
                    @php
                        $options = array_combine(range(1, 50), range(1, 50));
                    @endphp
                    <x-form.select name="H_TurnOverDays" label="Turnaround (days)" id="H_TurnOverDays" :options="$options" empty="-" :default="old('H_TurnOverDays')" />
                </div>

                <div class="col-sm-3 py-1">
                    @php
                        $options = [
                            1 => 'Fax',
                            2 => 'Fed Ex',
                            3 => 'Mail',
                            4 => 'Hand Serve',
                            5 => 'E-mail',
                        ];
                    @endphp
                    <x-form.select name="H_SendMethod" label="Send Method" id="H_SendMethod" :options="$options" empty="-" :default="old('H_SendMethod')" />
                </div>

                <div class="col-sm-3 py-1">
                    @php
                        $options = [
                            1 => 'Fax',
                            2 => 'Fed Ex',
                            3 => 'Mail',
                        ];
                    @endphp
                    <x-form.select name="H_ReceiveMethod" label="Receive Method" id="H_ReceiveMethod" :options="$options" empty="-" :default="old('H_ReceiveMethod')" />
                </div>

                <div class="col-sm-3 py-1">
                    <x-form.input name="H_SendMethodEmail" label="Send Method Email" :value="old('H_SendMethodEmail')" maxlength="50" />
                </div>

                <div class="col-sm-3 py-1">
                    <x-form.input name="H_ReceiveMethodEmail" label="Receive Method Email" :value="old('H_ReceiveMethodEmail')" maxlength="50" />
                </div>

                <div class="col-sm-3 py-1">
                    @php
                        $options = [
                            1 => 'Doctor',
                            2 => 'Hospital',
                            3 => 'Copy Service',
                        ];
                    @endphp
                    <x-form.select name="H_CheckPayTo" label="Check Pay To" id="H_CheckPayTo" :options="$options" empty="-" :default="old('H_CheckPayTo')" />
                </div>

                <div class="col-sm-3 py-1">
                    @php
                        $options = [
                            0 => 'No',
                            1 => 'Yes',
                        ];
                    @endphp
                    <x-form.select name="H_PayAdvance" label="Pay Advance" id="H_PayAdvance" :options="$options" empty="-" :default="old('H_PayAdvance')" />
                </div>

                <div class="col-sm-3 py-1">
                    @php
                        $options = [
                            0 => 'No',
                            1 => 'Yes',
                        ];
                    @endphp
                    <x-form.select name="H_NoEsignature" label="Allow E-Signature" id="H_NoEsignature" :options="$options" empty="-" :default="old('H_NoEsignature')" />
                </div>

                <div class="col-sm-3 py-1">
                    @php
                        $options = [
                            1 => 'Check',
                            2 => 'Credit',
                            3 => 'Cash',
                        ];
                    @endphp
                    <x-form.select name="H_PayMethod" label="Bill Method" id="H_PayMethod" :options="$options" empty="-" :default="old('H_PayMethod')" />
                </div>

                <div class="col-sm-3 py-1">
                    <x-form.input name="H_Fee" label="Bill Fee" :value="old('H_Fee')" maxlength="50" />
                </div>

                <div class="col-sm-3 py-1">
                    &nbsp;
                </div>

                <div class="col-sm-3 py-1">
                    <label for="alternatepayment"><a href="/user/alternatepayments?postname=1" onclick="popup(this.href); return false;">Alternate Payment</a></label>
                    <x-form.input name="H_AlternatePayment" id="alternatepayment" :value="old('H_AlternatePayment')" maxlength="50" />
                    <small id="alternatepaymentclear" class="btn btn-xs btn-danger">x</small>
                    &nbsp;
                    <span class="btn btn-xs btn-success" v-on:click="getAlternatePayment();">info</span>
                </div>

                <div class="col-sm-3 py-1">
                    <label for="copyservice"><a href="/user/copyservices?postname=1" onclick="popup(this.href); return false;">Copy Service</a></label>
                    <x-form.input name="H_CopyService" id="copyservice" :value="old('H_CopyService')" maxlength="50" />
                    <small id="copyserviceclear" class="btn btn-xs btn-danger">x</small>
                    &nbsp;
                    <span class="btn btn-xs btn-success" v-on:click="getCopyservice();">info</span>
                </div>

                <div class="col-sm-3 py-1">
                    <label for="roi"><a href="/user/rois?postname=1" onclick="popup(this.href); return false;">ROI</a></label>
                    <x-form.input name="H_ROI" id="roi" :value="old('H_ROI')" maxlength="50" />
                    <small id="roiclear" class="btn btn-xs btn-danger">x</small>
                    &nbsp;
                    <span class="btn btn-xs btn-success" v-on:click="getRoi();">info</span>
                </div>

            </div>

            <div class="row">
                <div class="col-6 pb-4">
                    <div class="row">
                        <div class="col" v-if="infowindow">
                            <h3 v-html="infowindowlabel"></h3>
                        </div>
                        <div class="col">
                            <div class="text-end">
                                <span class="btn btn-xs btn-danger" v-if="infowindow" @click="infowindow = '';">hide info</span>
                            </div>
                        </div>
                    </div>
                    <span v-html="infowindow"></span>
                </div>
            </div>

            <br />

            <x-hospitalformnotescreate />

            <x-form.button>Submit</x-form.button>

        </form>

    </div>

    <br />
    <br />

    <script>
        // $(document).ready(function() {

        //     $(".readonly").keydown(function(e) {
        //         e.preventDefault();
        //     });

        //     $("#alternatepayment").click(function() {
        //         popup("/user/alternatepayments?postname=1");
        //     });

        //     $("#copyservice").click(function() {
        //         popup("/user/copyservices?postname=1");
        //     });

        //     $("#roi").click(function() {
        //         popup("/user/rois?postname=1");
        //     });

        //     $("#alternatepaymentclear").click(function() {
        //         $("#alternatepayment").val('');
        //     });

        //     $("#copyserviceclear").click(function() {
        //         $("#copyservice").val('');
        //     });

        //     $("#roiclear").click(function() {
        //         $("#roi").val('');
        //     });

        // });

        // function popup(url) {
        //     window.open(url, "popup", "scrollbars=yes,width=1280,height=800,resizable=yes,left=40,top=40")
        // }

        document.addEventListener('DOMContentLoaded', function() {
            // Prevent typing in elements with class 'readonly'
            document.querySelectorAll('.readonly').forEach(function(el) {
                el.addEventListener('keydown', function(e) {
                    e.preventDefault();
                });
            });

            // Click handlers for popup triggers
            document.getElementById('alternatepayment')?.addEventListener('click', function() {
                popup('/user/alternatepayments?postname=1');
            });

            document.getElementById('copyservice')?.addEventListener('click', function() {
                popup('/user/copyservices?postname=1');
            });

            document.getElementById('roi')?.addEventListener('click', function() {
                popup('/user/rois?postname=1');
            });

            // Clear input values
            document.getElementById('alternatepaymentclear')?.addEventListener('click', function() {
                const el = document.getElementById('alternatepayment');
                if (el) el.value = '';
            });

            document.getElementById('copyserviceclear')?.addEventListener('click', function() {
                const el = document.getElementById('copyservice');
                if (el) el.value = '';
            });

            document.getElementById('roiclear')?.addEventListener('click', function() {
                const el = document.getElementById('roi');
                if (el) el.value = '';
            });
        });

        function popup(url) {
            window.open(url, 'popup', 'scrollbars=yes,width=1280,height=800,resizable=yes,left=40,top=40');
        }
    </script>

    <script>
        let app = Vue.createApp({
            data() {
                return {
                    infowindow: '',
                    infowindowlabel: '',
                    H_Hospital: '',
                    hospital: [
                        'H_Hospital',
                        'H_Address',
                        'H_City',
                        'H_State',
                        'H_Zip',
                    ],
                    alternatepayment: [],
                    copyservice: [],
                    roi: [],
                    show: false,
                    showerror: false,
                    showerrormessage: 'not found',
                }
            },
            methods: {
                infowindowspin() {
                    this.infowindow = '<i class="fas fa-sync fa-spin"></i>';
                },
                getAlternatePayment() {
                    this.infowindowspin();
                    var name = document.getElementById("alternatepayment").value;

                    const res = fetch('/api/alternatepayments/show?A_CopyService=' + encodeURIComponent(name))
                        .then(response => response.json())
                        .then(data => {
                            if (data) {
                                console.log(data);
                                this.alternatepayment = data;
                                this.infowindowlabel = 'Alternate Payment';
                                this.infowindow =
                                    "Alternate Payment: <strong>" + this.alternatepayment.A_CopyService + "</strong><br />" +
                                    "Address: " + this.alternatepayment.A_Address + "<br />" +
                                    "City: " + this.alternatepayment.A_City + "<br />" +
                                    "State: " + this.alternatepayment.A_State + "<br />" +
                                    "Zip: " + this.alternatepayment.A_Zip + "<br />" +
                                    "Phone: " + this.alternatepayment.A_Phone + "<br />" +
                                    "PhoneExt: " + this.alternatepayment.A_PhoneExt + "<br />" +
                                    "Fax: " + this.alternatepayment.A_Fax + "<br />" +
                                    "Note: " + this.alternatepayment.A_Note_br + "<br />";
                            } else {
                                this.infowindowlabel = 'Alternate Payment';
                                this.infowindow = '<span class="text-danger">not found: ' + name + '</span>';
                            }
                        })
                        .catch(error => {
                            console.error("There was an error! ", error)
                        });
                },
                getCopyservice(H_ID) {
                    this.infowindowspin();
                    // var name = document.getElementById("copyservice").value;

                    const res = fetch('/api/copyservices/show?C_CopyService=' + encodeURIComponent(H_ID))
                        .then(response => response.json())
                        .then(data => {
                            if (data) {
                                console.log(data);
                                this.copyservice = data;
                                this.infowindowlabel = 'Copy Service';
                                this.infowindow =
                                    "Copy Service: <strong>" + this.copyservice.C_CopyService + "</strong><br />" +
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
                                this.infowindow = '<span class="text-danger">not found: ' + name + '</span>';
                            }
                        })
                        .catch(error => {
                            console.error("There was an error! ", error)
                        });

                },
                getRoi() {
                    this.infowindowspin();
                    var name = document.getElementById("roi").value;

                    const res = fetch('/api/rois/show?R_ROIname=' + encodeURIComponent(name))
                        .then(response => response.json())
                        .then(data => {
                            if (data) {
                                console.log(data);
                                this.roi = data;
                                this.infowindowlabel = 'ROI';
                                this.infowindow =
                                    "ROI: <strong>" + this.roi.R_ROIname + "</strong><br />" +
                                    "State: " + this.roi.R_State + "<br />" +
                                    "Zip: " + this.roi.R_Zip + "<br />" +
                                    "Phone: " + this.roi.R_Phone + "<br />" +
                                    "PhoneExt: " + this.roi.R_PhoneExt + "<br />" +
                                    "Fax: " + this.roi.R_Fax + "<br />" +
                                    "Note: " + this.roi.R_Note_br + "<br />";
                            } else {
                                this.infowindowlabel = 'ROI';
                                this.infowindow = '<span class="text-danger">not found: ' + name + '</span>';
                            }
                        })
                        .catch(error => {
                            console.error("There was an error! ", error)
                        });
                },
            },
        });

        app.mount('#app');
    </script>

</x-user-layout>
