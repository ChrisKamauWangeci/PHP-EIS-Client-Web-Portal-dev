<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Edit Bill To Picklist</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.billtopicklists.show', $billtopicklist->id) }}" class="btn btn-sm btn-secondary">View Bill To Picklist</a>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('admin.billtopicklists.update', $billtopicklist->id) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="BL_BillTo" label="Bill To" id="BL_BillTo" :value="old('BL_BillTo', $billtopicklist->BL_BillTo)" />
                <br />

                <x-form.input name="BL_InsCompany" label="Insurance Company" id="BL_InsCompany" :value="old('BL_InsCompany', $billtopicklist->BL_InsCompany)" />
                <br />

                <x-form.input type="number" name="BL_MaxAmt" label="Max Amount" id="BL_MaxAmt" :value="old('BL_MaxAmt', $billtopicklist->BL_MaxAmt)" />
                <br />

                <x-form.input type="number" name="BL_AuthFee" label="Auth Fee" id="BL_AuthFee" :value="old('BL_AuthFee', $billtopicklist->BL_AuthFee)" />
                <br />

                <x-form.input type="number" name="epic_fee" label="Epic Fee" id="epic_fee" :value="old('epic_fee', $billtopicklist->epic_fee)" />
                <br />

                <x-form.input type="number" name="veradigm_fee" label="Veradigm Fee" id="veradigm_fee" :value="old('veradigm_fee', $billtopicklist->veradigm_fee)" />
                <br />

                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />
    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            billtopicklist
            @php dump(@$billtopicklist) @endphp
        </div>
    @endif

</x-admin-layout>
