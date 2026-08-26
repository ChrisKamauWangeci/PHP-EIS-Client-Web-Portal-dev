<x-user-layout title="">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-header').forEach(header => {
                header.addEventListener('click', function() {
                    const targetId = this.dataset.target;
                    const targetDiv = document.getElementById(targetId);

                    document.querySelectorAll('.toggle-content').forEach(div => {
                        if (div !== targetDiv) div.style.display = 'none';
                    });

                    targetDiv.style.display = (targetDiv.style.display === 'none' || targetDiv.style
                        .display === '') ? 'block' : 'none';

                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.classList.toggle('fa-plus');
                        icon.classList.toggle('fa-minus');
                    }
                });
            });
        });

        function popup(url) {
            window.open(url, "popup", "scrollbars=yes,width=1280,height=800,resizable=yes,left=40,top=40")
        }
    </script>

    <div class="row">
        <div class="col-auto">
            <h1>Workorder Files: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }}
                {{ $workorder->W_LastName }}</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}"
               class="btn btn-sm btn-secondary">View Workorder</a>
            <a href="{{ url()->full() }}"
               class="btn btn-sm btn-secondary"><i class="fa-solid fa-rotate"></i></a>
        </div>
    </div>

    <hr>

    <h4>LOR</h4>

    Company: {{ $company->C_Name }}
    <br />
    Company LOR Expiration: {{ $company->C_LORExpirationDate?->format('m/d/Y') }} {!! Helper::labelColor($company->C_LORExpirationDateLabel) !!}
    <br />
    @php $companylor = '\\\\ftpserver\\ftpserver\\lor\\' . $company->C_LOR; @endphp
    Company LOR:
    @if (!is_file($companylor))
        <div class="bg-danger text-white">
            {{ $companylor }} - File Not Found
        </div>
    @else
        <a href="/user/workorderfiles/file?file={{ urlencode($companylor) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
           target="_blank">{{ $companylor }}</a>
    @endif

    <br />
    <br />

    @if ($insurancecompany)

        Insurance Company: {{ $insurancecompany->I_Name }}
        <br />
        Insurance Company LOR Expiration: {{ $insurancecompany->I_LORExpirationDate?->format('m/d/Y') }}
        {!! Helper::labelColor($insurancecompany->I_LORExpirationDateLabel) !!}
        <br />
        @php
            $insurancecompanylor = '\\\\ftpserver\\ftpserver\\lor\\' . $insurancecompany->I_LOR;
        @endphp

        Insurance Company LOR:
        @if (!is_file($insurancecompanylor))
            <div class="bg-danger text-white">
                {{ $insurancecompanylor }} - File Not Found
            </div>
        @else
            <a href="/user/workorderfiles/file?file={{ urlencode($insurancecompanylor) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
               target="_blank">{{ $insurancecompanylor }}</a>
        @endif
    @else
        <span class="text-danger">Insurance Company Not Found</span>
        <br />
    @endif

    <br />

    @php
        $lorcompanyfile = $company->C_LOR ?? null;
        $lorinsurancecompanyfile = $insurancecompany->I_LOR ?? null;
    @endphp

    <hr>

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
            $filepdf1 = $directory . $W_AuthorizedFileName . '.pdf';
            $filetif1 = $directory . $W_AuthorizedFileName . '.tif';
            if (is_file($filepdf1)) {
                $filepdf = $filepdf1;
            }
            if (is_file($filetif1)) {
                $filetif = $filetif1;
            }
        }
    @endphp

    <div class="row toggle-header"
         data-target="authorizationSection">
        <div class="col">
            <h4>Authorization Files</h4>
        </div>
        <div class="col text-end">
            <div class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i></div>
        </div>
    </div>
    <div id="authorizationSectionWrapper">

        <div id="authorizationSection"
             class="toggle-content"
             style="display:none;">

            <small>{{ $directory }}</small>

            <br />

            <strong>Authorization File</strong> {{ $workorder->W_AuthorizedFile }}

            <br />

            @if (is_file($filepdf) || is_file($filetif))

                <table class="table table-sm table-bordered w-auto">

                    @if (is_file($filepdf))
                        <tr>
                            <td><a href="/user/workorderfiles/file?file={{ urlencode($filepdf) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
                                   target="_blank">view</a></td>
                            <td><a href="/user/workorderfiles/file?file={{ urlencode($filepdf) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=1"
                                   target="_blank">download</a></td>
                            <td class="mono">{{ basename($filepdf) }}</td>
                            <td class="mono">{{ date('m/d/Y g:i A', filemtime($filepdf)) }}</td>
                        </tr>
                    @endif

                    @if (is_file($filetif))
                        <tr>
                            <td><a href="/user/workorderfiles/file?file={{ urlencode($filetif) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
                                   target="_blank">view</a></td>
                            <td><a href="/user/workorderfiles/file?file={{ urlencode($filetif) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=1"
                                   target="_blank">download</a></td>
                            <td class="mono">{{ basename($filetif) }}</td>
                            <td class="mono">{{ date('m/d/Y g:i A', filemtime($filetif)) }}</td>
                        </tr>
                    @endif

                </table>

            @endif

            @if (!is_file($filepdf) && !is_file($filetif))
                <div class="mono">
                    {{ $filepdf }} <span class="text-danger">pdf not found</span>
                    <br />
                    {{ $filetif }} <span class="text-danger">tif not found</span>
                </div>
                <br />
            @endif

            <div class="col-sm-5">

                <form method="post"
                      enctype="multipart/form-data"
                      action="{{ route('user.workorderfiles.fileupload', $workorder->W_WorkOrder) }}">
                    @csrf
                    <input type="hidden"
                           name="type"
                           value="auth">

                    @php
                        $options = [
                            'Special Authorization Form' => 'Special Authorization Form',
                            'Insurance Authorization Form' => 'Insurance Authorization Form',
                        ];
                    @endphp
                    <x-form.select name="filetype"
                                   label="Authorization File Type"
                                   :options="$options"
                                   empty="-"
                                   required />
                    <br />

                    <x-form.input type="file"
                                  name="uploadfile"
                                  label="Authorization File"
                                  accept=".pdf,.tif"
                                  required />
                    <br />

                    <x-form.button>Upload Authorization File</x-form.button>
                </form>

            </div>

            @if ($subdomain == 'eisdev')
                <form hx-post="{{ route('user.workorderfiles.authcheckembed') }}"
                      hx-target="#auth-result"
                      hx-swap="innerHTML">
                    @csrf
                    <input type="hidden"
                           name="workorder_id"
                           value="{{ $workorder->W_WorkOrder }}" />
                    <x-form.button>Auth Check Embed</x-form.button>
                </form>

                <div id="auth-result"
                     class="mt-3"></div>
            @endif

            @php
                $directory = "\\\\ftpserver\\ftpserver\\NoteFile\\OldAutho\\{$subdomain}\\";

                try {
                    $files = new FilesystemIterator(
                        $directory,
                        FilesystemIterator::KEY_AS_FILENAME | FilesystemIterator::SKIP_DOTS,
                    );
                    $files = new RegexIterator($files, "/$workorder->W_WorkOrder-.*(\.pdf|\.tif)$/i");
                    $files = array_reverse(iterator_to_array($files));
                } catch (\Throwable $th) {
                    $files = [];
                    $directory = '<span class="text-danger">directory error: ' . $directory . '</span>';
                }
            @endphp

            <br />

            <strong>Old Authorization Files</strong>

            <br />

            <small>{{ $directory }}</small>

            <table class="table table-sm table-bordered w-auto">
                @foreach ($files as $file)
                    <tr>
                        <td><a href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
                               target="_blank">view</a></td>
                        <td><a href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=1"
                               target="_blank">download</a></td>
                        <td class="mono">{{ $file->getFilename() }}</td>
                        <td class="mono">{{ date('m/d/Y g:i A', $file->getMTime()) }}</td>
                    </tr>
                @endforeach
            </table>

            <a href="/user/filetransfers?direction=upload&workorder_id={{ $workorder->W_WorkOrder }}"
               onclick="popup(this.href); return false;"
               class="btn btn-sm btn-secondary">File Transfers Upload</a>
            &nbsp;
            <a href="/user/filetransfers?direction=download&workorder_id={{ $workorder->W_WorkOrder }}"
               onclick="popup(this.href); return false;"
               class="btn btn-sm btn-secondary">File Transfers Download</a>

        </div>
    </div>

    <hr />

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
            $directory = '<span class="text-danger">directory error: ' . $directory . '</span>';
        }
    @endphp

    <div class="row toggle-header"
         data-target="requestfilesSection">

        <div class="col">
            <h4>Request Files <small>(newest to oldest)</small></h4>
        </div>
        <div class="col text-end">
            <div class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i></div>
        </div>
    </div>

    <div id="requestfilesSection"
         class="toggle-content"
         style="display:none;">

        <small>{{ $directory }}</small>

        <br />

        <table class="table table-sm table-bordered w-auto">
            @foreach ($files as $file)
                <tr>
                    <td><a href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
                           target="_blank">view</a></td>
                    <td><a href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=1"
                           target="_blank">download</a></td>
                    <td><a
                           href="/user/faxes/create?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}">fax</a>
                    </td>
                    <td><a
                           href="/user/emails/create?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}">email</a>
                    </td>
                    <td class="mono">{{ $file->getFilename() }}</td>
                    <td class="mono">{{ date('m/d/Y g:i A', $file->getMTime()) }}</td>
                </tr>
            @endforeach
        </table>

        <br />

        <h4>Create Request File without any LOR</h4>
        <a href="/user/workorderfiles/createrequestfile?W_WorkOrder={{ $workorder->W_WorkOrder }}&amp;type=nolor&amp;requestnote=1st"
           class="btn btn-sm btn-secondary">Generate 1st</a> &nbsp;
        <a href="/user/workorderfiles/createrequestfile?W_WorkOrder={{ $workorder->W_WorkOrder }}&amp;type=nolor&amp;requestnote=2nd"
           class="btn btn-sm btn-secondary">Generate 2nd</a> &nbsp;
        <a href="/user/workorderfiles/createrequestfile?W_WorkOrder={{ $workorder->W_WorkOrder }}&amp;type=nolor&amp;requestnote=3rd"
           class="btn btn-sm btn-secondary">Generate 3rd</a>
        <br />

        @if (is_file($companylor) ||
                $company->C_LORExpirationDateLabel == 'valid' ||
                $company->C_LORExpirationDateLabel == 'expiring')
            <br />
            <h4>Create Request File Company LOR</h4>
            <a href="/user/workorderfiles/createrequestfile?W_WorkOrder={{ $workorder->W_WorkOrder }}&amp;type=companylor&amp;requestnote=1st&amp;lorfile={{ $lorcompanyfile }}"
               class="btn btn-sm btn-secondary">Generate 1st</a>&nbsp;
            <a href="/user/workorderfiles/createrequestfile?W_WorkOrder={{ $workorder->W_WorkOrder }}&amp;type=companylor&amp;requestnote=2nd&amp;lorfile={{ $lorcompanyfile }}"
               class="btn btn-sm btn-secondary">Generate 2nd</a>&nbsp;
            <a href="/user/workorderfiles/createrequestfile?W_WorkOrder={{ $workorder->W_WorkOrder }}&amp;type=companylor&amp;requestnote=3rd&amp;lorfile={{ $lorcompanyfile }}"
               class="btn btn-sm btn-secondary">Generate 3rd</a>
            <br />
        @endif

        @if (
            $insurancecompany &&
                (is_file($insurancecompanylor) ||
                    $insurancecompany->I_LORExpirationDateLabel == 'valid' ||
                    $insurancecompany->I_LORExpirationDateLabel == 'expiring'))
            <br />
            <h4>Create Request File Insurance Company LOR</h4>
            <a href="/user/workorderfiles/createrequestfile?W_WorkOrder={{ $workorder->W_WorkOrder }}&amp;type=insurancelor&amp;requestnote=1st&amp;lorfile={{ $lorinsurancecompanyfile }}"
               class="btn btn-sm btn-secondary">Generate 1st</a>&nbsp;
            <a href="/user/workorderfiles/createrequestfile?W_WorkOrder={{ $workorder->W_WorkOrder }}&amp;type=insurancelor&amp;requestnote=2nd&amp;lorfile={{ $lorinsurancecompanyfile }}"
               class="btn btn-sm btn-secondary">Generate 2nd</a>&nbsp;
            <a href="/user/workorderfiles/createrequestfile?W_WorkOrder={{ $workorder->W_WorkOrder }}&amp;type=insurancelor&amp;requestnote=3rd&amp;lorfile={{ $lorinsurancecompanyfile }}"
               class="btn btn-sm btn-secondary">Generate 3rd</a>
            <br />
        @endif

        <br />

    </div>

    <hr />

    @php
        $directory = "\\\\ftpserver\\ftpserver\\NoteFile\\notes\\{$subdomain}\\";

        try {
            $files = new FilesystemIterator(
                $directory,
                FilesystemIterator::KEY_AS_FILENAME | FilesystemIterator::SKIP_DOTS,
            );
            $files = new RegexIterator($files, "/$workorder->W_WorkOrder-.*(\.pdf|\.tif)/i");
            $files = array_reverse(iterator_to_array($files));
        } catch (\Throwable $th) {
            $directory = '<span class="text-danger">directory error: ' . $directory . '</span>';
        }
    @endphp

    <div class="row toggle-header"
         data-target="notefilesSection">
        <div class="col">
            <h4>Note Files</h4>
        </div>
        <div class="col text-end">
            <div class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i></div>
        </div>
    </div>

    <div id="notefilesSection"
         class="toggle-content"
         style="display:none;">

        <small>{{ $directory }}</small>

        <br />

        <table class="table table-sm table-bordered w-auto">
            @foreach ($files as $file)
                <tr>
                    <td><a href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
                           target="_blank">view</a></td>
                    <td><a href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=1"
                           target="_blank">download</a></td>
                    <td><a
                           href="/user/faxes/create?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}">fax</a>
                    </td>
                    <td><a
                           href="/user/emails/create?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}">email</a>
                    </td>
                    <td class="mono">{{ $file->getFilename() }}</td>
                </tr>
            @endforeach
        </table>

        <div class="col-sm-5">

            <form method="post"
                  enctype="multipart/form-data"
                  action="{{ route('user.workorderfiles.fileupload', $workorder->W_WorkOrder) }}">
                @csrf
                <input type="hidden"
                       name="type"
                       value="notes">

                <x-form.input type="file"
                              name="uploadfile"
                              label="Note File"
                              required
                              accept=".pdf,.tif" />
                <br />

                <x-form.button>Upload Note File</x-form.button>
            </form>

        </div>

    </div>

    <hr>

    @php
        $directory = "\\\\ftpserver\\ftpserver\\NoteFile\\reviewaps\\{$subdomain}\\";

        try {
            $files = new FilesystemIterator(
                $directory,
                FilesystemIterator::KEY_AS_FILENAME | FilesystemIterator::SKIP_DOTS,
            );
            $files = new RegexIterator($files, "/$workorder->W_WorkOrder-.*(\.pdf|\.tif)/i");
            $files = array_reverse(iterator_to_array($files));
        } catch (\Throwable $th) {
            $files = [];
            $directory = '<span class="text-danger">directory error: ' . $directory . '</span>';
        }
    @endphp

    <div class="row toggle-header"
         data-target="reviewapsfilesSection">
        <div class="col">
            <h4>Review APS Files</h4>
        </div>
        <div class="col text-end">
            <div class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i></div>
        </div>
    </div>

    <div id="reviewapsfilesSection"
         class="toggle-content"
         style="display:none;">

        <small>{{ $directory }}</small>

        <br />

        <table class="table table-sm table-bordered w-auto">
            @foreach ($files as $file)
                <tr>
                    <td><a href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
                           target="_blank">view</a></td>
                    <td><a href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=1"
                           target="_blank">download</a></td>
                    <td><a
                           href="/user/faxes/create?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}">fax</a>
                    </td>
                    <td><a
                           href="/user/emails/create?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}">email</a>
                    </td>
                    <td class="mono">{{ $file->getFilename() }}</td>
                </tr>
            @endforeach
        </table>

        <div class="col-sm-5">

            <form method="post"
                  enctype="multipart/form-data"
                  action="{{ route('user.workorderfiles.fileupload', $workorder->W_WorkOrder) }}">
                @csrf
                <input type="hidden"
                       name="type"
                       value="reviewaps">

                <x-form.input type="file"
                              name="uploadfile"
                              label="Review APS File"
                              required
                              accept=".pdf,.tif" />
                <br />

                <x-form.button>Upload Review APS File</x-form.button>
            </form>

        </div>

    </div>

    <hr>

    @php
        $directory = "\\\\server2\\eisaccess\\{$subdomain}\\checks\\";
        if ($subdomain == 'eis') {
            $directory = "\\\\server2\\eisaccess\\checks\\";
        }

        $files = [];

        try {
            $files = new FilesystemIterator(
                $directory,
                FilesystemIterator::KEY_AS_FILENAME | FilesystemIterator::SKIP_DOTS,
            );
            $files = new RegexIterator($files, "/$workorder->W_WorkOrder.*(\.pdf|\.tif)/i");
            $files = array_reverse(iterator_to_array($files));
        } catch (\Throwable $th) {
            $files = [];
            $directory = '<span class="text-danger">directory error: ' . $directory . '</span>';
        }
    @endphp

    <div class="row toggle-header"
         data-target="invoicesSection">
        <div class="col">
            <h4>Invoices</h4>
        </div>
        <div class="col text-end">
            <div class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i></div>
        </div>
    </div>

    <div id="invoicesSection"
         class="toggle-content"
         style="display:none;">

        <small>{{ $directory }}</small>

        <table class="table table-sm table-bordered w-auto">
            @foreach ($files as $file)
                <tr>
                    <td><a href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
                           target="_blank">view</a></td>
                    <td><a href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=1"
                           target="_blank">download</a></td>
                    <td class="mono">{{ $file }}</td>
                </tr>
            @endforeach
        </table>

        <div class="col-sm-5">

            <form method="post"
                  enctype="multipart/form-data"
                  action="{{ route('user.workorderfiles.fileupload', $workorder->W_WorkOrder) }}">
                @csrf
                <input type="hidden"
                       name="type"
                       value="invoice">

                <x-form.input name="W_DrInvoiceNo"
                              label="Invoice Number"
                              maxlength="20"
                              required />
                <br />

                <x-form.input type="file"
                              name="uploadfile"
                              label="Invoice File"
                              required
                              accept=".pdf,.tif" />
                <br />

                <x-form.button>Upload Invoice</x-form.button>
            </form>

        </div>

    </div>

    <hr>

    @php $file = '\\\\ftpserver\\ftpserver\apps\ready\\' . $workorder->W_FirstName . '-' . $workorder->W_LastName . '-' . $workorder->W_DOB?->format('Ymd') . '.tif'; @endphp
    @if (is_file($file))
        APPS: <a
           href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
           target="_blank">{{ $file }}</a>
        <div class="p-1"></div>
    @else
        <span class="text-danger">
            APPS file not found: {{ $file }}
        </span>
        <div class="p-1"></div>
    @endif

    <div class="p-1"></div>

    @php $file = '\\\\ftpserver\documents\websiterecords\\' . $workorder->W_WorkOrder . '.pdf'; @endphp
    @if (is_file($file))
        Website Record: <a
           href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
           target="_blank">{{ $file }}</a>
        <div class="p-1"></div>
    @else
        <span class="text-danger">
            Website Record file not found: {{ $file }}
        </span>
        <div class="p-1"></div>
    @endif

    <div class="p-1"></div>

    @php $file = '\\\\ftpserver\\ftpserver\\notefile\\reviewaps\\' . $workorder->W_ImageFile . '.pdf'; @endphp
    @if (is_file($file))
        Review APS pdf: <a
           href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
           target="_blank">{{ $file }}</a>
        <div class="p-1"></div>
    @else
        <span class="text-danger">
            Review APS pdf file not found: {{ $file }}
        </span>
        <div class="p-1"></div>
    @endif

    <div class="p-1"></div>

    @php $file = '\\\\ftpserver\\ftpserver\\notefile\\reviewaps\\' . $workorder->W_ImageFile . '.tif'; @endphp
    @if (is_file($file))
        Review APS tif: <a
           href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
           target="_blank">{{ $file }}</a>
        <div class="p-1"></div>
    @else
        <span class="text-danger">
            Review APS tif file not found: {{ $file }}
        </span>
        <div class="p-1"></div>
    @endif

    <div class="p-1"></div>

    @php $file = '\\\\ftpserver\\ftpserver\\notefile\notes\\' . pathinfo($workorder->W_AuthorizedFile ?? '', PATHINFO_FILENAME) . '.pdf'; @endphp
    @if (is_file($file))
        Notes pdf: <a
           href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
           target="_blank">{{ $file }}</a>
        <div class="p-1"></div>
    @else
        <span class="text-danger">
            Notes pdf file not found: {{ $file }}
        </span>
        <div class="p-1"></div>
    @endif

    <div class="p-1"></div>

    @php $file = '\\\\ftpserver\\ftpserver\\notefile\notes\\' . pathinfo($workorder->W_AuthorizedFile ?? '', PATHINFO_FILENAME) . '.tif'; @endphp
    @if (is_file($file))
        Notes tif: <a
           href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
           target="_blank">{{ $file }}</a>
        <div class="p-1"></div>
    @else
        <span class="text-danger">
            Notes tif file not found: {{ $file }}
        </span>
        <div class="p-1"></div>
    @endif

    <div class="p-1"></div>

    @php $file = '\\\\ftpserver\\ftpserver\\' . $company->C_WebID . '\\' . $workorder->W_ImageFile . '.pdf'; @endphp
    @if (is_file($file))
        APS: <a
           href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
           target="_blank">{{ $file }}</a>
        <div class="p-1"></div>
    @else
        <span class="text-danger">
            APS file not found: {{ $file }}
        </span>
        <div class="p-1"></div>
    @endif

    <div class="p-1"></div>

    @php $file = '\\\\ftpserver\\ftpserver\\' . $company->C_WebID . '\\' . $workorder->W_ImageFile . '-sum.pdf'; @endphp
    @if (is_file($file))
        APS Summary: <a
           href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
           target="_blank">{{ $file }}</a>
        <div class="p-1"></div>
    @else
        <span class="text-danger">
            APS Summary file not found: {{ $file }}
        </span>
        <div class="p-1"></div>
    @endif

    <hr>

    @if ($usersession['contractor']['accesslevel'])

        @php
            $directory = "\\\\ftpserver\\ftpserver\\{$company->C_WebID}\\";

            $files = [];

            try {
                $files = new FilesystemIterator(
                    $directory,
                    FilesystemIterator::KEY_AS_FILENAME | FilesystemIterator::SKIP_DOTS,
                );
                $files = new RegexIterator($files, "/{$workorder->W_WorkOrder}.*\.(pdf|tif)$/i");
                $files = array_reverse(iterator_to_array($files));
            } catch (\Throwable $th) {
                $directory = '<span class="text-danger">directory error: ' . $directory . '</span>';
            }
        @endphp

        <h4>APS Files</h4>
        <small>{{ $directory }}</small>

        <table class="table table-sm table-bordered w-auto">
            @foreach ($files as $file)
                <tr>
                    <td><a href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
                           target="_blank">view</a></td>
                    <td><a href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=1"
                           target="_blank">download</a></td>
                    <td class="mono">{{ $file }}</td>
                    <td class="mono">{{ date('m/d/Y g:i A', $file->getMTime()) }}</td>
                </tr>
            @endforeach
        </table>

        <hr>

    @endif

    @php
        $directory = "\\\\ftpserver\\ftpserver\\NoteFile\\additionalrequests\\{$subdomain}\\";

        $getadditionalfilesdirectory = $directory;

        try {
            $files = new FilesystemIterator(
                $directory,
                FilesystemIterator::KEY_AS_FILENAME | FilesystemIterator::SKIP_DOTS,
            );
            $files = new RegexIterator($files, "/$workorder->W_WorkOrder-.*(\.pdf)/i");
            $files = array_reverse(iterator_to_array($files));
        } catch (\Throwable $th) {
            $files = [];
            $directory = '<span class="text-danger">directory error: ' . $directory . '</span>';
        }
    @endphp

    <a name="additional"></a>

    <h4>Additional Requests Files</h4>

    <small>{{ $directory }}</small>

    <table class="table table-sm table-bordered w-auto">
        @foreach ($files as $file)
            <tr>
                <td><a href="/user/workorderfiles/file?file={{ $file->getRealPath() }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
                       target="_blank">view</a></td>
                <td><a href="/user/workorderfiles/file?file={{ $file->getRealPath() }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=1"
                       target="_blank">download</a></td>
                <td><a
                       href="/user/faxes/create?file={{ $file->getRealPath() }}&amp;workorder_id={{ $workorder->W_WorkOrder }}">fax</a>
                </td>
                <td><a
                       href="/user/emails/create?file={{ $file->getRealPath() }}&amp;workorder_id={{ $workorder->W_WorkOrder }}">email</a>
                </td>
                <td class="mono">{{ $file->getFilename() }}</td>
            </tr>
        @endforeach
    </table>

    <a href="/user/additionalrequests/create?workorder_id={{ $workorder->W_WorkOrder }}"
       class="btn btn-sm btn-secondary">Additional Requests File Submission</a>

    &nbsp;

    <a href="/user/creditcardauthorizations/create?workorder_id={{ $workorder->W_WorkOrder }}"
       class="btn btn-sm btn-secondary">Create Credit Card Authorization</a>

    <br />

    <hr>

    <a href="/user/faxes?workorder={{ $workorder->W_WorkOrder }}"
       onclick="popup(this.href); return false;"
       class="btn btn-sm btn-secondary">Fax Logs</a>

    &nbsp;

    <a href="/user/emails?w=1&workorder_id={{ $workorder->W_WorkOrder }}"
       onclick="popup(this.href); return false;"
       class="btn btn-sm btn-secondary">Email Logs</a>

    &nbsp;

    <a href="/user/filetransfers?direction=upload&workorder_id={{ $workorder->W_WorkOrder }}"
       onclick="popup(this.href); return false;"
       class="btn btn-sm btn-secondary">File Transfers Upload</a>

    &nbsp;

    <a href="/user/filetransfers?direction=download&workorder_id={{ $workorder->W_WorkOrder }}"
       onclick="popup(this.href); return false;"
       class="btn btn-sm btn-secondary">File Transfers Download</a>

    &nbsp;

    <a href="/user/workorderfiles/coverpage/{{ $workorder->W_WorkOrder }}"
       target="_blank"
       class="btn btn-sm btn-secondary">Preview Cover Page</a>

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            workorder
            @php dump(@$workorder); @endphp
            requestor
            @php dump(@$requestor); @endphp
            company
            @php dump(@$company); @endphp
            insurancecompany
            @php dump(@$insurancecompany); @endphp
        </div>
    @endif

</x-user-layout>
