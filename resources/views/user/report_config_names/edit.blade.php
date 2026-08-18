<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Edit Report Config Name</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.report_config_names.show', $reportConfigName->id) }}" class="btn btn-sm btn-secondary">View Report Config Names</a>
        </div>
    </div>

    <br />

    <h2>{{ $reportConfigName->id }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('user.report_config_names.update', $reportConfigName->id ) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="report_name" id="report_name" label="Report Name" :value="old('report_name', $reportConfigName->report_name )" />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-user-layout>