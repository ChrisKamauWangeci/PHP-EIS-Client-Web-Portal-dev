<x-user-layout title="Daily Stats">

    <div class="row">
        <div class="col-auto">
            <h1>Daily Stats Totals</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.daily_stats.index') }}" class="btn btn-sm btn-secondary">Daily Stats</a>
            <a href="{{ route('user.daily_stats.totals') }}" class="btn btn-sm btn-secondary">Daily Stats Totals</a>
        </div>
    </div>

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('user.daily_stats.totals') }}">

        <div class="row">

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.input name="start" id="start" label="Start Date" :value="request('start') ?? $start" type="date" autocomplete="off" min="2023-01-01" max="2030-01-01" />
            </div>

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.input name="end" id="end" label="End Date" :value="request('end') ?? $end" type="date" autocomplete="off" min="2023-01-01" max="2030-01-01" />
            </div>

            <div class="col-md-2 pt-2">
                <label>&nbsp; </label>
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.daily_stats.totals') }}" class="btn btn-sm btn-secondary"><i class="fas fa-window-close"></i></a>
            </div>

        </div>

    </form>

    <br />
    <br />

    <strong>{{ $aps_workorders_received }}</strong> APS Workorders Received
    <br />

    <strong>{{ $aps_workorders_completed }}</strong> APS Workorders Completed
    <br />

    <br />

    <strong>{{ $ehr_workorders_received }}</strong> EHR Workorders Received
    <br />

    <strong>{{ $ehr_workorders_completed }}</strong> EHR Workorders Completed
    <br />

    <br />

    <strong>{{ $ehr_orders_created }}</strong> EHR Orders Created
    <br />

    <strong>{{ $ehr_orders_submitted }}</strong> EHR Orders Submitted
    <br />

    <br />

    <strong>{{ $ehr_orders_search_created }}</strong> EHR Orders Search Results Created
    <br />

    <strong>{{ $ehr_orders_search_submitted }}</strong> EHR Orders Search Results Submitted
    <br />

    <br />

    <strong>{{ $ehr_documents_created }}</strong> EHR Orders Documents Created
    <br />

    <strong>{{ $ehr_documents_received }}</strong> EHR Orders Documents Received
    <br />

    <br />

    <strong>{{ $docusign_created }}</strong> Docusign Documents Created
    <br />

    <strong>{{ $docusign_completed }}</strong> Docusign Documents Completed
    <br />

    <br />

    <strong>{{ $fax_created }}</strong> Faxes Created
    <br />

    <strong>{{ $fax_completed }}</strong> Faxes Completed {{ $fax_created > 0 ? number_format($fax_completed / $fax_created * 100, 0) : 0 }}% completion rate.
    <br />

    <br />

    <strong>{{ $seqster_orders_created }}</strong> Seqster Orders Created
    <br />

    <br />

    <strong>{{ $requestor_logins }}</strong> Requestor Logins
    <br />

    <br />

    <strong>{{ $contractor_logins }}</strong> Contractor Logins
    <br />

    <br />
    <br />

</x-user-layout>
