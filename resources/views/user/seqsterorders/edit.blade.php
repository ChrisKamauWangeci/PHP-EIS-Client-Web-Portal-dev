<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Edit Seqster Order</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.seqsterorders.index') }}" class="btn btn-sm btn-secondary">View Seqster Orders</a>
            <a href="{{ route('user.seqsterorders.show', $seqsterorder->id) }}" class="btn btn-sm btn-secondary">View Seqster Order</a>
        </div>
    </div>

    <br />

    <h2>{{ $seqsterorder->first_name }} {{ $seqsterorder->last_name }} </h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('user.seqsterorders.update', $seqsterorder->id ) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="project_title" label="project_title" :value="old('project_title', $seqsterorder->project_title )" />
                <br />

                <x-form.input name="site_name" label="site_name" :value="old('site_name', $seqsterorder->site_name )" />
                <br />


                <x-form.input name="company" label="company" :value="old('company', $seqsterorder->company )" />
                <br />

                <x-form.input name="workorder_id" label="workorder_id" :value="old('workorder_id', $seqsterorder->workorder_id )" />
                <br />

                <x-form.input name="patient_id" label="patient_id" :value="old('patient_id', $seqsterorder->patient_id )" />
                <br />

                <x-form.input name="email" label="email" :value="old('email', $seqsterorder->email )" />
                <br />

                <x-form.input name="postal_code" label="postal_code" :value="old('postal_code', $seqsterorder->postal_code )" />
                <br />

                <x-form.input name="status" label="status" :value="old('status', $seqsterorder->status )" />
                <br />

                <x-form.input name="birthday" label="birthday" :value="old('birthday', $seqsterorder->birthday )" />
                <br />

                <x-form.textarea name="api_error" id="api_error" label="API Error" :value="old('api_error', $seqsterorder->api_error)" :rows="5" minlength="5" maxlength="50000" />
                <br />

                <x-form.input type="datetime-local" name="emailed_at" label="emailed_at" :value="old('emailed_at', $seqsterorder->emailed_at )" />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />
    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            seqsterorder
            @php dump(@$seqsterorder) @endphp
        </div>
    @endif

</x-user-layout>