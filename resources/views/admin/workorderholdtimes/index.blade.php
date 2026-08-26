<x-admin-layout title="">

    <h1>Workorder Hold Times</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('admin.workorderholdtimes.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="workorder_id"
                              label="Workorder ID"
                              :value="request('workorder_id')"
                              type="number"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="reason"
                              label="Reason"
                              :value="request('reason')"
                              type="text"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="created_by"
                              label="Created By"
                              :value="request('created_by')"
                              type="text"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="modified_by"
                              label="Modified By"
                              :value="request('modified_by')"
                              type="text"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input type="date"
                              name="date_start"
                              label="Date Start"
                              :value="request('date_start')"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input type="date"
                              name="date_end"
                              label="Date End"
                              :value="request('date_end')"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.workorderholdtimes.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $workorderholdtimes->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">ID</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_id', 'sort_direction' => $sort_direction]) }}">Workorder
                            ID</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'hold_id', 'sort_direction' => $sort_direction]) }}">Hold
                            ID</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'reason', 'sort_direction' => $sort_direction]) }}">Reason</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'requirement', 'sort_direction' => $sort_direction]) }}">Requirement</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'date_start', 'sort_direction' => $sort_direction]) }}">Date
                            Start</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'date_end', 'sort_direction' => $sort_direction]) }}">Date
                            End</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_by', 'sort_direction' => $sort_direction]) }}">Created
                            By</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'modified_by', 'sort_direction' => $sort_direction]) }}">Modified
                            By</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created', 'sort_direction' => $sort_direction]) }}">Created</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'modified', 'sort_direction' => $sort_direction]) }}">Modified</a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workorderholdtimes as $workorderholdtime)
                    <tr>
                        <td>{{ $workorderholdtime->id }}</td>
                        <td>{{ $workorderholdtime->workorder_id }}</td>
                        <td>{{ $workorderholdtime->hold_id }}</td>
                        <td>{{ $workorderholdtime->reason }}</td>
                        <td>{{ $workorderholdtime->requirement }}</td>
                        <td>{{ $workorderholdtime->date_start?->format('Y-m-d') }}</td>
                        <td>{{ $workorderholdtime->date_end?->format('Y-m-d') }}</td>
                        <td>{{ $workorderholdtime->created_by }}</td>
                        <td>{{ $workorderholdtime->modified_by }}</td>
                        <td>{{ $workorderholdtime->created }}</td>
                        <td>{{ $workorderholdtime->modified }}</td>
                        <td>
                            <a href="{{ route('admin.workorderholdtimes.show', $workorderholdtime->id) }}"
                               class="btn btn-xs btn-secondary">view</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $workorderholdtimes->withQueryString()->links() }}

    <br />
    <br />

    <a href="{{ route('admin.workorderholdtimes.stats') }}"
       class="btn btn-sm btn-secondary">Stats</a>

    <br />
    <br />

</x-admin-layout>
