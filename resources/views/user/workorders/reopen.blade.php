<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h2>Workorder: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }} {{ $workorder->W_MiddleInit }} {{ $workorder->W_LastName }}</h2>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}" class="btn btn-sm btn-secondary">View Workorder</a>
        </div>
    </div>

    <br />
    <br />

    <div class="row">
        <div class="col-sm-6">

            <h2>Reopen Workorder # {{ $workorder->W_WorkOrder }}</h2>
            <h3>{{ $workorder->W_FirstName }} {{ $workorder->W_LastName }}</h3>

            <br />

            <form method="post" action="{{ route('user.workorders.reopenupdate', $workorder->W_WorkOrder) }}" id="">
                @method('PATCH')
                @csrf
                <x-form.select name="reason" label="Reopen Reason" id="reason" :options="$reasons" empty="-" :default="old('reason')" required />
                <br />
                <x-form.checkbox name="confirm" label="Are you sure ?" required />
                <br />

                @if ($requestor->R_Company == 'MASSMUTUAL')
                    <input type="hidden" name="underwriteremail" value="{{ $underwriteremail }}" />
                    @if ($underwriteremail)
                        <div class="alert alert-info">
                            MASSMUTUAL
                            <br />
                            Please note that reopening this workorder will trigger an email notification to the underwriter, {{ $underwriteremail }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            MASSMUTUAL
                            <br />
                            Missing underwriter email address.
                        </div>
                    @endif
                @endif

                <br />
                <x-form.button>Submit</x-form.button>

            </form>

        </div>
    </div>

    <br />
    <br />

</x-user-layout>
