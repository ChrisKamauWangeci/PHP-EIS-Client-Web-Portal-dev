<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        document.documentElement.setAttribute(
            'data-bs-theme',
            localStorage.getItem('themeadmin') || 'light'
        );
    </script>
    <title>{{ $title_for_layout ?? 'EIS Online' }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/admin.css?{{ time() }}">
    <script src="/js/jquery-3.7.1.min.js"></script>
    <script src="/js/htmx.min.js"></script>
    <script src="/js/vue.global.prod.min.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/tablesort.js"></script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-TM6QLQQE3E"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-TM6QLQQE3E');
    </script>
</head>
<body>
    <nav id="sidebar">

        <img src="/img/eis-logo.png" class="bg-white m-1" width="32" height="32" alt="EIS Logo">

        <a class="eis-menu-title" data-bs-toggle="collapse" href="#menuSettings" role="button" aria-expanded="false">
            <i class="fa-solid fa-cog"></i>
            <span class="menu-text">System Settings</span>
            <i class="fa-solid fa-chevron-down chevron"></i>
        </a>
        <div class="collapse" id="menuSettings">
            <ul class="eis-menu-list">
                @can('admin.companies.index')
                    <li><a class="eis-menu-link" href="/admin/companies"><span class="menu-text">Companies</span></a></li>
                @endcan
                @can('admin.requestors.index')
                    <li><a class="eis-menu-link" href="/admin/requestors"><span class="menu-text">Requestors</span></a></li>
                @endcan
                @can('admin.requestorroles.index')
                    <li><a class="eis-menu-link" href="/admin/requestorroles"><span class="menu-text">Requestor Roles</span></a></li>
                @endcan
                @can('admin.contractors.index')
                    <li><a class="eis-menu-link" href="/admin/contractors"><span class="menu-text">Contractors</span></a></li>
                @endcan
                @can('admin.roles.index')
                    <li><a class="eis-menu-link" href="/admin/roles"><span class="menu-text">Contractor Admin Roles</span></a></li>
                    <li><a class="eis-menu-link" href="/admin/permissions"><span class="menu-text">Contractor Admin Permissions</span></a></li>
                @endcan
                @can('admin.websiteconfigs.index')
                    <li><a class="eis-menu-link" href="/admin/websiteconfigs"><span class="menu-text">Website Configs</span></a></li>
                @endcan
                @can('admin.creditcards.index')
                    <li><a class="eis-menu-link" href="/admin/creditcards"><span class="menu-text">Credit Cards</span></a></li>
                @endcan
                @can('admin.ticketmanagers.index')
                    <li><a class="eis-menu-link" href="/admin/ticketmanagers"><span class="menu-text">Ticket Managers</span></a></li>
                @endcan
                @can('admin.settings.index')
                    <li><a class="eis-menu-link" href="/admin/settings"><span class="menu-text">Key-Value Settings</span></a></li>
                @endcan
                @if (in_array($adminsession['subdomain'], ['eisdev', 'eisuat', 'eis']))
                    @can('admin.settings.index')
                        <li><a class="eis-menu-link" href="/admin/platform-configurations"><span class="menu-text">Platform Configurations</span></a></li>
                    @endcan
                @endif
                @can('admin.over60daysnoticeconfigs.index')
                    <li><a class="eis-menu-link" href="/admin/over60daysnoticeconfigs"><span class="menu-text">Over 60 Days Notice Configs</span></a></li>
                @endcan
                @can('admin.smartaccessthemes.index')
                    <li><a class="eis-menu-link" href="/admin/smartaccessthemes"><span class="menu-text">Smart Access Themes</span></a></li>
                @endcan
                @if (in_array($adminsession['subdomain'], ['eisdev']))
                    @can('admin.billtopicklists.index')
                        <li><a class="eis-menu-link" href="/admin/billtopicklists"><span class="menu-text">Bill To Picklists</span></a></li>
                    @endcan
                @endif
            </ul>
        </div>

        <a class="eis-menu-title" data-bs-toggle="collapse" href="#menuModules" role="button" aria-expanded="false">
            <i class="fa-solid fa-tv"></i>
            <span class="menu-text">Modules</span>
            <i class="fa-solid fa-chevron-down chevron"></i>
        </a>
        <div class="collapse" id="menuModules">
            <ul class="eis-menu-list">
                @can('admin.docusigndocuments.index')
                    <li><a class="eis-menu-link" href="/admin/docusigndocuments"><span class="menu-text">Docusign Documents</span></a></li>
                @endcan
                @can('admin.companyupdates.index')
                    <li><a class="eis-menu-link" href="/admin/companyupdates"><span class="menu-text">Company Updates</span></a></li>
                @endcan
                @can('admin.workorders.index')
                    <li><a class="eis-menu-link" href="/admin/workorders"><span class="menu-text">Workorders</span></a></li>
                    <li><a class="eis-menu-link" href="/admin/workorders/stats"><span class="menu-text">Workorders Stats</span></a></li>
                    <li><a class="eis-menu-link" href="/admin/workorderholdtimes"><span class="menu-text">Workorder Hold Times</span></a></li>
                    <li><a class="eis-menu-link" href="/admin/workordernotices"><span class="menu-text">Workorder Notices</span></a></li>
                @endcan
            </ul>
        </div>

        <a class="eis-menu-title" data-bs-toggle="collapse" href="#menuLogs" role="button" aria-expanded="false">
            <i class="fa-solid fa-database"></i>
            <span class="menu-text">Logs</span>
            <i class="fa-solid fa-chevron-down chevron"></i>
        </a>
        <div class="collapse" id="menuLogs">
            <ul class="eis-menu-list">
                @can('admin.logs.index')
                    <li><a class="eis-menu-link" href="/admin/statustriggers"><span class="menu-text">Statustriggers</span></a></li>
                    <li><a class="eis-menu-link" href="/admin/datachanges"><span class="menu-text">Data Changes</span></a></li>
                    <li><a class="eis-menu-link" href="/admin/filetransfers"><span class="menu-text">File Transfers</span></a></li>
                    <li><a class="eis-menu-link" href="/admin/passwordresets"><span class="menu-text">Contractor Password Resets</span></a></li>
                    <li><a class="eis-menu-link" href="/admin/contractorlogins"><span class="menu-text">Contractor Logins</span></a></li>
                    <li><a class="eis-menu-link" href="/admin/contractorloginips"><span class="menu-text">Contractor Logins IP</span></a></li>
                    <li><a class="eis-menu-link" href="/admin/contractorloginattempts"><span class="menu-text">Contractor Login Attempts</span></a></li>
                    <li><a class="eis-menu-link" href="/admin/logins"><span class="menu-text">Requestor Logins</span></a></li>
                    <li><a class="eis-menu-link" href="/admin/loginips"><span class="menu-text">Requestor Logins IP</span></a></li>
                    <li><a class="eis-menu-link" href="/admin/loginattempts"><span class="menu-text">Requestor Logins Attempts</span></a></li>
                    <li><a class="eis-menu-link" href="/admin/requestor-password-changes"><span class="menu-text">Requestor Password Changes</span></a></li>
                @endcan
            </ul>
        </div>

        <a class="eis-menu-title" data-bs-toggle="collapse" href="#menuReports" role="button" aria-expanded="false">
            <i class="fa-solid fa-table"></i>
            <span class="menu-text">Reports</span>
            <i class="fa-solid fa-chevron-down chevron"></i>
        </a>
        <div class="collapse" id="menuReports">
            <ul class="eis-menu-list">
                @can('admin.contractorlogins.index')
                    <li><a class="eis-menu-link" href="/admin/contractorlogins/stats"><span class="menu-text">Contractor Usage Stats</span></a></li>
                    <li><a class="eis-menu-link" href="/admin/contractorlogins/statsdaily"><span class="menu-text">Contractor Usage Stats Daily</span></a></li>
                @endcan
            </ul>
        </div>

    </nav>

    <div id="overlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-none d-md-none" style="z-index: 998;"></div>

    <header class="position-fixed top-0 end-0 bg-white shadow-sm py-2 px-3 ps-md-4 ps-2" style="z-index: 999;">
        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-secondary btn-sm d-md-none" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="d-flex align-items-center gap-2 ms-auto">

                <strong>{{ $adminsession['contractor']['C_Name'] }}</strong>
                <span class="d-none d-lg-inline">{{ $adminsession['contractor']['C_Email'] }}</span>
                <a href="/sessioninfo/" target="_blank">Session</a>
                <a href="/sessioninfo/admindebug">{{ $adminsession['debug'] ? 'Hide' : 'Show' }} Debug</a>
                <i class="fa-solid fa-circle-half-stroke" id="themeToggle"></i>
                <a href="{{ route('authadmin.logout') }}" class="btn btn-xs btn-danger">
                    <i class="fa-solid fa-power-off"></i> <span class="d-none d-sm-inline">Log out</span>
                </a>
            </div>
        </div>
    </header>

    <div id="content" class="ps-md-4 ps1-1 pe1-1" style="margin-left: 10px; margin-top: 50px;">
        <div class="container-fluid">

            <x-flash />

            <div class="p-2">
                {{ $slot }}
            </div>

            <br />

        </div>

        @if (!Request::ajax())
            @if (!isset($layoutnull) || $layoutnull == false)
                @include('partials.footer')
            @endif
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('overlay');
            const collapses = document.querySelectorAll('#sidebar .collapse');

            document.getElementById('themeToggle').addEventListener('click', function() {
                const htmlElement = document.documentElement;
                const newTheme =
                    htmlElement.getAttribute('data-bs-theme') === 'dark' ?
                    'light' :
                    'dark';
                htmlElement.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('themeadmin', newTheme);
            });

            // Bootstrap Collapse helper
            const getCollapse = el => bootstrap.Collapse.getOrCreateInstance(el, {
                toggle: false
            });

            // Mobile toggle functionality
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('mobile-open');
                    overlay.classList.toggle('d-none');
                });
            }

            // Close sidebar when clicking overlay
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('mobile-open');
                overlay.classList.add('d-none');
            });

            // Desktop: Close all other menus when one opens
            collapses.forEach(collapse => {
                collapse.addEventListener('show.bs.collapse', () => {
                    collapses.forEach(other => {
                        if (other !== collapse) {
                            getCollapse(other).hide();
                        }
                    });
                });
            });

            // Desktop: Close all menus when mouse leaves sidebar
            sidebar.addEventListener('mouseleave', () => {
                if (window.innerWidth > 768) {
                    collapses.forEach(c => getCollapse(c).hide());
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('mobile-open');
                    overlay.classList.add('d-none');
                }
            });
        });

        document.body.addEventListener('htmx:configRequest', function(event) {
            event.detail.headers['X-CSRF-TOKEN'] =
                document.querySelector('meta[name="csrf-token"]').content;
        });
    </script>
</body>
</html>
