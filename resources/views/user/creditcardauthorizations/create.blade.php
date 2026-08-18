<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Create Credit Card Authorization: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }} {{ $workorder->W_LastName }}</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}" class="btn btn-sm btn-secondary">View Workorder</a>
            <a href="{{ route('user.workorderfiles.show', $workorder->W_WorkOrder) }}" class="btn btn-sm btn-secondary">View Workorder Files</a>
        </div>
    </div>

    <br />
    <br />

    <table class="table table-bordered w-auto">
        <tr>
            <td>Dr Fee 1</td>
            <td>$ {{ $workorder->W_DrFee1 }}</td>
        </tr>
        <tr>
            <td>Dr Fee 2</td>
            <td>$ {{ $workorder->W_DrFee2 }}</td>
        </tr>
    </table>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('user.creditcardauthorizations.store') }}">
                @csrf

                <input type="hidden" name="workorder_id" value="{{ $workorder->W_WorkOrder }}">

                <x-form.input type="number" name="dr_fee" label="Dr Fee" id="dr_fee" :value="old('dr_fee')" min="0" max="2000" step=".01" required />
                <br />

                <x-form.select name="card" label="Credit Card" id="card" :options="$creditcards" empty="-" :default="old('card')" required />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-user-layout>