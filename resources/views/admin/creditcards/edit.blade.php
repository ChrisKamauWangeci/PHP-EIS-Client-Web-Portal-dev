<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Edit Credit Card</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.creditcards.show', $creditcard->id) }}"
               class="btn btn-sm btn-secondary">View Credit Card</a>
        </div>
    </div>

    <br />
    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('admin.creditcards.update', $creditcard->id) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="CC_No"
                              id="CC_No"
                              label="Card Number"
                              :value="old('CC_No', $creditcard->CC_No)" />
                <br />

                <x-form.input name="CC_Name"
                              id="CC_Name"
                              label="Name"
                              :value="old('CC_Name', $creditcard->CC_Name)" />
                <br />

                <x-form.input name="ExpDate"
                              id="ExpDate"
                              label="Expiration Date"
                              :value="old('ExpDate', $creditcard->ExpDate)" />
                <br />

                <x-form.input name="CVC_No"
                              id="CVC_No"
                              label="CVC"
                              :value="old('CVC_No', $creditcard->CVC_No)" />
                <br />

                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            creditcard
            @php dump(@$creditcard) @endphp
        </div>
    @endif

</x-admin-layout>
