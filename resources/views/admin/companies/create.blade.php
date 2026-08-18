<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Create Company</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.companies.index') }}" class="btn btn-sm btn-secondary">View Companies</a>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('admin.companies.store') }}">
                @csrf

                <x-form.input name="C_Name" label="Company Name" :value="old('C_Name')" onkeyup="this.value = this.value.toUpperCase();" />
                <br />

                <x-form.input name="C_Address" label="Address" :value="old('C_Address')" />
                <br />

                <x-form.input name="C_City" label="City" :value="old('C_City')" />
                <br />

                <x-form.input name="C_State" label="State" :value="old('C_State')" />
                <br />

                <x-form.input name="C_Zip" label="Zip" :value="old('C_Zip')" />
                <br />

                <x-form.input name="C_WebID" label="Web ID" :value="old('C_WebID')" />
                <br />

                <x-form.input name="C_Contact" label="Contact" :value="old('C_Contact')" />
                <br />

                <x-form.input type="email" name="C_ContactMail" label="Contact Email" :value="old('C_ContactMail')" />
                <br />

                <x-form.input name="C_Phone" label="Contact Phone" :value="old('C_Phone')" />
                <br />

                <x-form.input name="C_Fax" label="Contact Fax" :value="old('C_Fax')" />
                <br />

                <x-form.textarea name="C_Note" label="Notes" :value="old('C_Note')" :rows="8" />
                <br />

                <x-form.textarea name="C_ContactNote" label="Contact Notes" :value="old('C_ContactNote')" :rows="8" />
                <br />

                <x-form.textarea name="C_Instruction" label="Instructions" :value="old('C_Instruction')" :rows="8" />
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
                <x-form.select name="years_of_records" label="Years of Records" id="years_of_records" :options="$options" empty="" :default="old('years_of_records')" />
                <br />

                <x-form.checkbox name="C_APSOnly" label="APS Only" :checked="old('C_APSOnly')" />
                <x-form.checkbox name="C_EHR" label="EHR" :checked="old('C_EHR')" />
                <x-form.checkbox name="C_MFA" label="MFA" :checked="old('C_MFA')" />

                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-admin-layout>
