<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Edit Incoming APS Config</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.incoming_aps_configs.show', $incomingApsConfig->id) }}"
               class="btn btn-sm btn-secondary">View Incoming APS Configs</a>
        </div>
    </div>

    <br />

    <h2>{{ $incomingApsConfig->id }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('user.incoming_aps_configs.update', $incomingApsConfig->id) }}">
                @csrf
                @method('PATCH')

                <br />

                <x-form.input name="source"
                              id="source"
                              label="Source"
                              :value="old('source', $incomingApsConfig->source)"
                              required />
                <br />

                <x-form.input name="source_folder"
                              id="source_folder"
                              label="Source Folder"
                              :value="old('source_folder', $incomingApsConfig->source_folder)" />
                <br />

                <x-form.input name="destination_folder"
                              id="destination_folder"
                              label="Destination Folder"
                              :value="old('destination_folder', $incomingApsConfig->destination_folder)"
                              required />
                <br />

                <x-form.input name="back_up_folder"
                              id="back_up_folder"
                              label="Back Up Folder"
                              :value="old('back_up_folder', $incomingApsConfig->back_up_folder)"
                              required />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-user-layout>
