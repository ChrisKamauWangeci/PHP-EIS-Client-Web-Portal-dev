<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Workorder: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }} {{ $workorder->W_LastName }}</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}" class="btn btn-sm btn-secondary">View Workorder</a>
            <a href="{{ route('user.workorderfiles.show', $workorder->W_WorkOrder) }}" class="btn btn-sm btn-secondary">View Workorder Files</a>
        </div>
    </div>

    <br />

    <h2>Send Email</h2>

    <strong>{{ Str::headline($email_type ?? '') }}</strong>

    <br />
    <br />

    <div class="row">
        <div class="col-md-6">

            <form method="post" action="{{ route('user.emails.store') }}">
                @csrf

                <input type="hidden" name="workorder_id" value="{{ $workorder->W_WorkOrder }}">
                <input type="hidden" name="file" value="{{ $file }}">
                <input type="hidden" name="email_type" value="{{ $email_type }}">

                <x-form.input type="email" name="sender" id="sender" label="Sender" :value="old('sender', $sender)" required />
                <br />

                <x-form.input type="email" name="recipient" id="recipient" label="Recipient" :value="old('recipient', $recipient)" required />
                <br />

                <x-form.input type="subject" name="subject" id="subject" label="Subject" :value="old('subject', $subject)" required maxlength="80" />
                <br />

                <x-form.textarea name="body" id="body" label="Body" :value="old('body', $body)" rows="12" maxlength="500" />
                <br />

                @if ($file)
                    <br />
                    Attachment: <strong>{{ $file }}</strong>
                    @if (!$fileExist)
                        <div class="fw-bold text-danger">File not found! Cannot attach file!</div>
                    @else
                        <x-form.checkbox name="attachment" label="Send with attached file ?" checked />
                        <br />
                    @endif
                @endif

                <x-form.button>Submit</x-form.button>

            </form>

        </div>
    </div>

    <br />
    <br />
    <br />

    <h2>Sent Emails</h2>

    <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm table-hover w-auto small">
            <thead>
                <tr>
                    <th>Email Type</th>
                    <th>Contractor</th>
                    <th>Sender</th>
                    <th>Recipient</th>
                    <th>Subject</th>
                    <th>Body</th>
                    <th>Attachment</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($emails as $email)
                    <tr>
                        <td>{{ $email->type }}</td>
                        <td>{{ $email->contractor }}</td>
                        <td>{{ $email->sender }}</td>
                        <td>{{ $email->recipient }}</td>
                        <td>{{ $email->subject }}</td>
                        <td>{{ $email->body }}</td>
                        <td>{{ $email->attachment }}</td>
                        <td>{{ $email->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br />
    <br />

</x-user-layout>
