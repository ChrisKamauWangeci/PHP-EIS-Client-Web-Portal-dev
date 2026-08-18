<x-user-layout title="">

    <script>
        // document.addEventListener('DOMContentLoaded', function() {

        //     $('form').submit(function() {
        //         $('button[type="submit"]').attr('disabled', 'disabled');
        //     });

        //     $('#dbfield, #dbconditions').change(function() {
        //         if ($('#dbvalue').val() == '-') {
        //             $('#dbvalue').val('');
        //         }
        //         if (($('#dbfield').val() != '') && ($('#dbconditions').val() == '')) {
        //             $('#dbconditions').val('contains');
        //             $("#dbvalue").prop('required', true);
        //         }
        //         if (($('#dbfield').val() == '')) {
        //             $('#dbconditions').val('');
        //             $('#dbvalue').val('');
        //             $("#dbvalue").prop('required', false);
        //         }
        //         if ($('#dbconditions').val() == 'isempty') {
        //             $('#dbvalue').val('-');
        //         }
        //         if ($('#dbconditions').val() == 'isnotempty') {
        //             $('#dbvalue').val('-');
        //         }

        //     });

        // });

        document.addEventListener('DOMContentLoaded', function() {
            // Disable submit button on form submit
            document.querySelectorAll('form').forEach(function(form) {
                form.addEventListener('submit', function() {
                    document.querySelectorAll('button[type="submit"]').forEach(function(btn) {
                        btn.disabled = true;
                    });
                });
            });

            // Change handler for #dbfield and #dbconditions
            const dbfield = document.getElementById('dbfield');
            const dbconditions = document.getElementById('dbconditions');
            const dbvalue = document.getElementById('dbvalue');

            function handleChange() {
                if (dbvalue.value === '-') {
                    dbvalue.value = '';
                }

                if (dbfield.value !== '' && dbconditions.value === '') {
                    dbconditions.value = 'eq';
                    dbvalue.required = true;
                }

                if (dbfield.value === '') {
                    dbconditions.value = '';
                    dbvalue.value = '';
                    dbvalue.required = false;
                }

                if (dbconditions.value === 'empty' || dbconditions.value === 'not_empty') {
                    dbvalue.value = '-';
                }
            }

            dbfield.addEventListener('change', handleChange);
            dbconditions.addEventListener('change', handleChange);
        });

        function toggle(source) {
            var checkboxes = document.querySelectorAll('.checkboxes');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source) {
                    checkboxes[i].checked = source.checked;
                }
            }
        }
    </script>

    <style>
        .hospitalnote {
            display: none;
        }
    </style>

    <div class="row">
        <div class="col-6">
            <h1>Hospitals</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{ route('user.hospitals.create') }}" class="btn btn-sm btn-secondary">Create New</a>
        </div>
    </div>

    <div class="p-1"></div>

    <form method="post" accept-charset="utf-8" id="searchform" action="{{ route('user.hospitals.prg') }}">
        @csrf

        <div class="row">

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="H_ID" label="ID" :value="request('H_ID')" type="number" autocomplete="off" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="H_Hospital" label="Facility / Hospital" :value="request('H_Hospital')" type="text" autocomplete="off" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="H_Hospital2" label="Facility / Hospital 2" :value="request('H_Hospital2')" type="text" autocomplete="off" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="H_Address" label="Address" :value="request('H_Address')" type="text" autocomplete="off" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="H_City" label="City" :value="request('H_City')" type="text" autocomplete="off" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.select name="H_State" label="State" id="H_State" :options="Helper::states()" empty="-" :default="request('H_State')" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="H_Zip" label="Zip" :value="request('H_Zip')" type="text" autocomplete="off" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="H_Phone" label="Phone" :value="request('H_Phone')" type="text" autocomplete="off" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="H_Fax" label="Fax" :value="request('H_Fax')" type="text" autocomplete="off" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                @php
                    $dbfieldselects = [
                        'H_Hospital' => 'Hospital',
                        'H_Hospital2' => 'Hospital2',
                        'H_Phone' => 'Phone',
                        'H_Fax' => 'Fax',
                        'H_Address' => 'Address',
                        'H_City' => 'City',
                        'H_State' => 'State',
                        'H_Zip' => 'Zip',
                        'H_SpecialAuthFile' => 'Special Auth File',
                        'H_Docusign' => 'Docusign',
                        'H_Created' => 'Created',
                        'created_by' => 'Created By',
                        'H_UpdDate' => 'Updated',
                        'H_UpdUser' => 'Updated By',
                    ];
                @endphp
                <x-form.select name="dbfield" label="Field" id="dbfield" :options="$dbfieldselects" empty="-" :default="request('dbfield')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                @php
                    $dbconditionsselects = [
                        'eq' => 'Is equal to',
                        'neq' => 'Is not equal to',
                        'contains' => 'Contains',
                        'not_contains' => 'Does not contain',
                        'starts_with' => 'Begins with',
                        'ends_with' => 'Ends with',
                        'empty' => 'Is empty',
                        'not_empty' => 'Is not empty',
                    ];
                @endphp
                <x-form.select name="dbconditions" label="Condition" id="dbconditions" :options="$dbconditionsselects" empty="-" :default="request('dbconditions')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="dbvalue" label="Value" id="dbvalue" :value="request('dbvalue')" autocomplete="off" maxlength="50" />
            </div>

            <div class="col-12 col-md-4 col-lg-2 pt-2">
                <label>&nbsp; </label>
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.hospitals.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />

    {{ $hospitals->withQueryString()->links() }}

    <form method="post" action="{{ route('user.hospitals.transfer') }}">
        @csrf

        <div class="table-responsive">
            <table class="table table-sm table-hover table-bordered w-auto">
                <thead>
                    <tr>
                        <th><input type="checkbox" onclick="toggle(this);" /></th>
                        <th>Facility / Hospital</th>
                        <th>Facility / Hospital 2</th>
                        <th>Address City State Zip</th>
                        <th>
                            Phone
                            <br />
                            Fax
                        </th>
                        <th>
                            Special Auth File
                            <br />
                            Docusign
                        </th>
                        <th>
                            <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'H_Created', 'sort_direction' => $sort_direction]) }}">Created</a>
                            <br />
                            <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_by', 'sort_direction' => $sort_direction]) }}">Created By</a>
                            <br />
                            <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'H_UpdDate', 'sort_direction' => $sort_direction]) }}">Updated</a>
                            <br />
                            <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'H_UpdUser', 'sort_direction' => $sort_direction]) }}">Updated By</a>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp

                    @foreach ($hospitals as $hospital)
                        @php
                            $i++;
                        @endphp
                        <tr>
                            <td>
                                <input type="hidden" name="Hospital[selected][]" value="0"><input type="checkbox" name="Hospital[selected][]" value="{{ $hospital->H_ID }}" class="checkboxes">
                            </td>
                            <td>
                                {{ $hospital->H_Hospital }}
                            </td>
                            <td>
                                {{ $hospital->H_Hospital2 }}
                            </td>
                            <td>
                                {{ $hospital->H_Address }}
                                <br />
                                {{ $hospital->H_City }}
                                {{ $hospital->H_State }}
                                {{ $hospital->H_Zip }}

                                @if ($hospital->timezone_offset > '')
                                    <br />
                                    <small>{{ date('g:i a', strtotime($hospital->timezone_offset . ' hours')) }}</small>
                                @endif
                            </td>
                            <td nowrap>
                                tel: {{ $hospital->H_Phone }}
                                <br />
                                fax: {{ $hospital->H_Fax }}
                            </td>
                            <td>
                                {{ $hospital->H_SpecialAuthFile }}
                                <br />
                                {{ $hospital->H_Docusign }}
                            </td>
                            <td nowrap>
                                {{ $hospital->H_Created?->format('m/d/Y') }}
                                <br />
                                {{ $hospital->created_by }}
                                <br />
                                {{ $hospital->H_UpdDate?->format('m/d/Y') }}
                                <br />
                                {{ $hospital->H_UpdUser }}
                            </td>
                            <td nowrap>
                                <a href="{{ route('user.hospitals.show', $hospital->H_ID) }}" class="btn btn-xs btn-secondary">View</a>
                                <br />
                                <a href="{{ route('user.hospitals.edit', $hospital->H_ID) }}" class="btn btn-xs btn-secondary">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <br />

        <div class="row">
            <div class="col-6 col-md-2">
                <input type="hidden" name="specialauthfile" value="0">
                <label for="specialauthfile">
                    <input type="checkbox" name="specialauthfile" id="specialauthfile" value="1">
                    specialauthfile
                </label>
            </div>
            <div class="col-6 col-md-2">
                <input type="hidden" name="docusign" value="0">
                <label for="docusign">
                    <input type="checkbox" name="docusign" id="docusign" value="1">
                    docusign
                </label>
            </div>
            <div class="col-6 col-md-2">
                <x-form.select name="facilityformid" :options="$facilityformsselects" empty=" " />
            </div>
            <div class="col-6 col-md-2">
                <x-form.button>Submit</x-form.button>
            </div>
        </div>

    </form>

    <br />

    {{ $hospitals->withQueryString()->links() }}

    <br />

</x-user-layout>
