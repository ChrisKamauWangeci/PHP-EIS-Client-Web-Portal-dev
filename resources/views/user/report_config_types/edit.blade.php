<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Edit Report Config Type</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.report_config_types.show', $reportConfigType->id) }}"
               class="btn btn-sm btn-secondary">View Report Config Types</a>
        </div>
    </div>

    <br />

    <h2>{{ $reportConfigType->id }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('user.report_config_types.update', $reportConfigType->id) }}">
                @csrf
                @method('PATCH')

                <x-form.inputl name="report_type"
                               id="report_type"
                               label="Report Type"
                               :value="old('report_type', $reportConfigType->report_type)" />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-user-layout>
