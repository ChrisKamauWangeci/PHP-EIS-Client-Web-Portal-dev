<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Docusign Document</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.docusigndocuments.index') }}"
               class="btn btn-sm btn-secondary">View Docusign Documents</a>
        </div>
    </div>

    <br />

    <table class="table table-bordered table-sm w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $docusigndocument->id }}</td>
        </tr>
        <tr>
            <td>Envelope ID</td>
            <td>{{ $docusigndocument->envelopeid }}</td>
        </tr>
        <tr>
            <td>Template ID</td>
            <td>{{ $docusigndocument->templateid }}</td>
        </tr>
        <tr>
            <td>Environment</td>
            <td>{{ $docusigndocument->environment }}</td>
        </tr>
        <tr>
            <td>Signing Type</td>
            <td>{{ $docusigndocument->signingtype }}</td>
        </tr>
        <tr>
            <td>Slug</td>
            <td>{{ $docusigndocument->slug }}</td>
        </tr>
        <tr>
            <td>DB</td>
            <td>{{ $docusigndocument->db }}</td>
        </tr>
        <tr>
            <td>Workorder ID</td>
            <td>{{ $docusigndocument->workorder_id }}</td>
        </tr>
        <tr>
            <td>Client</td>
            <td>{{ $docusigndocument->client }}</td>
        </tr>
        <tr>
            <td>Company</td>
            <td>{{ $docusigndocument->company }}</td>
        </tr>
        <tr>
            <td>Requestor</td>
            <td>{{ $docusigndocument->requestor }}</td>
        </tr>
        <tr>
            <td>First Name</td>
            <td>{{ $docusigndocument->first_name }}</td>
        </tr>
        <tr>
            <td>Middle Name</td>
            <td>{{ $docusigndocument->middle_name }}</td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td>{{ $docusigndocument->last_name }}</td>
        </tr>
        <tr>
            <td>Social Security</td>
            <td>{{ $docusigndocument->social_security }}</td>
        </tr>
        <tr>
            <td>Birth Date</td>
            <td>{{ $docusigndocument->birth_date }}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{ $docusigndocument->phone }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $docusigndocument->email }}</td>
        </tr>
        <tr>
            <td>Dates of Service From</td>
            <td>{{ $docusigndocument->dates_of_service_from }}</td>
        </tr>
        <tr>
            <td>Access Code</td>
            <td>{{ $docusigndocument->access_code }}</td>
        </tr>
        <tr>
            <td>IP Address</td>
            <td>{{ $docusigndocument->ip_address }}</td>
        </tr>
        <tr>
            <td>Remote Host</td>
            <td>{{ $docusigndocument->remote_host }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>{{ $docusigndocument->status }}</td>
        </tr>
        <tr>
            <td>Statuses</td>
            <td>{!! nl2br($docusigndocument->statuses) !!}</td>
        </tr>
        <tr>
            <td>File</td>
            <td>

                @if (is_file('//ftpserver/documents/websiterecords/' . $docusigndocument->workorder_id . '-unsigned.pdf'))
                    {{ $docusigndocument->workorder_id }}-unsigned.pdf
                    <br />
                    <a href="/user/files?file=//ftpserver/documents/websiterecords/{{ $docusigndocument->workorder_id }}-unsigned.pdf&amp;download=0"
                       target="_blank">view</a>
                    <a href="/user/files?file=//ftpserver/documents/websiterecords/{{ $docusigndocument->workorder_id }}-unsigned.pdf&amp;download=1"
                       target="_blank">download</a>
                    <br />
                    <br />
                @endif

                @if (is_file('//ftpserver/documents/websiterecords/' . $docusigndocument->workorder_id . '-signed.pdf'))
                    {{ $docusigndocument->workorder_id }}-signed.pdf
                    <br />
                    <a href="/user/files?file=//ftpserver/documents/websiterecords/{{ $docusigndocument->workorder_id }}-signed.pdf&amp;download=0"
                       target="_blank">view</a>
                    <a href="/user/files?file=//ftpserver/documents/websiterecords/{{ $docusigndocument->workorder_id }}-signed.pdf&amp;download=1"
                       target="_blank">download</a>
                    <br />
                    <br />
                @endif

                @if (is_file('//ftpserver/documents/websiterecords/' . $docusigndocument->workorder_id . '-certificate.pdf'))
                    {{ $docusigndocument->workorder_id }}-certificate.pdf
                    <br />
                    <a href="/user/files?file=//ftpserver/documents/websiterecords/{{ $docusigndocument->workorder_id }}-certificate.pdf&amp;download=0"
                       target="_blank">view</a>
                    <a href="/user/files?file=//ftpserver/documents/websiterecords/{{ $docusigndocument->workorder_id }}-certificate.pdf&amp;download=1"
                       target="_blank">download</a>
                    <br />
                    <br />
                @endif

                @if ($docusigndocument->status != 'envelope-voided')
                    <a href="/user/docusigndocuments/download?id={{ $docusigndocument->id }}"
                       class="btn btn-sm btn-secondary">download from docusign</a>
                @else
                    envelope is voided, not downloadable
                @endif

            </td>
        </tr>
        <tr>
            <td>Error Message</td>
            <td>
                {{ $docusigndocument->error_message }}
            </td>
        </tr>
        <tr>
            <td>Email Opened At</td>
            <td>{{ $docusigndocument->email_opened_at }}</td>
        </tr>
        <tr>
            <td>Signed At</td>
            <td>{{ $docusigndocument->signed_at }}</td>
        </tr>
        <tr>
            <td>Downloaded At</td>
            <td>{{ $docusigndocument->downloaded_at }}</td>
        </tr>
        <tr>
            <td>Processed At</td>
            <td>{{ $docusigndocument->processed_at }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $docusigndocument->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $docusigndocument->updated_at }}</td>
        </tr>
    </table>

    <br />

    @if (
        $docusigndocument->envelopeid &&
            $docusigndocument->signingtype == 'email' &&
            $docusigndocument->status != 'envelope-completed' &&
            $docusigndocument->status != 'envelope-voided')
        <h4>Resend Email</h4>

        <div class="col-md-4">

            <form method="post"
                  action="{{ route('user.docusignchanges.resend') }}">
                @csrf
                @method('POST')

                <input type="hidden"
                       name="id"
                       value="{{ $docusigndocument->id }}" />
                <input type="hidden"
                       name="envelopeid"
                       value="{{ $docusigndocument->envelopeid }}" />
                <input type="hidden"
                       name="email_before"
                       value="{{ $docusigndocument->email }}" />

                <x-form.input type="email"
                              name="email"
                              label="Patient Email or Enter New Email"
                              :value="old('email', $docusigndocument->email)"
                              maxlength="50"
                              required />
                <br />

                <x-form.input name="reason"
                              label="Resend Reason"
                              :value="old('reason')"
                              maxlength="50"
                              required />
                <br />

                <x-form.checkbox name="confirmresend"
                                 id="confirmresend"
                                 label="Confirm"
                                 required />

                <x-form.button>Submit</x-form.button>

            </form>

        </div>
    @endif

    @php
        $validStatuses = [
            'envelope-delivered',
            'recipient-delivered',
            'envelope-sent',
            'envelope-resent',
            'recipient-sent',
            'recipient-finish-later',
        ];
    @endphp

    @if ($docusigndocument->envelopeid && in_array($docusigndocument->status, $validStatuses))
        <br />
        <br />

        <h4>Void Envelope</h4>

        <div class="col-md-4">

            <form method="post"
                  action="{{ route('user.docusignchanges.voidenvelope') }}">
                @csrf
                @method('POST')

                <input type="hidden"
                       name="id"
                       value="{{ $docusigndocument->id }}" />
                <input type="hidden"
                       name="envelopeid"
                       value="{{ $docusigndocument->envelopeid }}" />

                @php
                    $options = [
                        '' => '',
                        'Form no longer required' => 'Form no longer required',
                        'Patient refusal to release records' => 'Patient refusal to release records',
                    ];
                @endphp
                <x-form.select name="reason"
                               label="Void Reason"
                               :options="$options"
                               required />
                <br />

                <x-form.checkbox name="confirmvoidenvelope"
                                 label="Confirm"
                                 id="confirmvoidenvelope"
                                 required />

                <x-form.button>Submit</x-form.button>

            </form>

        </div>
    @endif

    <br />
    <br />
    <hr>
    <br />
    <br />

    <pre>
    {{ $docusigndocument->raw_data }}
    </pre>

    <br />

</x-user-layout>
