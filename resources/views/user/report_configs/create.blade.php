<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Create Report Config</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.report_configs.index') }}"
               class="btn btn-sm btn-secondary">View Report Configs</a>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('user.report_configs.store') }}">
                @csrf

                <x-form.input name="company"
                              id="company"
                              label="Company"
                              :value="old('company')"
                              required />
                <br />

                <x-form.input name="report_type"
                              id="report_type"
                              label="Report Type"
                              :value="old('report_type')" />
                <br />

                <x-form.input name="report_name"
                              id="report_name"
                              label="Report Name"
                              :value="old('report_name')"
                              required />
                <br />

                <x-form.input name="report_schedule"
                              id="report_schedule"
                              label="Report Schedule"
                              :value="old('report_schedule')"
                              required />
                <br />

                <x-form.input name="recipient_email"
                              id="recipient_email"
                              label="Recipient Email"
                              :value="old('recipient_email')"
                              required />
                <br />

                <x-form.input name="destination_folder"
                              id="destination_folder"
                              label="Destination Folder"
                              :value="old('destination_folder')"
                              required />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-user-layout>
