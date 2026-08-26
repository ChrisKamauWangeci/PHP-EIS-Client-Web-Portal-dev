<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Edit Purge Config</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.purge_configs.show', $purgeConfig->id) }}"
               class="btn btn-sm btn-secondary">View Purge Configs</a>
        </div>
    </div>

    <br />

    <h2>{{ $purgeConfig->id }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('user.purge_configs.update', $purgeConfig->id) }}">
                @csrf
                @method('PATCH')

                <br />

                <x-form.input name="company_name"
                              id="company_name"
                              label="company_name"
                              :value="old('company_name', $purgeConfig->company_name)"
                              required />
                <br />

                <x-form.input name="folder_name"
                              id="folder_name"
                              label="folder_name"
                              :value="old('folder_name', $purgeConfig->folder_name)" />
                <br />

                <x-form.input name="source_path"
                              id="source_path"
                              label="source_path"
                              :value="old('source_path', $purgeConfig->source_path)"
                              required />
                <br />

                <x-form.input name="destination_path"
                              id="destination_path"
                              label="destination_path"
                              :value="old('destination_path', $purgeConfig->destination_path)"
                              required />
                <br />

                <x-form.input name="frequency"
                              id="frequency"
                              label="frequency"
                              :value="old('frequency', $purgeConfig->frequency)"
                              required />
                <br />

                <x-form.input name="purge_after_days"
                              type="number"
                              id="purge_after_days"
                              label="purge_after_days"
                              :value="old('purge_after_days', $purgeConfig->purge_after_days)"
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
