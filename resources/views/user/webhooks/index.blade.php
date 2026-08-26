<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Webhooks</h1>
        </div>
    </div>

    <br />
    <br />

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('user.webhooks.index') }}">
        <div class="row">
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="id"
                              id="id"
                              label="ID"
                              :value="request('id')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="payload"
                              id="payload"
                              label="Payload"
                              :value="request('payload')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input type="date"
                              name="created_at_from"
                              id="created_at_from"
                              label="Created At (From)"
                              :value="request('created_at_from')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input type="date"
                              name="created_at_to"
                              id="created_at_to"
                              label="Created At (To)"
                              :value="request('created_at_to')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.webhooks.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <br />
    <br />

    {{ $webhooks->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover1 table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">ID</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'payload', 'sort_direction' => $sort_direction]) }}">Payload</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'status', 'sort_direction' => $sort_direction]) }}">Status</a>
                    </th>
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
                @foreach ($webhooks as $webhook)
                    <tr>
                        <td>{{ $webhook->id }}</td>
                        <td>{!! json_encode($webhook->payload, JSON_PRETTY_PRINT) !!}</td>
                        <td>{{ $webhook->status }}</td>
                        <td>{{ $webhook->created_at }}</td>
                        <td>{{ $webhook->updated_at }}</td>
                        <td>
                            <a href="{{ route('user.webhooks.show', $webhook->id) }}"
                               class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $webhooks->withQueryString()->links() }}

    <br />
    <br />


    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            webhooks
            @php dump(@$webhooks) @endphp
        </div>
    @endif

</x-user-layout>
