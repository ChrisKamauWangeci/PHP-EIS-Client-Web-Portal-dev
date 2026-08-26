<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Create Incoming APS Config</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.incoming_aps_configs.index') }}"
               class="btn btn-sm btn-secondary">View Incoming APS Configs</a>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('user.incoming_aps_configs.store') }}">
                @csrf

                <x-form.input name="source"
                              id="source"
                              label="source"
                              :value="old('source')"
                              required />
                <br />

                <x-form.input name="source_folder"
                              id="source_folder"
                              label="source_folder"
                              :value="old('source_folder')"
                              required />
                <br />

                <x-form.input name="destination_folder"
                              id="destination_folder"
                              label="destination_folder"
                              :value="old('destination_folder')"
                              required />
                <br />

                <x-form.input name="back_up_folder"
                              id="back_up_folder"
                              label="back_up_folder"
                              :value="old('back_up_folder')"
                              required />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-user-layout>
