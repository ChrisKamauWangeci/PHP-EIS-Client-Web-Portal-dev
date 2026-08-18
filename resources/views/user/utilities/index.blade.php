<x-user-layout title="">

    <h1>Utilities</h1>

    <br />

    <a href="{{ route('user.workordernotices.index') }}">Workorder Notices</a>

    <br />
    <br />

    <a href="{{ route('user.workorderholdtimes.index') }}">Workorder Hold Times</a>

    <br />
    <br />

    @if ($usersession['contractor']['C_SysAdmin'])


        <a href="{{ route('user.woins.index') }}">Workorder Insurance</a>

        <br />
        <br />

        <a href="{{ route('user.incoming_aps_configs.index') }}">Incoming APS Configs</a>

        <br />
        <br />

        <a href="{{ route('user.incoming_aps_logs.index') }}">Incoming APS Logs</a>

        <br />
        <br />

        <a href="{{ route('user.purge_configs.index') }}">Purge Configs</a>

        <br />
        <br />

        <a href="{{ route('user.report_configs.index') }}">Report Configs</a>

        <br />
        <br />

        <a href="{{ route('user.synodextransmissions.index') }}">Synodex Transmissions</a>

        <br />
        <br />

        <a href="{{ route('user.eisweborders.index') }}">EIS Web Orders</a>

        <br />
        <br />

        <a href="{{ route('user.orders.index') }}">EIS Web Orders New</a>

        <br />
        <br />

        <a href="{{ route('user.webhooks.index') }}">Webhooks</a>

        <br />
        <br />

    @endif

    @php
        $validEmails = ['maria_alcantara@ircopy.com', 'melencio_bautista@ircopy.com', 'apadmin@expressimagingservices.com', 'benedict_santos@ircopy.com', 'shaira_manuel@ircopy.com', 'anhle@expressimagingservices.com', 'andras@expressimagingservices.com'];

        $stats = false;
        if (in_array(session('user.contractor.C_Email'), $validEmails)) {
            $stats = true;
        }
    @endphp

    @if ($stats)
        <a href="{{ route('user.contractorlogins.stats') }}">Contractor Stats</a>

        <br />
        <br />

        <a href="{{ route('user.contractorlogins.statsdaily') }}">Contractor Stats Daily</a>

        <br />
        <br />
    @endif

</x-user-layout>
