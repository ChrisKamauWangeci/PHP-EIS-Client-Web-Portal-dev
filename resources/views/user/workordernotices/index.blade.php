<x-user-layout title="">

    <h1>Workorder Notices</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('user.workordernotices.index') }}">

        <div class="row">

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="workorder_id"
                              label="Workorder ID"
                              :value="request('workorder_id')"
                              type="number"
                              autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="type"
                              label="Type"
                              :value="request('type')"
                              autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="contractor"
                              label="Contractor"
                              :value="request('contractor')"
                              autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="recipient"
                              label="Recipient"
                              :value="request('recipient')"
                              autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="subject"
                              label="Subject"
                              :value="request('subject')"
                              autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.workordernotices.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $workordernotices->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_id', 'sort_direction' => $sort_direction]) }}">Workorder</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'type', 'sort_direction' => $sort_direction]) }}">Type</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'user_before', 'sort_direction' => $sort_direction]) }}">User
                            Before</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'user_after', 'sort_direction' => $sort_direction]) }}">User
                            After</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'recipient', 'sort_direction' => $sort_direction]) }}">Recipient</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'subject', 'sort_direction' => $sort_direction]) }}">Subject</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_by', 'sort_direction' => $sort_direction]) }}">Created
                            By</a></th>
                    <th nowrap>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created
                            At</a>
                        <br />
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'emailed_at', 'sort_direction' => $sort_direction]) }}">Emailed
                            At</a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workordernotices as $workordernotice)
                    <tr>
                        <td><a
                               href="{{ route('user.workorders.show', $workordernotice->workorder_id) }}">{{ $workordernotice->workorder_id }}</a>
                        </td>
                        <td>{{ $workordernotice->type }}</td>
                        <td>{{ $workordernotice->user_before }}</td>
                        <td>{{ $workordernotice->user_after }}</td>
                        <td>{{ $workordernotice->recipient }}</td>
                        <td>{{ $workordernotice->subject }}</td>
                        <td>{{ $workordernotice->created_by }}</td>
                        <td nowrap>
                            {{ $workordernotice->created_at }}
                            <br />
                            {{ $workordernotice->emailed_at }}
                        </td>
                        <td><a href="{{ route('user.workordernotices.show', $workordernotice->id) }}"
                               class="btn btn-xs btn-secondary">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $workordernotices->withQueryString()->links() }}

    <br />
    <br />

</x-user-layout>
