<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Create Credit Card</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.creditcards.index') }}" class="btn btn-sm btn-secondary">View Credit Cards</a>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('admin.creditcards.store') }}">
                @csrf

                <x-form.input name="CC_No" id="CC_No" label="Card Number" :value="old('CC_No')" />
                <br />

                <x-form.input name="CC_Name" id="CC_Name" label="Name" :value="old('CC_Name')" onkeyup="this.value = this.value.toUpperCase();" />
                <br />

                <x-form.input name="ExpDate" id="ExpDate" label="Expiration Date" :value="old('ExpDate')" />
                <br />

                <x-form.input name="CVC_No" id="CVC_No" label="CVC" :value="old('CVC_No')" />
                <br />

                <br />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-admin-layout>