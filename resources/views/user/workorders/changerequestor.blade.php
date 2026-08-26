<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Change Company / Requestor for Workorder: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }}
                {{ $workorder->W_LastName }}</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}"
               class="btn btn-sm btn-secondary">View Workorder</a>
        </div>
    </div>

    <br />

    {{-- @dump($workorder) --}}

    <div class="col-md-6">

        <form method="post"
              action="{{ route('user.workorders.changerequestorupdate', $workorder->W_WorkOrder) }}">
            @csrf
            @method('PATCH')

            Current Company:
            <br />
            <div class="fw-bold text-danger">{{ $workorder->requestor_company }}</div>
            Current Requestor:
            <br />
            <div class="fw-bold text-danger">{{ $workorder->requestor_name }}</div>
            <br />

            <br />

            New Company: <div id="company"
                 class="fw-bold text-success"></div>
            <br />

            <x-form.input hx-get="{{ route('user.requestors.autocomplete') }}"
                          hx-trigger="input[target.value.length > 1] delay:500ms"
                          hx-target="#requestor-list"
                          hx-indicator="#spinner"
                          hx-on:blur="setTimeout(() => document.getElementById('requestor-list').innerHTML = '', 200)"
                          name="W_Requestor"
                          label="New Requestor"
                          type="text"
                          :value="old('W_Requestor', $workorder->W_Requestor)"
                          maxlength="100"
                          required />

            <div id="requestor-list"
                 class="list-group shadow"></div>

            <br />
            <br />

            <x-form.checkbox name="confirn"
                             label="Are you sure? This will change the associated company and the requestor."
                             required />

            <br />

            <x-form.errors />

            <x-form.button>Submit</x-form.button>

            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}"
               class="btn btn-sm btn-light">Cancel</a>

        </form>

    </div>

    <br />
    <br />

</x-user-layout>
