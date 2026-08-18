<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Edit Docusign</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.docusigns.index') }}" class="btn btn-sm btn-secondary">View Docusign</a>
        </div>
    </div>

    <br />

    <div class="col-md-6">

        <form method="post" action="{{ route('user.docusigns.update') }}">
            @csrf
            @method('POST')

            <x-form.input name="patient_first_name" label="patient_first_name" :value="old('patient_first_name', $sara['data']['patient_first_name'])" required maxlength="50" />
            <br />

            <x-form.input name="patient_middle_name" label="patient_middle_name" :value="old('patient_middle_name', $sara['data']['patient_middle_name'])" maxlength="50" />
            <br />

            <x-form.input name="patient_last_name" label="patient_last_name" :value="old('patient_last_name', $sara['data']['patient_last_name'])" required maxlength="50" />
            <br />

            <x-form.input name="patient_email" label="patient_email" :value="old('patient_email', $sara['data']['patient_email'])" maxlength="50" />
            <br />

            <x-form.input name="dates_of_service_from" label="dates_of_service_from" :value="old('dates_of_service_from', $sara['data']['dates_of_service_from'])" required maxlength="50" />
            <br />

            <x-form.input name="dates_of_service_to" label="dates_of_service_to" :value="old('dates_of_service_to', $sara['data']['dates_of_service_to'])" required maxlength="50" />
            <br />

            <x-form.input name="dates_of_service_combined" label="dates_of_service_combined" :value="old('dates_of_service_combined', $sara['data']['dates_of_service_combined'])" required maxlength="50" />
            <br />

            <x-form.input name="access_code" label="access_code" :value="old('access_code', $sara['data']['access_code'])" required maxlength="50" />
            <br />

            @if ($subdomain == 'eisdev' || $subdomain == 'eisuat')
                @php
                    $environments = [
                        'production' => 'production',
                        'test' => 'test',
                    ];
                @endphp
                <x-form.select name="environment" label="Environment" :options="$environments" :default="old('environment', $sara['data']['environment'])" />
                <br />
            @endif

            @php
                $signingtypes = [
                    'embedded' => 'embedded',
                    'email' => 'email',
                ];
            @endphp
            <x-form.select name="signingtype" label="Signing Type" :options="$signingtypes" :default="old('signingtype', $sara['data']['signingtype'])" />
            <br />

            <x-form.input name="emailsubject" label="Email Subject" :value="old('emailsubject', $sara['emailsubject'])" required maxlength="90" />
            <br />

            <x-form.textarea name="emailbody" label="Email Body" :value="old('emailbody', $sara['emailbody'])" :rows="20" required />
            <br />

            <br />

            <x-form.button>Submit</x-form.button>

        </form>

    </div>

</x-user-layout>
