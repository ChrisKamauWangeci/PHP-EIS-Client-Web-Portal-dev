<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Workorder: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }} {{ $workorder->W_LastName }}
            </h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}"
               class="btn btn-sm btn-secondary">View Workorder</a>
        </div>
    </div>

    <br />

    <h1>{{ $subject }}</h1>

    <br />

    <div class="row">
        <div class="col-12 col-sm-10 col-md-9 col-lg-8">

            <form method="post"
                  action="{{ route('user.workorderemailsend.store') }}">
                @csrf

                <input type="hidden"
                       name="workorder_id"
                       value="{{ $workorder->W_WorkOrder }}">
                <input type="hidden"
                       name="type"
                       value="{{ $type }}">
                <input type="hidden"
                       name="niceType"
                       value="{{ $niceType }}">

                <x-form.input type="email"
                              name="sender"
                              id="sender"
                              label="Sender"
                              :value="old('sender', $sender)"
                              readonly
                              required />
                <br />

                <x-form.input type="email"
                              name="recipient"
                              id="recipient"
                              label="Recipient"
                              :value="old('recipient', $recipient)"
                              required />
                <br />

                <x-form.input type="text"
                              name="subject"
                              id="subject"
                              label="Subject"
                              :value="old('subject', $subject)"
                              maxlength="80"
                              required />
                <br />

                <x-form.textarea name="body"
                                 id="body"
                                 :value="old('body', $body)"
                                 rows="30"
                                 maxlength="5000" />
                <br />

                Attachments - <small>select files up to 12MB total</small>
                <br />

                @php $companylor = '\\\\ftpserver\\ftpserver\\lor\\' . $company->C_LOR; @endphp

                @php $insurancecompanylor = '\\\\ftpserver\\ftpserver\\lor\\' . $insurancecompany->I_LOR; @endphp

                @php
                    $directory = "\\\\server2\\eisaccess\\{$subdomain}\\AuthForms\\";
                    if ($subdomain == 'eis') {
                        $directory = "\\\\server2\\eisaccess\\AuthForms\\";
                    }
                    $filepdf = false;
                    $filetif = false;
                    if ($workorder->W_AuthorizedFile) {
                        $authorizedfile_parts = pathinfo($workorder->W_AuthorizedFile);
                        $W_AuthorizedFileName = $authorizedfile_parts['filename'];
                        $filepdf = $directory . $W_AuthorizedFileName . '.pdf';
                        $filetif = $directory . $W_AuthorizedFileName . '.tif';
                    }
                @endphp

                @php
                    $datefolder = date_format($workorder->W_ReceiveDate, 'Ym');

                    $directory = "\\\\ftpserver\\ftpserver\\NoteFile\\FaxRequest1\\{$subdomain}\\{$datefolder}\\";

                    $getrequestfilesdirectory = $directory;

                    if (!is_dir($directory)) {
                        mkdir($directory, 0777, true);
                    }

                    $datefolderfiles = [];

                    try {
                        $files = new FilesystemIterator(
                            $directory,
                            FilesystemIterator::KEY_AS_FILENAME | FilesystemIterator::SKIP_DOTS,
                        );
                        $files = new RegexIterator($files, "/$workorder->W_WorkOrder-.*(\.pdf|\.tif)/i");
                        $files = array_reverse(iterator_to_array($files));
                    } catch (\Throwable $th) {
                        $files = [];
                    }
                @endphp

                @if (is_file($companylor))
                    <input type="hidden"
                           name="attachment_1"
                           value="{{ $companylor }}" />
                    <x-form.checkbox name="attachment_1_checkbox"
                                     label="Company LOR - {{ $companylor }} {{ round(filesize($companylor) / 1024 / 1024, 2) }} MB" />
                @endif

                @if (is_file($insurancecompanylor))
                    <input type="hidden"
                           name="attachment_2"
                           value="{{ $insurancecompanylor }}" />
                    <x-form.checkbox name="attachment_2_checkbox"
                                     label="Insurance Company LOR - {{ $insurancecompanylor }} {{ round(filesize($insurancecompanylor) / 1024 / 1024, 2) }} MB" />
                @endif

                @if (is_file($filepdf))
                    <input type="hidden"
                           name="attachment_3"
                           value="{{ $filepdf }}" />
                    <x-form.checkbox name="attachment_3_checkbox"
                                     label="Authorization File PDF - {{ $filepdf }} {{ round(filesize($filepdf) / 1024 / 1024, 2) }} MB" />
                @endif

                @if (is_file($filetif))
                    <input type="hidden"
                           name="attachment_4"
                           value="{{ $filetif }}" />
                    <x-form.checkbox name="attachment_4_checkbox"
                                     label="Authorization File TIF - {{ $filetif }} {{ round(filesize($filetif) / 1024 / 1024, 2) }} MB" />
                @endif

                @foreach ($files as $file)
                    <input type="hidden"
                           name="attachment_{{ 5 + $loop->index }}"
                           value="{{ $file }}" />
                    <x-form.checkbox name="attachment_{{ 5 + $loop->index }}_checkbox"
                                     label="Request File - {{ $file }} {{ round($file->getSize() / 1024 / 1024, 2) }} MB" />
                @endforeach

                <br />
                <br />

                <x-form.button><i class="fas fa-paper-plane"></i> Send Email</x-form.button>

            </form>

        </div>

    </div>

</x-user-layout>
