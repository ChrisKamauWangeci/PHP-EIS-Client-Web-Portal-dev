<x-user-layout title="">

    <div class="row">
        <div class="col">
            <h1>Add Workorder Shipment: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }} {{ $workorder->W_MiddleInit }} {{ $workorder->W_LastName }}</h1>
        </div>
        <div class="col-auto text-end">
            <a href="{{ route('user.shipments.index', ['workorder_id' => $workorder->W_WorkOrder]) }}" class="btn btn-sm btn-secondary">View Shipments for # {{ $workorder->W_WorkOrder }}</a>
        </div>
    </div>

    <br />
    <br />

    <div class="col-md-6">

        <form method="post" action="{{ route('user.shipments.store') }}">
            @csrf

            <input type="hidden" name="workorder_id" value="{{ $workorder->W_WorkOrder }}">

            <x-form.input type="number" name="fee" label="Fee" :value="old('fee')" />
            <br />

            <x-form.button>Submit</x-form.button>

        </form>

    </div>

    <br />
    <br />

</x-user-layout>