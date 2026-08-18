<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Edit Company</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.companies.show', $company->id) }}" class="btn btn-sm btn-secondary">View Company</a>
        </div>
    </div>

    <br />

    <h2>{{ $company->C_Name }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('admin.companies.update', $company->id) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="C_Address" label="Address" :value="old('C_Address', $company->C_Address)" />
                <br />

                <x-form.input name="C_City" label="City" :value="old('C_City', $company->C_City)" />
                <br />

                <x-form.input name="C_State" label="State" :value="old('C_State', $company->C_State)" />
                <br />

                <x-form.input name="C_Zip" label="Zip" :value="old('C_Zip', $company->C_Zip)" />
                <br />

                <x-form.input name="C_Contact" label="Contact" :value="old('C_Contact', $company->C_Contact)" />
                <br />

                <x-form.input type="email" name="C_ContactMail" label="Contact Mail" :value="old('C_ContactMail', $company->C_ContactMail)" />
                <br />

                <x-form.input name="C_Phone" label="Contact Phone" :value="old('C_Phone', $company->C_Phone)" />
                <br />

                <x-form.input name="C_Fax" label="Contact Fax" :value="old('C_Fax', $company->C_Fax)" />
                <br />

                <x-form.textarea name="C_Note" label="Notes" :value="old('C_Note', $company->C_Note)" :rows="8" />
                <br />

                <x-form.textarea name="C_ContactNote" label="Contact Notes" :value="old('C_ContactNote', $company->C_ContactNote)" :rows="8" />
                <br />

                <x-form.textarea name="C_Instruction" label="Instructions" :value="old('C_Instruction', $company->C_Instruction)" :rows="8" />
                <br />

                <x-form.input name="C_WebID" label="Web ID" :value="old('C_WebID', $company->C_WebID)" />
                <br />

                @php
                    $options = [
                        '' => 'Entire Chart',
                        '1' => '1 Year',
                        '2' => '2 Years',
                        '3' => '3 Years',
                        '4' => '4 Years',
                        '5' => '5 Years',
                        '6' => '6 Years',
                        '7' => '7 Years',
                        '10' => '10 Years',
                        'other' => 'Other',
                    ];
                @endphp
                <x-form.select name="years_of_records" label="Years of Records" id="years_of_records" :options="$options" empty="" :default="$company->years_of_records" />
                <br />

                <x-form.checkbox name="C_MFA" label="MFA" :checked="old('C_MFA', $company->C_MFA)" />

                <x-form.checkbox name="C_APSOnly" label="APS Only" :checked="old('C_APSOnly', $company->C_APSOnly)" />

                <x-form.checkbox name="C_EHR" label="EHR" :checked="old('C_EHR', $company->C_EHR)" />

                <x-form.checkbox name="C_eHealthLink" label="eHealthLink" :checked="old('C_eHealthLink', $company->C_eHealthLink)" />

                <x-form.checkbox name="summary" label="Summary" :checked="old('summary', $company->summary)" />

                <x-form.checkbox name="smartaccess_active" label="Smart Access" :checked="old('smartaccess_active', $company->smartaccess_active)" />

                <x-form.checkbox name="caremap360_active" label="CareMap 360" :checked="old('caremap360_active', $company->caremap360_active)" />

                <br />

                <x-form.errors />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            company
            @php dump(@$company) @endphp
        </div>
    @endif

</x-admin-layout>
