<x-user-layout title="">

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {

            document.getElementById('docusignsubmit').addEventListener('submit', function(event) {
                document.getElementById("docusignsubmit").querySelector('button[type="submit"]').disabled =
                    true;
                document.getElementById("docusignsubmit").getElementsByClassName("spin")[0].classList.add(
                    "fas", "fa-sync-alt", "fa-spin");
            });

        });
    </script>

    <h1>Docusign Document</h1>

    <div class="p-3">
        <div class="row">

            <div class="col-sm-12 col-md-3 border p-1">
                <small>eis_insurance</small>
                <br />
                <strong>{{ $sara['data']['eis_insurance'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>db</small>
                <br />
                <strong>{{ $sara['data']['db'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>client</small>
                <br />
                <strong>{{ $sara['data']['client'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>company</small>
                <br />
                <strong>{{ $sara['data']['company'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>requestor_name</small>
                <br />
                <strong>{{ $sara['data']['requestor_name'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>requestor_email</small>
                <br />
                <strong>{{ $sara['data']['requestor_email'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>agent</small>
                <br />
                <strong>{{ $sara['data']['agent'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>agent_email</small>
                <br />
                <strong>{{ $sara['data']['agent_email'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>workorder_id</small>
                <br />
                <strong>
                    <a
                       href="{{ route('user.workorders.show', $sara['data']['workorder_id']) }}">{{ $sara['data']['workorder_id'] }}</a>
                </strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>patient_first_name</small>
                <br />
                <strong>{{ $sara['data']['patient_first_name'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>patient_middle_name</small>
                <br />
                <strong>{{ $sara['data']['patient_middle_name'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>patient_last_name</small>
                <br />
                <strong>{{ $sara['data']['patient_last_name'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>patient_birth_date</small>
                <br />
                <strong>{{ date('m/d/Y', strtotime($sara['data']['patient_birth_date'])) }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>patient_social_security_full</small>
                <br />
                <strong>{{ $sara['data']['patient_social_security_full'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>patient_social_security</small>
                <br />
                <strong>{{ $sara['data']['patient_social_security'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>patient_phone</small>
                <br />
                <strong>{{ $sara['data']['patient_phone'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>patient_email</small>
                <br />
                <strong>{{ $sara['data']['patient_email'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>patient_address</small>
                <br />
                <strong>{{ $sara['data']['patient_address'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>patient_city</small>
                <br />
                <strong>{{ $sara['data']['patient_city'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>patient_state</small>
                <br />
                <strong>{{ $sara['data']['patient_state'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>patient_zip_code</small>
                <br />
                <strong>{{ $sara['data']['patient_zip_code'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>patient_city_state_zip</small>
                <br />
                <strong>{{ $sara['data']['patient_city_state_zip'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>patient_full_address</small>
                <br />
                <strong>{{ $sara['data']['patient_full_address'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>W_ReceiveDate</small>
                <br />
                <strong>{{ $sara['data']['W_ReceiveDate'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>W_YearsOfRecord</small>
                <br />
                <strong>{{ $sara['data']['W_YearsOfRecord'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>dates_of_service_from</small>
                <br />
                <strong>{{ $sara['data']['dates_of_service_from'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>dates_of_service_to</small>
                <br />
                <strong>{{ $sara['data']['dates_of_service_to'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>dates_of_service_combined</small>
                <br />
                <strong>{{ $sara['data']['dates_of_service_combined'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>special_instructions</small>
                <br />
                <strong>{{ $sara['data']['special_instructions'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>facility dr</small>
                <br />
                <strong>{{ $sara['facility_dr'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>facility_name</small>
                <br />
                <strong>{{ $sara['data']['facility_name'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>facility_address</small>
                <br />
                <strong>{{ $sara['data']['facility_address'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>facility_city</small>
                <br />
                <strong>{{ $sara['data']['facility_city'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>facility_state</small>
                <br />
                <strong>{{ $sara['data']['facility_state'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>facility_zip_code</small>
                <br />
                <strong>{{ $sara['data']['facility_zip_code'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>facility_city_state_zip</small>
                <br />
                <strong>{{ $sara['data']['facility_city_state_zip'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>facility_full_address</small>
                <br />
                <strong>{{ $sara['data']['facility_full_address'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>facility_phone</small>
                <br />
                <strong>{{ $sara['data']['facility_phone'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>slug</small>
                <br />
                <strong>{{ $sara['slug'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>brand id</small>
                <br />
                <strong>{{ $sara['data']['brand_id'] ?? '' }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>signingtype</small>
                <br />
                <strong>{{ $sara['data']['signingtype'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>environment</small>
                <br />
                <strong>{{ $sara['data']['environment'] }}</strong>
            </div>
            <div class="col-sm-12 col-md-3 border p-1">
                <small>access_code</small>
                <br />
                <strong>{{ $sara['data']['access_code'] }}</strong>
            </div>
            <div class="col-12 border p-1">
                <small>email subject</small>
                <br />
                <strong>{{ $sara['emailsubject'] ?? '' }}</strong>
                <br />
                <br />
                <small>email message</small>
                <br />
                <br />
                {!! nl2br($sara['emailbody']) !!}
            </div>
        </div>
    </div>

    <br />

    <a href="{{ route('user.docusigns.edit') }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <form method="post"
          action="{{ route('user.docusigns.sign') }}"
          id="docusignsubmit"
          @if ($sara['data']['signingtype'] == 'embedded') target="_blank" @endif>
        @csrf
        @method('POST')
        <input type="hidden"
               name="facility"
               value="{{ $sara['facility_dr'] }}">
        <input type="hidden"
               name="slug"
               value="{{ $sara['slug'] }}">
        <button type="submit"
                class="btn btn-secondary btn-sm">Create Docusign API Request <i class="spin"></i></button>
    </form>

    <br />
    <br />

    <a href="{{ route('user.workorders.show', $sara['data']['workorder_id']) }}"
       class="btn btn-sm btn-secondary">View Workorder</a>

    <br />
    <br />

    <a href="{{ route('user.docusigndocuments.index') }}"
       class="btn btn-sm btn-secondary">Docusign Documents</a>

    <br />
    <br />

</x-user-layout>
