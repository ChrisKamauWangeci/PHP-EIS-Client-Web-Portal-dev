<x-user-layout title="">

    <h1>Status Triggers</h1>


    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('user.statustriggers.index') }}">

        <div class="row">

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="WorkOrderNo" label="Workorder" :value="request('WorkOrderNo')" maxlength="50" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="laststatus" label="Last Status" :value="request('laststatus')" maxlength="50" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="CreatedBy" label="Created By" :value="request('CreatedBy')" maxlength="50" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="createdfrom" label="Created From" :value="request('createdfrom')" type="date" autocomplete="off" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="createdto" label="Created To" :value="request('createdto')" type="date" autocomplete="off" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.statustriggers.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $statustriggers->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'WorkOrderNo', 'sort_direction' => $sort_direction]) }}">Workorder</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'ChangeType', 'sort_direction' => $sort_direction]) }}">Change Type</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'laststatus', 'sort_direction' => $sort_direction]) }}">Last Status</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'CreatedBy', 'sort_direction' => $sort_direction]) }}">Created By</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'Created', 'sort_direction' => $sort_direction]) }}">Created</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statustriggers as $statustrigger)
                    <tr>
                        <td>{{ $statustrigger->ID }}</td>
                        <td>
                            <a href="{{ route('user.workorders.show', $statustrigger->WorkOrderNo) }}">{{ $statustrigger->WorkOrderNo }}</a>
                        </td>
                        <td>{{ $statustrigger->ChangeType }}</td>
                        <td>{!! nl2br(e($statustrigger->laststatus ?? '')) !!}</td>
                        <td>{{ $statustrigger->CreatedBy }}</td>
                        <td>{{ $statustrigger->Created }}</td>
                        <td>
                            <a href="{{ route('user.statustriggers.show', $statustrigger->ID) }}" class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $statustriggers->withQueryString()->links() }}

    <br />

    <br />
    <br />

</x-user-layout>