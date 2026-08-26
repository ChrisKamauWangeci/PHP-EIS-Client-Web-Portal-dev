<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $subdomain }} {{ $usersession['contractor']['C_Name'] }}</title>
    <meta http-equiv="Content-Type"
          content="text/html; charset=UTF-8" />
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible"
          content="ie=edge">
    <meta name="csrf-token"
          content="{{ csrf_token() }}" />
    <link rel="preconnect"
          href="https://fonts.googleapis.com">
    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@100..700&display=swap"
          rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
          integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          type="text/css"
          href="/css/bootstrap.min.css">
    <link rel="stylesheet"
          type="text/css"
          href="/css/css.css">
    <style>
        .mono {
            font-family: 'Roboto Mono', monospace;
        }

        .navbar {
            z-index: 1025;
        }

        #layoutnull {
            display: block;
        }

        .pagewidth {
            margin-left: 10px;
            margin-right: 10px;
            max-width: 1400px;
            margin-right: auto;
            margin-left: auto;
        }

        @media (width: 1280px) {
            .hide1280 {
                display: none;
            }
        }
    </style>
    <script>
        document.documentElement.setAttribute(
            'data-bs-theme',
            localStorage.getItem('themeuser') || 'light'
        );
    </script>
    <script src="/js/jquery-3.7.1.min.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/vue.global.prod.min.js"></script>
    <script src="/js/htmx.min.js"></script>
    <!-- Google tag (gtag.js) -->
    <script async
            src="https://www.googletagmanager.com/gtag/js?id=G-TM6QLQQE3E"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-TM6QLQQE3E', {
            'user_id': "{{ $usersession['contractor']['C_Name'] }}"
        });
    </script>
    <script>
        var count1 = 0;
        var counter = setInterval(timer, 1000);

        var time;
        window.onload = resetTimer;
        document.onmousemove = resetTimer;
        document.onscroll = resetTimer;
        document.onkeydown = resetTimer;

        var title = document.title;

        function idle() {
            alert("Inactive on the same page...");
            time = setTimeout(idle, 600000);
            count1 = 0;
        }

        function resetTimer() {
            clearTimeout(time);
            time = setTimeout(idle, 600000);
            count1 = 0;
        }

        function timer() {
            count1++;
            if (count1 < 180) {
                document.title = title;
            } else {
                if (count1 % 2 == 0) {
                    document.title = count1 + ' TIMEOUT';
                } else {
                    document.title = count1 + ' WARNING';
                }
            }
        }
    </script>
</head>

<body class="bg-secondary-subtle">

    <a name="top"></a>

    <div class="container-full pagewidth">

        @if (!isset($hideheader) || $hideheader == false)

            @if (!Request::ajax())

                <div class="hide1280">

                    <div class="p-2 bg-body">
                        <div class="row">
                            <div class="col-0 col-md-1 d-none d-md-block">
                                <img src="/img/{{ $subdomain }}.jpg"
                                     class="img-fluid1"
                                     height="40">
                            </div>
                            <div class="col-12 col-md-4">
                                {{ $usersession['contractor']['C_UserCompany'] }}
                                <br />
                                <b>{{ $usersession['contractor']['C_Name'] }}</b>
                                &nbsp;{{ $usersession['contractor']['C_Email'] }}
                            </div>
                            <div class="col-12 col-md-7 text-end">
                                <span class="d-print-none small">

                                    @if ($subdomain == 'eisdev' || $subdomain == 'eisuat')

                                        &nbsp;
                                        <a href="/user/workorders?database=eis">Search Workorder Databases</a>

                                        @if ($usersession['contractor']['company_updates'])
                                            <!-- &nbsp; -->
                                            <!-- <a href="/user/companyupdates" class="btn btn-xs btn-danger"><i class="fa-regular fa-fw fa-clock fa-beat"></i> Pending Company Updates</a> -->
                                        @endif

                                        &nbsp;
                                        <a href="/sessioninfo"
                                           target="_blank">Session</a>

                                        &nbsp;
                                        <a href="/sessioninfo/debug">{{ $usersession['debug'] ? 'Hide' : 'Show' }}
                                            Debug</a>

                                        &nbsp;
                                        <a href="https://expressimagingservices.atlassian.net/jira/software/c/projects/EISNET/issues"
                                           target="_blank">Jira Issues</a>

                                    @endif

                                    <br />

                                    @if (isset($usersession['workordercurrent']))
                                        <a href="/user/workorders/{{ $usersession['workordercurrent']['W_WorkOrder'] }}"
                                           class="btn btn-xs btn-success">WO#:
                                            {{ $usersession['workordercurrent']['W_WorkOrder'] }} -
                                            {{ $usersession['workordercurrent']['W_FirstName'] }}
                                            {{ $usersession['workordercurrent']['W_LastName'] }}</a>
                                    @endif

                                    @if (isset($usersession['workordersessions']))
                                        <!-- <a href="/user/workorders/history" class="btn btn-xs btn-warning">Workorder History</a> -->
                                    @endif

                                    @if (isset($usersession['workordersessions']))
                                        <button class="btn btn-xs bg-success-subtle"
                                                hx-get="/user/workorders/history"
                                                hx-target="#workorderhistory"
                                                hx-trigger="mouseenter delay:100ms, click"
                                                hx-swap="innerHTML">
                                            Workorders History
                                        </button>
                                    @endif

                                    @if (isset($usersession['workordersurl']))
                                        <a href="{{ $usersession['workordersurl'] }}"
                                           class="btn btn-xs btn-primary">Last Workorder Filters</a>
                                    @endif

                                    @if ($subdomain == 'eisdev')
                                        &nbsp;
                                        <a href="/user/timecards/"
                                           class="btn btn-xs btn-warning"><i class="fa-regular fa-clock"></i> Time
                                            Card</a>
                                    @endif

                                    &nbsp;
                                    <a href="/user/contractors/logout"
                                       class="btn btn-xs btn-secondary"><i class="fa-solid fa-power-off"></i> Logout</a>

                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="container position-relative">
                        <div id="workorderhistory"
                             class="position-absolute p-2 hidden"
                             style="top: -20px; right: 0; z-index: 100000;"></div>
                    </div>

                    <nav
                         class="navbar navbar-expand-lg navbar-dark bg-dark1 d-print-none border-start border-danger border-4 bg{{ $subdomain }}">
                        <div class="container-fluid">
                            <span class="navbar-brand">EIS - {{ $subdomain }}</span>
                            <button class="navbar-toggler"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#navbarNav"
                                    aria-controls="navbarNav"
                                    aria-expanded="false"
                                    aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse"
                                 id="navbarNav">

                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                                    <li class="nav-item"><a class="nav-link"
                                           href="/user/workorders?type=all">Search Workorders</a></li>
                                    <li class="nav-item"><a class="nav-link"
                                           href="/user/workorders?search=1&type=new&W_Status=Incomplete&dbfield=W_Hospital&dbconditions=empty&dbvalue=null&sort_field=W_Urgent&order=desc">New
                                            Workorders</a></li>
                                    <li class="nav-item"><a class="nav-link"
                                           href="/user/workorders?search=1&W_Owner={{ urlencode($usersession['contractor']['C_Name']) }}&W_Status=Incomplete&type=my">My
                                            Workorders</a></li>
                                    <li class="nav-item"><a class="nav-link"
                                           href="/user/hospitals">Hospitals</a></li>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle"
                                           href="#"
                                           id="navbarDropdown"
                                           role="button"
                                           data-bs-toggle="dropdown"
                                           aria-expanded="false">
                                            Utilities
                                        </a>
                                        <ul class="dropdown-menu"
                                            aria-labelledby="navbarDropdown">
                                            <li><a class="dropdown-item"
                                                   href="/user/alternatepayments">Alternate Payments</a></li>
                                            <li><a class="dropdown-item"
                                                   href="/user/copyservices">Copy Services</a></li>
                                            <li><a class="dropdown-item"
                                                   href="/user/rois">ROI</a></li>
                                            <li><a class="dropdown-item"
                                                   href="/user/datachanges">Data Changes</a></li>
                                            <li><a class="dropdown-item"
                                                   href="/user/emails">Emails</a></li>
                                            <li><a class="dropdown-item"
                                                   href="/user/filetransfers?contractor={{ $usersession['contractor']['C_Name'] }}">File
                                                    Transfers</a></li>
                                            <li><a class="dropdown-item"
                                                   href="/user/faxes?email={{ $usersession['contractor']['C_Email'] }}">Faxes</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                   href="/user/tickets">Tickets</a></li>
                                            <li><a class="dropdown-item"
                                                   href="/user/inquiries">Inquiries</a></li>
                                            <li><a class="dropdown-item"
                                                   href="/user/apscancellations">Cancellation Requests</a></li>
                                            <li><a class="dropdown-item"
                                                   href="/user/utilities">Utilities</a></li>
                                            @if ($usersession['contractor']['accesslevel'])
                                                <li><a class="dropdown-item"
                                                       href="/user/facilityforms">Facility Forms</a></li>
                                                <li><a class="dropdown-item"
                                                       href="/user/prefills">In House Prefills</a></li>
                                                <li><a class="dropdown-item"
                                                       href="/user/docusigndocuments">Docusign Documents</a></li>
                                                <li><a class="dropdown-item"
                                                       href="/user/seqsterorders">Seqster Orders</a></li>
                                                <li><a class="dropdown-item"
                                                       href="/user/ehrorders">EHR Orders</a></li>
                                                <li><a class="dropdown-item"
                                                       href="/user/ehrorderssearchresults">EHR Orders Search
                                                        Results</a></li>
                                                <li><a class="dropdown-item"
                                                       href="/user/ehrordersdocuments">EHR Orders Documents</a></li>
                                            @endif
                                            @if ($subdomain == 'eisdev' || $subdomain == 'eisuat')
                                                <li><a class="dropdown-item"
                                                       href="/user/workorderfiledownloads">Workorder File Downloads</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                       href="/user/workorderfiletransfers">Workorder File Transfers</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                       href="/user/shipments">Shipments - DO NOT USE, TESTING ONLY</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                       href="/user/workorderpayments">Workorder Payments - DO NOT USE,
                                                        TESTING ONLY</a></li>
                                                <li><a class="dropdown-item"
                                                       href="/user/bankstatements">Check Issued Logs - DO NOT USE,
                                                        TESTING ONLY</a></li>
                                            @endif
                                        </ul>
                                    </li>

                                </ul>

                                @if ($subdomain == 'eisuat')
                                    @if ($usersession['contractor']['company_updates'])
                                        <form class="d-flex"
                                              role="search">
                                            <a href="/user/companyupdates"
                                               class="btn btn-sm btn-danger"><i
                                                   class="fa-regular fa-fw fa-clock fa-beat"></i> Pending Company
                                                Updates</a>
                                        </form>
                                    @endif
                                @endif

                            </div>
                        </div>
                    </nav>

                </div>

            @endif

        @endif

        <div class="p-2 bg-body">
            <div id="flash-wrapper">
                <x-flash />
            </div>
            {{ $slot }}
            <br />
        </div>

        @if (!isset($hideheader) || $hideheader == false)

            @if (!Request::ajax())
                <div class="hide1280 bg-body-tertiary">
                    <div class="p-2 text-small small"
                         id="themeToggle"><i class="fa-solid fa-circle-half-stroke smallF"></i></div>
                    @include('partials.footer')
                </div>
            @endif

        @endif

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const toggle = document.getElementById('themeToggle');

            toggle.addEventListener('click', function() {

                const html = document.documentElement;

                const newTheme =
                    html.getAttribute('data-bs-theme') === 'dark' ?
                    'light' :
                    'dark';

                html.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('themeuser', newTheme);

            });
        });
    </script>

</body>

</html>
