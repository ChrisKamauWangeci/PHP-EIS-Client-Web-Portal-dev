<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>EHR Order</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.ehrorders.index') }}"
               class="btn btn-sm btn-secondary">View EHR Orders</a>
            <a href="{{ route('user.ehrorderssearchresults.index') }}"
               class="btn btn-sm btn-secondary">View EHR Order Search Results</a>
            <a href="{{ route('user.ehrordersdocuments.index') }}"
               class="btn btn-sm btn-secondary">View EHR Order Documents</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>Workorder ID</td>
            <td>{{ $ehrorder->workorder_id }}</td>
        </tr>
        <tr>
            <td>Company Name</td>
            <td>{{ $ehrorder->company_name }}</td>
        </tr>
        <tr>
            <td>Service Provider</td>
            <td>{{ $ehrorder->service_provider }}</td>
        </tr>
        <tr>
            <td>UUID</td>
            <td>{{ $ehrorder->uuid }}</td>
        </tr>
        <tr>
            <td>First Name</td>
            <td>{{ $ehrorder->first_name }}</td>
        </tr>
        <tr>
            <td>Middle Name</td>
            <td>{{ $ehrorder->middle_name }}</td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td>{{ $ehrorder->last_name }}</td>
        </tr>
        <tr>
            <td>Social Security Number</td>
            <td>{{ $ehrorder->social_security_number }}</td>
        </tr>
        <tr>
            <td>Gender</td>
            <td>{{ $ehrorder->gender }}</td>
        </tr>
        <tr>
            <td>Birth Date</td>
            <td>{{ $ehrorder->birth_date }}</td>
        </tr>
        <tr>
            <td>Home Phone</td>
            <td>{{ $ehrorder->home_phone }}</td>
        </tr>
        <tr>
            <td>Cell Phone</td>
            <td>{{ $ehrorder->cell_phone }}</td>
        </tr>
        <tr>
            <td>Email Address</td>
            <td>{{ $ehrorder->email_address }}</td>
        </tr>
        <tr>
            <td>Address</td>
            <td>{{ $ehrorder->address }}</td>
        </tr>
        <tr>
            <td>Address 2</td>
            <td>{{ $ehrorder->address_2 }}</td>
        </tr>
        <tr>
            <td>City</td>
            <td>{{ $ehrorder->city }}</td>
        </tr>
        <tr>
            <td>State</td>
            <td>{{ $ehrorder->state }}</td>
        </tr>
        <tr>
            <td>Zip Code</td>
            <td>{{ $ehrorder->zip_code }}</td>
        </tr>
        <tr>
            <td>Date Of Service From</td>
            <td>{{ $ehrorder->date_of_service_from }}</td>
        </tr>
        <tr>
            <td>Date Of Service To</td>
            <td>{{ $ehrorder->date_of_service_to }}</td>
        </tr>
        <tr>
            <td>Auth File</td>
            <td>
                <a href="/user/files?file={{ $ehrorder->auth_file_path }}&amp;download=0"
                   target="_blank"
                   class="">{{ $ehrorder->auth_file_path }}</a>
            </td>
        </tr>
        @if ($ehrorder->service_provider == 'epic')
            <tr>
                <td>Epic - Coverpage + Auth File</td>
                <td>
                    <a href="/user/files?file=\\FTPSERVER2\ftpserver\eis\coverpage_auth\{{ $ehrorder->created_at->format('Ymd') }}\{{ $ehrorder->id }}-coverpage_auth.pdf&amp;download=0"
                       target="_blank"
                       class="">\\FTPSERVER2\ftpserver\eis\coverpage_auth\{{ $ehrorder->created_at->format('Ymd') }}\{{ $ehrorder->id }}-coverpage_auth.pdf</a>
                </td>
            </tr>
        @endif
        <tr>
            <td>FHIR Patient ID</td>
            <td>{{ $ehrorder->fhir_patient_id }}</td>
        </tr>
        <tr>
            <td>Submission Type</td>
            <td>{{ $ehrorder->submission_type }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>{{ $ehrorder->status }}</td>
        </tr>
        <tr>
            <td>Error Message</td>
            <td>{{ $ehrorder->error_message }}</td>
        </tr>
        <tr>
            <td>Created By</td>
            <td>{{ $ehrorder->created_by }}</td>
        </tr>
        <tr>
            <td>Updated By</td>
            <td>{{ $ehrorder->updated_by }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $ehrorder->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $ehrorder->updated_at }}</td>
        </tr>
    </table>

    <br />

    <h2>EHR Order Search Results</h2>

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>EHR Order ID</th>
                    <th>Workorder ID</th>
                    <th>Managing Organization</th>
                    <th>Last Name</th>
                    <th>Consent Required</th>
                    <th>Status</th>
                    <th>Operation Outcome</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th>Submitted At</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ehrorderssearchresults as $ehrorderssearchresult)
                    <tr>
                        <td>{{ $ehrorderssearchresult->id }}</td>
                        <td>{{ $ehrorderssearchresult->ehrorder_id }}</td>
                        <td>{{ $ehrorderssearchresult->workorder_id }}</td>
                        <td>
                            {{ $ehrorderssearchresult->managing_organization }}
                            <br />
                            {{ $ehrorderssearchresult->organization_reference }}
                        </td>
                        <td>{{ $ehrorderssearchresult->ehrorder->last_name }}</td>
                        <td>{{ $ehrorderssearchresult->consent_required ? 'yes' : '' }}</td>
                        <td>{{ $ehrorderssearchresult->status }}</td>
                        <td class="{{ !empty($ehrorderssearchresult->operation_outcome) ? 'bg-danger-subtle' : '' }}">
                            {{ $ehrorderssearchresult->operation_outcome }}
                            {{ $ehrorderssearchresult->operation_outcome_at?->format('m/d/Y H:i:s') }}
                        </td>
                        <td>{{ $ehrorderssearchresult->created_by }}</td>
                        <td>{{ $ehrorderssearchresult->updated_by }}</td>
                        <td>{{ $ehrorderssearchresult->submitted_at?->format('m/d/Y H:i:s') }}</td>
                        <td>{{ $ehrorderssearchresult->created_at->format('m/d/Y H:i:s') }}</td>
                        <td>{{ $ehrorderssearchresult->updated_at->format('m/d/Y H:i:s') }}</td>
                        <td>
                            <a href="{{ route('user.ehrorderssearchresults.show', $ehrorderssearchresult->id) }}"
                               class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br />
    <br />

    <h2>EHR Order Documents</h2>

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>EHR Order ID</th>
                    <th>EHR Orders Search Result ID</th>
                    <th>Workorder ID</th>
                    <th>Custodian</th>
                    <th>Name</th>
                    <th>File Type</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th>Received At</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ehrordersdocuments as $ehrordersdocument)
                    <tr>
                        <td>{{ $ehrordersdocument->id }}</td>
                        <td>{{ $ehrordersdocument->ehrorder_id }}</td>
                        <td>{{ $ehrordersdocument->ehrorderssearchresult_id }}</td>
                        <td>{{ $ehrordersdocument->workorder_id }}</td>
                        <td>{{ $ehrordersdocument->custodian }}</td>
                        <td>{{ $ehrordersdocument->name }}</td>
                        <td>{{ $ehrordersdocument->file_type }}</td>
                        <td>{{ $ehrordersdocument->status }}</td>
                        <td>{{ $ehrordersdocument->created_by }}</td>
                        <td>{{ $ehrordersdocument->updated_by }}</td>
                        <td>{{ $ehrordersdocument->received_at?->format('m/d/Y H:i:s') }}</td>
                        <td>{{ $ehrordersdocument->created_at->format('m/d/Y H:i:s') }}</td>
                        <td>{{ $ehrordersdocument->updated_at->format('m/d/Y H:i:s') }}</td>
                        <td>
                            <a href="{{ route('user.ehrordersdocuments.show', $ehrordersdocument->id) }}"
                               class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br />

    <a href="{{ route('user.ehrorders.edit', $ehrorder->id) }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <a href="{{ route('user.ehrorders.coverpage', $ehrorder->id) }}"
       class="btn btn-sm btn-secondary">Cover Page</a>

    <br />
    <br />

    <h2>Patient Search File</h2>

    @if ($patientsearch)
        {{ $patientSearchFile }}
        <pre>{{ $patientsearch }}</pre>
    @else
        <p class="text-muted">No patient search file found for this EHR order.</p>
    @endif

    <br />
    <br />

    @if ($ehrorder->service_provider == 'fasten_health')
        <div class="row">
            <div class="col-10 col-sm-8 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">SMART Access - Fasten Health</h5>

                        <a href="{{ route('user.ehrorders.invitationemailfasten', $ehrorder->id) }}"
                           target="_blank"
                           class="btn btn-sm btn-secondary">
                            Preview Invitation Email
                        </a>

                        <!-- <br />
                        <br />

                        <a href="{{ route('user.ehrorders.invitationemailfasten', [$ehrorder->id, 'view' => 'new']) }}"
                            target="_blank"
                            class="btn btn-sm btn-secondary">
                            Preview Invitation Email - New Version
                        </a> -->

                        <br />
                        <br />

                        <form method="POST"
                              action="{{ route('user.ehrorders.invitationemailfasten', $ehrorder->id) }}">
                            @csrf
                            <button type="submit"
                                    class="btn btn-sm btn-secondary"
                                    onclick="return confirm('Are you sure?')">Send Invitation Email</button>
                        </form>

                        <!-- <br /> -->

                        <!-- <form method="POST" action="{{ route('user.ehrorders.invitationemailfasten', [$ehrorder->id, 'version' => 'new']) }}">
                            @csrf
                            <input type="hidden" name="view" value="new">
                            <button type="submit" class="btn btn-sm btn-secondary" onclick="return confirm('Are you sure?')">Send Invitation Email - New Version</button>
                        </form> -->

                    </div>
                </div>
            </div>
        </div>
    @endif

    <br />

    {{-- <form method="POST" action="{{ route('user.ehrorders.destroy', $ehrorder->id) }}">
        @csrf
        @method('DELETE')
        <x-form.button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</x-form.button>
    </form> --}}

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            ehrorder
            @php dump(@$ehrorder); @endphp
        </div>
    @endif

</x-user-layout>
