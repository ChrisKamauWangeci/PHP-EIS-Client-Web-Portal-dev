<x-user-layout title="">

    <div class="row">
        <div class="col">
            <h1>Edit - {{ $shipment->id }}</h1>
        </div>
        <div class="col-auto text-end">
            <a href="{{ route('user.shipments.index') }}" class="btn btn-sm btn-secondary">Shipments</a>
            &nbsp;
            <a href="{{ route('user.shipments.show', $shipment->id) }}" class="btn btn-sm btn-secondary">View Shipment</a>
        </div>
    </div>

    <br />
    <br />

    <div class="row">
        <div class="col-sm-5">

            <form method="post" action="{{ route('user.shipments.update', $shipment->id) }}">
                @csrf
                @method('PATCH')

                <x-form.input type="number" name="fee" label="Fee" :value="old('fee', $shipment->fee )" />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>



</x-user-layout>