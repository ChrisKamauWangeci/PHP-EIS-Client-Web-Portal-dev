<x-user-layout title="">

    <h1>Emails</h1>

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('user.emails.index') }}">

        <div class="row">

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="workorder_id" label="Workorder ID" :value="request('workorder_id')" type="number" autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="type" label="Type" :value="request('type')" autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="contractor" label="Contractor" :value="request('contractor')" autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="recipient" label="Recipient" :value="request('recipient')" autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="subject" label="Subject" :value="request('subject')" autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.emails.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $emails->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_id', 'sort_direction' => $sort_direction]) }}">Workorder</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'type', 'sort_direction' => $sort_direction]) }}">Type</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'contractor', 'sort_direction' => $sort_direction]) }}">Contractor</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'recipient', 'sort_direction' => $sort_direction]) }}">Recipient</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'subject', 'sort_direction' => $sort_direction]) }}">Subject</a></th>
                    <th>Attachment</th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($emails as $email)
                    <tr>
                        <td><a href="{{ route('user.workorders.show', $email->workorder_id) }}">{{ $email->workorder_id }}</a></td>
                        <td>{{ $email->type }}</td>
                        <td>{{ $email->contractor }}</td>
                        <td>{{ $email->recipient }}</td>
                        <td>{{ $email->subject }}</td>
                        <td>{{ basename($email->attachment ?? '') }}</td>
                        <td>{{ $email->created_at }}</td>
                        <td><a href="{{ route('user.emails.show', $email->id) }}" class="btn btn-xs btn-secondary">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $emails->withQueryString()->links() }}

    <br />
    <br />

</x-user-layout>