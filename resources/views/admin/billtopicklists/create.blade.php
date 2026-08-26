<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Create Bill To Picklist</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.billtopicklists.index') }}"
               class="btn btn-sm btn-secondary">View Bill To Picklists</a>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('admin.billtopicklists.store') }}">
                @csrf

                <x-form.input name="BL_BillTo"
                              id="BL_BillTo"
                              label="Bill To"
                              :value="old('BL_BillTo')" />
                <br />

                <x-form.input name="BL_InsCompany"
                              id="BL_InsCompany"
                              label="Insurance Company"
                              :value="old('BL_InsCompany')" />
                <br />

                <x-form.input name="BL_MaxAmt"
                              id="BL_MaxAmt"
                              label="Max Amount"
                              :value="old('BL_MaxAmt')" />
                <br />

                <x-form.input name="BL_AuthFee"
                              id="BL_AuthFee"
                              label="Auth Fee"
                              :value="old('BL_AuthFee')" />
                <br />

                <x-form.input name="epic_fee"
                              id="epic_fee"
                              label="Epic Fee"
                              :value="old('epic_fee')" />
                <br />

                <x-form.input name="veradigm_fee"
                              id="veradigm_fee"
                              label="Veradigm Fee"
                              :value="old('veradigm_fee')" />
                <br />

                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-admin-layout>
