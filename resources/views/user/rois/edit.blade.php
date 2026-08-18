<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Edit ROI</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.rois.index') }}" class="btn btn-sm btn-secondary">ROI</a>
            <a href="{{ route('user.rois.show', $roi->R_ID) }}" class="btn btn-sm btn-secondary">View ROI</a>
        </div>
    </div>

    <br />

    <h2>{{ $roi->R_ROIname }}</h2>

    <br />

    <div class="row">
        <div class="col-md-6">

            <form method="post" action="{{ route('user.rois.update', $roi->R_ID) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="R_ContactName" id="R_ContactName" label="Contact Name" :value="old('R_ContactName', $roi->R_ContactName)" />
                <br />

                <x-form.input name="R_ContactEmail" id="R_ContactEmail" label="Contact Email" :value="old('R_ContactEmail', $roi->R_ContactEmail)" />
                <br />

                <x-form.input name="R_Address" id="R_Address" label="Address" :value="old('R_Address', $roi->R_Address)" />
                <br />

                <x-form.input name="R_City" id="R_City" label="City" :value="old('R_City', $roi->R_City)" />
                <br />

                <x-form.input name="R_State" id="R_State" label="State" :value="old('R_State', $roi->R_State)" />
                <br />

                <x-form.input name="R_Zip" id="R_Zip" label="Zip" :value="old('R_Zip', $roi->R_Zip)" />
                <br />

                <x-form.input name="R_Phone" id="R_Phone" label="Phone" :value="old('R_Phone', $roi->R_Phone)" />
                <br />

                <x-form.input name="R_PhoneExt" id="R_PhoneExt" label="Phone Ext" :value="old('R_PhoneExt', $roi->R_PhoneExt)" />
                <br />

                <x-form.input name="R_Fax" id="R_Fax" label="Fax" :value="old('R_Fax', $roi->R_Fax)" />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />

</x-user-layout>