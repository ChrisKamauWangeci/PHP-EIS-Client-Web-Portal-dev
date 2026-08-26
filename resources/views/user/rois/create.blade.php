<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Create ROI</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.rois.index') }}"
               class="btn btn-sm btn-secondary">View ROI</a>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-md-6">

            <form method="post"
                  action="{{ route('user.rois.store') }}">
                @csrf

                <x-form.input name="R_ROIname"
                              id="R_ROIname"
                              label="ROI Name"
                              :value="old('R_ROIname')"
                              required />
                <br />

                <x-form.input name="R_ContactName"
                              id="R_ContactName"
                              label="Contact Name"
                              :value="old('R_ContactName')" />
                <br />

                <x-form.input name="R_ContactEmail"
                              id="R_ContactEmail"
                              label="Contact Email"
                              :value="old('R_ContactEmail')" />
                <br />

                <x-form.input name="R_Address"
                              id="R_Address"
                              label="Address"
                              :value="old('R_Address')" />
                <br />

                <x-form.input name="R_City"
                              id="R_City"
                              label="City"
                              :value="old('R_City')" />
                <br />

                <x-form.input name="R_State"
                              id="R_State"
                              label="State"
                              :value="old('R_State')" />
                <br />

                <x-form.input name="R_Zip"
                              id="R_Zip"
                              label="Zip"
                              :value="old('R_Zip')" />
                <br />

                <x-form.input name="R_Phone"
                              id="R_Phone"
                              label="Phone"
                              :value="old('R_Phone')" />
                <br />

                <x-form.input name="R_PhoneExt"
                              id="R_PhoneExt"
                              label="Phone Ext"
                              :value="old('R_PhoneExt')" />
                <br />

                <x-form.input name="R_Fax"
                              id="R_Fax"
                              label="Fax"
                              :value="old('R_Fax')" />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />

</x-user-layout>
