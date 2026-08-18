<x-user-layout title="">

    <h1>Seqster Orders</h1>

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('user.seqsterorders.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="project_title" label="Project Title" :value="request('project_title')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="workorder_id" label="Workorder ID" :value="request('workorder_id')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="patient_id" label="Patient ID" :value="request('patient_id')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="company" label="Company" :value="request('company')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="first_name" label="First Name" :value="request('first_name')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="last_name" label="Last Name" :value="request('last_name')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="email" label="Email" :value="request('email')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="status" label="Status" :value="request('status')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="createdfrom" label="Created From" :value="request('createdfrom')" type="date" autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="createdto" label="Created To" :value="request('createdto')" type="date" autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.seqsterorders.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $seqsterorders->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">ID</a></th>
                    <th>
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'project_title', 'sort_direction' => $sort_direction]) }}">Project Title</a>
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'site_name', 'sort_direction' => $sort_direction]) }}">Site Name</a>
                    </th>
                    <th>
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_id', 'sort_direction' => $sort_direction]) }}">Workorder ID</a>
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'patient_id', 'sort_direction' => $sort_direction]) }}">Patient ID</a>
                    </th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'company', 'sort_direction' => $sort_direction]) }}">Company</a></th>
                    <th>
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'first_name', 'sort_direction' => $sort_direction]) }}">First Name</a>
                        <br />
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'last_name', 'sort_direction' => $sort_direction]) }}">Last Name</a>
                        <br />
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'email', 'sort_direction' => $sort_direction]) }}">Email</a>
                        <br />
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'gender', 'sort_direction' => $sort_direction]) }}">Gender</a>
                        <br />
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'birthday', 'sort_direction' => $sort_direction]) }}">Birthday</a>
                    </th>
                    <th>
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'address_1', 'sort_direction' => $sort_direction]) }}">Address 1</a>
                        <br />
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'city', 'sort_direction' => $sort_direction]) }}">City</a>
                        <br />
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'state', 'sort_direction' => $sort_direction]) }}">State</a>
                        <br />
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'postal_code', 'sort_direction' => $sort_direction]) }}">Postal Code</a>
                    </th>
                    <th>
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'status', 'sort_direction' => $sort_direction]) }}">Status</a>
                        <br />
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'statusapi', 'sort_direction' => $sort_direction]) }}">Status API</a>
                    </th>
                    <th>
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'seqster_at', 'sort_direction' => $sort_direction]) }}">Seqster At</a>
                        <br />
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'emailed_at', 'sort_direction' => $sort_direction]) }}">Emailed At</a>
                        <br />
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'reminded_at', 'sort_direction' => $sort_direction]) }}">Reminded At</a>
                        <br />
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'email_viewed_count', 'sort_direction' => $sort_direction]) }}">Email Viewed Count</a>
                    </th>
                    <th>
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'visited_at', 'sort_direction' => $sort_direction]) }}">Visited At</a>
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'visit_count', 'sort_direction' => $sort_direction]) }}">Visit Count</a>
                    </th>
                    <th>
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created', 'sort_direction' => $sort_direction]) }}">Created</a>
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'modified', 'sort_direction' => $sort_direction]) }}">Modified</a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($seqsterorders as $seqsterorder)
                    <tr>
                        <td>{{ $seqsterorder->id }}</td>
                        <td>
                            {{ $seqsterorder->project_title }}
                            <br />
                            {{ $seqsterorder->site_name }}
                        </td>
                        <td>
                            {{ $seqsterorder->workorder_id }}
                            <br />
                            {{ $seqsterorder->patient_id }}
                        </td>
                        <td>{{ $seqsterorder->company }}</td>
                        <td>
                            {{ $seqsterorder->first_name }}
                            {{ $seqsterorder->last_name }}
                            <br />
                            {{ $seqsterorder->email }}
                            <br />
                            {{ $seqsterorder->gender }}
                            <br />
                            {{ $seqsterorder->birthday }}
                        </td>
                        <td>
                            {{ $seqsterorder->address_1 }}
                            <br />
                            {{ $seqsterorder->city }}
                            <br />
                            {{ $seqsterorder->state }}
                            {{ $seqsterorder->postal_code }}
                        </td>
                        <td>
                            {{ $seqsterorder->status }}
                            <br />
                            {{ $seqsterorder->statusapi }}
                        </td>
                        <td nowrap>
                            {{ $seqsterorder->seqster_at }}
                            <br />
                            {{ $seqsterorder->emailed_at }}
                            <br />
                            {{ $seqsterorder->reminded_at }}
                            <br />
                            {{ $seqsterorder->email_viewed_count }}
                        </td>
                        <td nowrap>
                            {{ $seqsterorder->visited_at }}
                            <br />
                            {{ $seqsterorder->visit_count }}
                        </td>
                        <td nowrap>
                            {{ $seqsterorder->created }}
                            <br />
                            {{ $seqsterorder->modified }}
                        </td>
                        <td>
                            <a href="{{ route('user.seqsterorders.show', $seqsterorder->id) }}" class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>

                    @if ($seqsterorder->seqster_providers)
                    <tr>
                        <td colspan="10" class="bg-success bg-opacity-50"><pre>{{ $seqsterorder->seqster_providers }}</pre></td>
                    </tr>
                    @endif

                    @if ($seqsterorder->api_error)
                    <tr>
                        <td colspan="10" class="bg-danger bg-opacity-50"><pre>{{ $seqsterorder->api_error }}</pre></td>
                    </tr>
                    @endif

                @endforeach
            </tbody>
        </table>
    </div>

    {{ $seqsterorders->withQueryString()->links() }}

    <br />
    <br />

    <a href="{{ route('user.seqsterorders.stats') }}" class="btn btn-sm btn-secondary">Stats</a>

    <br />
    <br />

</x-user-layout>