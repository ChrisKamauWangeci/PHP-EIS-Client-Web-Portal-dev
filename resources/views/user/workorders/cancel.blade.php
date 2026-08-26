<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h2>Workorder: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }} {{ $workorder->W_MiddleInit }}
                {{ $workorder->W_LastName }}</h2>
        </div>
        <div class="col text-end">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}"
               class="btn btn-sm btn-secondary">View Workorder</a>
        </div>
    </div>

    <br />
    <br />

    <div class="row">
        <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4">

            <h3>Cancel Workorder</h3>

            <form method="post"
                  action="{{ route('user.workorders.cancelupdate', $workorder->W_WorkOrder) }}"
                  id="">
                @method('PATCH')
                @csrf

                <x-form.select name="reason"
                               id="reason"
                               label="Cancellation Reason"
                               :options="$cancelreasons"
                               empty="-"
                               :default="old('reason')"
                               required />
                <br />
                <x-form.checkbox name="confirm"
                                 label="Are you sure ?"
                                 required />
                <br />
                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-user-layout>
