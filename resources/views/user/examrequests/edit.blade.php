<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Edit Examrequest: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }}
                {{ $workorder->W_LastName }}</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}"
               class="btn btn-sm btn-secondary">View Workorder</a>
        </div>
    </div>

    <br />

    <div class="col-md-6">

        <form method="post"
              action="{{ route('user.examrequests.update', $examrequest->E_WorkOrder) }}">
            @csrf
            @method('PATCH')

            <x-form.input name="E_Address"
                          label="Address"
                          :value="old('E_Address', $examrequest->E_Address)"
                          required
                          maxlength="50" />
            <br />

            <x-form.input name="E_City"
                          label="City"
                          :value="old('E_City', $examrequest->E_City)"
                          required
                          maxlength="50" />
            <br />

            <x-form.select name="E_State"
                           label="State"
                           id="E_State"
                           :options="Helper::states()"
                           empty="-"
                           :default="$examrequest->E_State" />
            <br />

            <x-form.input name="E_Zip"
                          label="Zip Code"
                          :value="old('E_Zip', $examrequest->E_Zip)"
                          required
                          maxlength="10" />
            <br />

            <x-form.input name="E_HomePhone"
                          label="Home Phone"
                          :value="old('E_HomePhone', $examrequest->E_HomePhone)"
                          maxlength="14" />
            <br />

            <x-form.input name="E_CellPhone"
                          label="Cell Phone"
                          :value="old('E_CellPhone', $examrequest->E_CellPhone)"
                          maxlength="14" />
            <br />

            <x-form.input name="E_ApplicantEmail"
                          label="Email"
                          type="email"
                          :value="old('E_ApplicantEmail', $examrequest->E_ApplicantEmail)"
                          maxlength="80" />
            <br />

            <!-- <x-form.errors /> -->

            <x-form.button>Submit</x-form.button>

        </form>

    </div>

    <br />
    <br />

</x-user-layout>
