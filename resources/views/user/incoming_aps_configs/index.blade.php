<x-user-layout title="">

    <h1>Incoming APS Configs</h1>

    <br />
    <br />

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('user.incoming_aps_configs.index') }}">

        <div class="row">

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="source"
                              id="source"
                              label="Source"
                              :value="request('source')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="source_folder"
                              id="source_folder"
                              label="Source Folder"
                              :value="request('source_folder')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="destination_folder"
                              id="destination_folder"
                              label="Destination Folder"
                              :value="request('destination_folder')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.incoming_aps_configs.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $incomingApsConfigs->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'source', 'sort_direction' => $sort_direction]) }}">Source</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'source_folder', 'sort_direction' => $sort_direction]) }}">Source
                            Folder</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'destination_folder', 'sort_direction' => $sort_direction]) }}">Destination
                            Folder</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'back_up_folder', 'sort_direction' => $sort_direction]) }}">Back
                            Up Folder</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created
                            At</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_at', 'sort_direction' => $sort_direction]) }}">Updated
                            At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($incomingApsConfigs as $incomingApsConfig)
                    <tr>
                        <td>{{ $incomingApsConfig->id }}</td>
                        <td>{{ $incomingApsConfig->source }}</td>
                        <td>{{ $incomingApsConfig->source_folder }}</td>
                        <td>{{ $incomingApsConfig->destination_folder }}</td>
                        <td>{{ $incomingApsConfig->back_up_folder }}</td>
                        <td>{{ $incomingApsConfig->created_at }}</td>
                        <td>{{ $incomingApsConfig->updated_at }}</td>
                        <td>
                            <a href="{{ route('user.incoming_aps_configs.show', $incomingApsConfig->id) }}"
                               class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $incomingApsConfigs->withQueryString()->links() }}

    <br />
    <br />

    <a href="{{ route('user.incoming_aps_configs.create') }}"
       class="btn btn-sm btn-secondary">Add</a>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            incomingApsConfigs
            @php dump(@$incomingApsConfigs) @endphp
        </div>
    @endif

</x-user-layout>
