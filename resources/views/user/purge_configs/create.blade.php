<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Create Purge Config</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.purge_configs.index') }}"
               class="btn btn-sm btn-secondary">View Purge Configs</a>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('user.purge_configs.store') }}">
                @csrf

                <x-form.input name="company_name"
                              id="company_name"
                              label="Company Name"
                              :value="old('company_name')"
                              required />
                <br />

                <x-form.input name="folder_name"
                              id="folder_name"
                              label="Folder Name"
                              :value="old('folder_name')"
                              required />
                <br />

                <x-form.input name="source_path"
                              id="source_path"
                              label="Source Path"
                              :value="old('source_path')"
                              required />
                <br />

                <x-form.input name="destination_path"
                              id="destination_path"
                              label="Destination Path"
                              :value="old('destination_path')"
                              required />
                <br />

                <x-form.input name="frequency"
                              id="frequency"
                              label="Frequency"
                              :value="old('frequency')"
                              required />
                <br />

                <x-form.input name="purge_after_days"
                              type="number"
                              id="purge_after_days"
                              label="Purge After Days"
                              :value="old('purge_after_days')"
                              required
                              min="1"
                              max="730" />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-user-layout>
