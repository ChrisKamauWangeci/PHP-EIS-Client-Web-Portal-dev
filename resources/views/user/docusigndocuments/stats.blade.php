<x-user-layout title="">

    <script src="/js/tablesort.js"></script>

    <h1>Docusign Documents Stats</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('user.docusigndocuments.stats') }}">

        <div class="row">

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="client"
                              label="client"
                              :value="request('client')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.input type="date"
                              name="from"
                              label="from"
                              :value="request('from') ?? now()->format('Y-m-d')"
                              min="{{ now()->subYear(5)->format('Y-m-d') }}"
                              max="{{ now()->addDays(1)->format('Y-m-d') }}" />
            </div>

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.input type="date"
                              name="to"
                              label="to"
                              :value="request('to') ?? now()->format('Y-m-d')"
                              min="{{ now()->subYear(5)->format('Y-m-d') }}"
                              max="{{ now()->addDays(1)->format('Y-m-d') }}" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.docusigndocuments.stats') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    <div class="table-responsive">
        <table class="tablesort table table-hover table-bordered table-sm table-hover w-auto">
            <thead>
                <tr>
                    <th data-type="string">Client</th>
                    <th data-type="number">Document</th>
                    <th data-type="number">Envelope Sent</th>
                    <th data-type="number">Envelope Resent</th>
                    <th data-type="number">Envelope Delivered</th>
                    <th data-type="number">Envelope Completed</th>
                    <th data-type="number">Envelope Voided</th>
                    <th data-type="number">Turnaround</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_documents = 0;
                    $total_logins = 0;
                    $total_envelopedelivered = 0;
                    $total_envelopevoided = 0;
                @endphp
                @foreach ($docusigndocuments as $docusigndocument)
                    @php
                        $total_documents += $docusigndocument->document;
                        $total_logins += $docusigndocument->login_count;
                        $total_envelopedelivered += $docusigndocument->envelopedelivered;
                        $total_envelopevoided += $docusigndocument->total_envelopevoided;
                    @endphp
                    <tr>
                        <td>{{ $docusigndocument->client }}</td>
                        <td>{{ $docusigndocument->document }}</td>
                        <td>{{ $docusigndocument->envelopesent }}</td>
                        <td>{{ $docusigndocument->enveloperesent }}</td>
                        <td>{{ $docusigndocument->envelopedelivered }}</td>
                        <td>{{ $docusigndocument->envelopecompleted }}</td>
                        <td>{{ $docusigndocument->envelopevoided }}</td>
                        <td>{{ $docusigndocument->turnaround }}</td>
                    </tr>
                @endforeach
            <tfoot>
                <tr>
                    <td>{{ $docusigndocuments->count() }}</td>
                    <td>{{ $total_documents }}</td>
                    <td>{{ $total_logins }}</td>
                    <td></td>
                    <td>{{ $total_envelopedelivered }}</td>
                    <td>{{ $total_envelopevoided }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
            </tbody>
        </table>
    </div>

    <br />
    <br />

    <a href="{{ route('user.docusigndocuments.index') }}"
       class="btn btn-sm btn-secondary">Docusign Documents</a>

    <br />
    <br />

</x-user-layout>
