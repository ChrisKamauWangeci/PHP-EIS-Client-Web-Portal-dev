<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Edit Alternate Payment</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.alternatepayments.index') }}" class="btn btn-sm btn-secondary">Alternate Payments</a>
            <a href="{{ route('user.alternatepayments.update', $alternatepayment->A_ID ) }}" class="btn btn-sm btn-secondary">View Alternate Payment</a>
        </div>
    </div>

    <br />

    <h2>{{ $alternatepayment->A_CopyService }}</h2>

    <br />

    <div class="row">
        <div class="col-md-6">

            <form method="post" action="{{ route('user.alternatepayments.update', $alternatepayment->A_ID ) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="A_Address" id="A_Address" label="Address" :value="old('A_Address', $alternatepayment->A_Address )" />
                <br />

                <x-form.input name="A_City" id="A_City" label="City" :value="old('A_City', $alternatepayment->A_City )" />
                <br />

                <x-form.input name="A_State" id="A_State" label="State" :value="old('A_State', $alternatepayment->A_State )" />
                <br />

                <x-form.input name="A_Zip" id="A_Zip" label="Zip" :value="old('A_Zip', $alternatepayment->A_Zip )" />
                <br />

                <x-form.input name="A_Phone" id="A_Phone" label="Phone" :value="old('A_Phone', $alternatepayment->A_Phone )" />
                <br />

                <x-form.input name="A_Fax" id="A_Fax" label="Fax" :value="old('A_Fax', $alternatepayment->A_Fax )" />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>
        </div>
    </div>

    <br />
    <br />

</x-user-layout>