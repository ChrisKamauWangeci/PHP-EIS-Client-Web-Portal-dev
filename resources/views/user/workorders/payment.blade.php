<x-user-layout title="">

    <script>
        $(document).ready(function() {

            $('.cc').hide();
            $('.check').hide();
            // $('#check').hide();
            $('#mailing').hide();

            // $('.drinvoiceno').text('Invoice #');

            @if ($dr == 1)
                if ($('#w-drcheckno').val() == 'CC') {
                    $('#payment_type').val('cc');
                    $('#w-drcheckno').attr('readonly', true);
                    $('.cc').show();
                    // $('.drinvoiceno').text('Invoice #');
                }
            @elseif ($dr == 2)
                if ($('#w-drcheckno2').val() == 'CC') {
                    $('#payment_type').val('cc');
                    $('#w-drcheckno2').attr('readonly', true);
                    $('.cc').show();
                    // $('.drinvoiceno').text('Invoice #');
                }
            @endif

            $('#payment_type').change(function() {

                if (this.value == 'unpaid') {
                    $('.cc').hide();
                    $('.check').hide();
                    // $('#mailing').hide();
                    $('#custodianblock').show();
                }

                if (this.value == 'cc') {
                    @if ($dr == 1)
                        // $('#w-drcheckno').val('CC');
                        // $('#w-drcheckno').attr('readonly', true);
                        $('#card_number').attr('required', true);
                    @elseif ($dr == 2)
                        // $('#w-drcheckno2').val('CC');
                        // $('#w-drcheckno2').attr('readonly', true);
                        $('#card_number').attr('required', true);
                    @endif
                    $('.cc').show();
                    $('#check').hide();
                    // $('#mailing').hide();
                    // $('.drinvoiceno').text('Invoice #');
                    $('#custodianblock').show();
                }

                if (this.value == 'check') {
                    @if ($dr == 1)
                        // $('#w-drcheckno').val('');
                        // $('#w-drcheckno').attr('readonly', false);
                    @elseif ($dr == 2)
                        // $('#w-drcheckno2').val('');
                        // $('#w-drcheckno2').attr('readonly', false);
                    @endif
                    $('#card_number').val('');
                    $('#card_number').attr('required', false);
                    $('.cc').hide();
                    $('.check').show();
                    $('#custodianblock').hide();
                    $('#custodian').val('');
                    $('#custodian-phone').val('');
                    // $('#check').show();
                    // $('#mailing').show();
                    // $('.drinvoiceno').text('Invoice #');
                }
            });

        });
    </script>

    <div class="row">
        <div class="col-auto">
            <h1>Workorder # {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }} {{ $workorder->W_LastName }}</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}" class="btn btn-sm btn-secondary">View Workorder</a>
        </div>
    </div>

    <h2>Payment</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">
            <form method="post" action="{{ route('user.workorders.paymentupdate', $workorder->W_WorkOrder) }}" id="">
                @csrf
                @method('PATCH')

                <input type="hidden" name="dr" value="{{ $dr }}">

                @php
                    $options = [
                        '' => '',
                        'unpaid' => 'unpaid',
                        'cc' => 'credit card',
                        'check' => 'check',
                    ];
                @endphp
                <x-form.select name="payment_type" label="Payment Type" id="payment_type" :options="$options" required />
                <br />

                <div class="cc">
                    <div class="bg-warning p-2">
                        @foreach ($creditcardinfos as $creditcardinfo)
                            Card: {{ $creditcardinfo->CC_No }}
                            <br />
                            Name: {{ $creditcardinfo->CC_Name }}
                            -
                            EXP: {{ $creditcardinfo->ExpDate }}
                            -
                            CVC: {{ $creditcardinfo->CVC_No }}
                            <br />
                            <br />
                        @endforeach
                    </div>

                    <br />

                    <x-form.select name="CC_No" label="Card Number" id="card_number" :options="$creditcardinfoslists" empty="-" />

                    <br />

                </div>

                @if ($dr == 1)

                    @if (floatval($workorder->W_DrFee1) < 1 || $usersession['contractor']['C_DrFeeUpdate'])
                        <x-form.input type="number" name="W_DrFee1" label="Dr Fee 1" :value="old('W_DrFee1', $workorder->W_DrFee1)" max="2000" step=".01" required />
                    @else
                        Dr Fee 1: $ {{ $workorder->W_DrFee1 }}
                        <input type="hidden" name="W_DrFee1" value="{{ $workorder->W_DrFee1 }}">
                        <br />
                    @endif

                    <br />
                    <div class="check">
                        <x-form.input name="payable" label="Payable To" :value="old('payable', $workorder->W_Hospital)" required />
                        <br />
                    </div>
                    <x-form.input name="W_DrCheckNo" label="Check / Card Info" :value="old('W_DrCheckNo', $workorder->W_DrCheckNo)" maxlength="15" />
                    <br />
                    <x-form.input name="W_DrCheckDate" label="Check / Card Date" :value="old('W_DrCheckDate', $workorder->W_DrCheckDate)" type="date" autocomplete="off" min="{{ date('Y-m-d', strtotime('-1 year')) }}" max="{{ date('Y-m-d', strtotime('+1 year')) }}" />
                    <br />
                    <div class="drinvoice">
                        <x-form.input name="W_DrInvoiceNo" label="Invoice Number" :value="old('W_DrInvoiceNo', $workorder->W_DrInvoiceNo)" maxlength="20" />
                        <br />
                    </div>
                @elseif ($dr == 2)
                    @if (floatval($workorder->W_DrFee2) < 1 || $usersession['contractor']['C_DrFeeUpdate'])
                        <x-form.input type="number" name="W_DrFee2" label="Dr Fee 2" :value="old('W_DrFee2', $workorder->W_DrFee2)" max="2000" step=".01" required />
                    @else
                        Dr Fee 2: $ {{ $workorder->W_DrFee2 }}
                        <input type="hidden" name="W_DrFee2" value="{{ $workorder->W_DrFee2 }}">
                        <br />
                    @endif

                    <br />
                    <div class="check">
                        <x-form.input name="payable" label="Payable To" :value="old('payable', $workorder->W_Hospital)" required />
                        <br />
                    </div>
                    <x-form.input name="W_DrCheckNo2" label="Check / Card Info" :value="old('W_DrCheckNo2')" maxlength="15" />
                    <br />
                    <x-form.input name="W_DrCheckDate2" label="Check / Card Date" :value="old('W_DrCheckDate2')" type="date" autocomplete="off" min="{{ date('Y-m-d', strtotime('-1 year')) }}" max="{{ date('Y-m-d', strtotime('+1 year')) }}" />
                    <br />
                    <div class="drinvoice">
                        <x-form.input name="W_DrInvoiceNo2" label="Invoice Number" :value="old('W_DrInvoiceNo2')" maxlength="20" />
                        <br />
                    </div>

                @endif

                <div class="check">
                    @php
                        $options = [
                            '' => '',
                            'mail' => 'mail',
                            'fedex' => 'fedex',
                        ];
                    @endphp
                    <x-form.select name="sendmethod" label="Check Send Method" id="sendmethod" :options="$options" />
                    <br />

                    <x-form.input name="mailing_address" label="Check Mailing Address" :value="old('mailing_address')" />
                    <br />
                </div>

                <div id="custodianblock">
                    <x-form.input name="custodian" label="Custodian Name" :value="old('custodian')" />
                    <br />
                    <x-form.input type="phone" name="custodian_phone" label="Custodian Phone" :value="old('custodian_phone')" />
                </div>

                <br />
                <br />
                <x-form.button>Submit</x-form.button>

            </form>
        </div>
    </div>

    <br />
    <br />

</x-user-layout>
