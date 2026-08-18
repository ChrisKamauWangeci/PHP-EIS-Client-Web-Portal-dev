<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Create Report Config</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.report_config_names.index') }}" class="btn btn-sm btn-secondary">View Report Configs</a>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('user.report_config_names.store') }}">
                @csrf

                <x-form.input name="report_name" id="report_name" label="Report Name" :value="old('report_name')" />

                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-user-layout>