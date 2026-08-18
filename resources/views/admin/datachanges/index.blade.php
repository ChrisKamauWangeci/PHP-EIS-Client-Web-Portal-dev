<x-admin-layout title="">

    <h1>Data Changes</h1>

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('admin.datachanges.index') }}">

        <div class="row">

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="model" label="Model" :value="request('model')" maxlength="50" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="foreign_key" label="Foreign Key" :value="request('foreign_key')" maxlength="50" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="data" label="Data" :value="request('data')" maxlength="50" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="created_by" label="Created By" :value="request('created_by')" maxlength="50" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input type="date" name="created_at_from" label="Created From" :value="request('created_at_from')" autocomplete="off" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input type="date" name="created_at_to" label="Created To" :value="request('created_at_to')" autocomplete="off" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.datachanges.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $datachanges->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Model</th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'foreign_key', 'sort_direction' => $sort_direction]) }}">Foreign Key</a></th>
                    <th>Data</th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_by', 'sort_direction' => $sort_direction]) }}">Created By</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datachanges as $datachange)
                    <tr>
                        <td>{{ $datachange->id }}</td>
                        <td>{{ $datachange->model }}</td>
                        <td>{{ $datachange->foreign_key }}</td>
                        <td>{!! nl2br($datachange->data) !!}</td>
                        <td>{{ $datachange->created_by }}</td>
                        <td>{{ $datachange->created_at }}</td>
                        <td>
                            <a href="{{ route('admin.datachanges.show', $datachange->id) }}" class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $datachanges->withQueryString()->links() }}

    <br />

    <br />
    <br />

</x-admin-layout>