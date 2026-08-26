<x-user-layout title="">

    <div class="row">
        <div class="col">
            <h1>Add Workorder Payment: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }}
                {{ $workorder->W_MiddleInit }} {{ $workorder->W_LastName }}</h1>
        </div>
        <div class="col-auto text-end">
            <a href="{{ route('user.workorderpayments.index', ['workorder_id' => $workorder->W_WorkOrder]) }}"
               class="btn btn-sm btn-secondary">View Workorder Payments for # {{ $workorder->W_WorkOrder }}</a>
        </div>
    </div>

    <br />
    <br />

    <div class="col-md-6">

        <form method="post"
              action="{{ route('user.workorderpayments.update', $workorderpayment->id) }}">
            @csrf
            @method('PATCH')

            <input type="hidden"
                   name="workorder_id"
                   value="{{ $workorder->W_WorkOrder }}">

            @php
                $options = [
                    'check' => 'Check',
                    'creditcard' => 'Credit Card',
                ];
            @endphp
            <x-form.select name="payment_type"
                           label="Payment Type"
                           id="payment_type"
                           :options="$options"
                           empty="-"
                           :default="old('payment_type', $workorderpayment->payment_type)" />
            <br />

            <x-form.input type="number"
                          name="amount"
                          label="Amount"
                          :value="old('amount', $workorderpayment->amount)"
                          maxlength="50" />
            <br />

            @php
                $options = [
                    'active' => 'Active',
                    'void' => 'Void',
                ];
            @endphp
            <x-form.select name="status"
                           label="Status"
                           id="status"
                           :options="$options"
                           empty="-"
                           :default="old('status', $workorderpayment->status)"
                           required />
            <br />

            <x-form.button>Submit</x-form.button>

        </form>

    </div>

    <br />
    <br />

</x-user-layout>
