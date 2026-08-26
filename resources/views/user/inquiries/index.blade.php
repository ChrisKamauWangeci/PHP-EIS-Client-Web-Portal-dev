<x-user-layout title="">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(
                tooltipTriggerEl));
        });
    </script>

    <div class="row">
        <div class="col-6">
            <h1>Inquiries</h1>
        </div>
        <div class="col-6 text-end">

        </div>
    </div>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('user.inquiries.index') }}">

        <div class="row">

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="workorder"
                              id="workorder"
                              label="Workorder"
                              :value="request('workorder')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="name"
                              id="name"
                              label="Applicant Name"
                              :value="request('name')" />
            </div>


            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="company"
                              id="company"
                              label="Company"
                              :value="request('company')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="requestor"
                              id="requestor"
                              label="Requestor"
                              :value="request('requestor')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="accountmanager"
                              id="accountmanager"
                              label="Account Manager"
                              :value="request('accountmanager')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="accountmanageremail"
                              id="accountmanageremail"
                              label="Account Manager Email"
                              :value="request('accountmanageremail')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.inquiries.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $inquiries->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">ID</a>
                    </th>
                    <th>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'accountmanager', 'sort_direction' => $sort_direction]) }}">Account
                            Manager</a>
                        <br />
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'accountmanageremail', 'sort_direction' => $sort_direction]) }}">Account
                            Manager Email</a>
                    </th>
                    <th>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'company', 'sort_direction' => $sort_direction]) }}">Company</a>
                        <br />
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'requestor', 'sort_direction' => $sort_direction]) }}">Requestor</a>
                        <br />
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'email', 'sort_direction' => $sort_direction]) }}">Email</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder', 'sort_direction' => $sort_direction]) }}">Workorder</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'name', 'sort_direction' => $sort_direction]) }}">Applicant
                            Name</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'message', 'sort_direction' => $sort_direction]) }}">Message</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created
                            At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inquiries as $inquiry)
                    <tr>
                        <td>{{ $inquiry->id }}</td>
                        <td>
                            {{ $inquiry->accountmanager }}
                            <br />
                            {{ $inquiry->accountmanageremail }}
                        </td>
                        <td>
                            {{ $inquiry->company }}
                            <br />
                            {{ $inquiry->requestor }}
                            <br />
                            {{ $inquiry->email }}
                        </td>
                        <td>
                            <a
                               href="{{ route('user.workorders.show', $inquiry->workorder) }}">{{ $inquiry->workorder }}</a>
                        </td>
                        <td>{{ $inquiry->name }}</td>
                        <td>
                            <span data-bs-toggle="tooltip"
                                  data-bs-placement="left"
                                  data-bs-html="true"
                                  data-bs-title="{{ $inquiry->message ?? '-' }}">
                                {{ Str::limit($inquiry->message ?? '-', 100) }}
                            </span>
                        </td>
                        <td>{{ $inquiry->created_at }}</td>
                        <td class="actions">
                            <a href="{{ route('user.inquiries.show', $inquiry->id) }}"
                               class="btn btn-xs btn-secondary">view</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $inquiries->withQueryString()->links() }}

</x-user-layout>
