<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Workorder # {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }} {{ $workorder->W_LastName }}
            </h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}"
               class="btn btn-sm btn-secondary">View Workorder</a>
        </div>
    </div>

    <h2>Payment Note</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">
            <form method="post"
                  action="{{ route('user.workorders.paymentnoteupdate', $workorder->W_WorkOrder) }}"
                  id="">
                @csrf
                @method('PATCH')

                <input type="hidden"
                       name="dr"
                       value="{{ $dr }}" />

                @if ($dr == 1)
                    <x-form.input name="W_DrFee1"
                                  label="DR Fee1"
                                  :value="old('W_DrFee1', $workorder->W_DrFee1)" />
                    <br />
                    <x-form.input name="W_DrCheckNo"
                                  label="Check / Card Info 1"
                                  :value="old('W_DrCheckNo', $workorder->W_DrCheckNo)" />
                    <br />
                    <x-form.input name="W_DrCheckDate"
                                  label="Check / Card Date 1"
                                  :value="old('W_DrCheckDate', $workorder->W_DrCheckDate)"
                                  type="date"
                                  autocomplete="off" />
                    <br />
                    <x-form.input name="W_DrInvoiceNo"
                                  label="Invoice Number 1"
                                  :value="old('W_DrInvoiceNo', $workorder->W_DrInvoiceNo)" />
                    <br />
                @endif

                @if ($dr == 2)
                    <x-form.input name="W_DrFee2"
                                  label="DR Fee2"
                                  :value="old('W_DrFee2', $workorder->W_DrFee2)" />
                    <br />
                    <x-form.input name="W_DrCheckNo2"
                                  label="Check / Card Info 2"
                                  :value="old('W_DrCheckNo2', $workorder->W_DrCheckNo2)" />
                    <br />
                    <x-form.input name="W_DrCheckDate2"
                                  label="Check / Card Date 2"
                                  :value="old('W_DrCheckDate2', $workorder->W_DrCheckDate2)"
                                  type="date"
                                  autocomplete="off" />
                    <br />
                    <x-form.input name="W_DrInvoiceNo2"
                                  label="Invoice Number 2"
                                  :value="old('W_DrInvoiceNo2', $workorder->W_DrInvoiceNo2)" />
                    <br />
                @endif

                <br />

                <x-form.button>Submit</x-form.button>

            </form>
        </div>
    </div>

    <br />
    <br />

</x-user-layout>
