<x-user-layout title="">

    <h1>Contractors Stats</h1>

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('user.contractorlogins.stats') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.select name="contractor" label="Contractor" :options="$contractors" empty="-" :default="request('contractor')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.select name="location" label="Location" :options="Helper::locations()" empty="-" :default="request('location')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input type="date" name="from" label="From" :value="$from" min="{{ now()->subYear(5)->format('Y-m-d') }}" max="{{ now()->addDays(1)->format('Y-m-d') }}" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input type="date" name="to" label="To" :value="$to" min="{{ now()->subYear(5)->format('Y-m-d') }}" max="{{ now()->addDays(1)->format('Y-m-d') }}" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                @php
                    $selected = request()->has('is_active') ? request('is_active') : '';
                @endphp
                <x-form.select name="is_active" label="Is Active" :options="['' => 'All', '0' => 'Not Active', '1' => 'Active']" :default="$selected" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                CSV Export
                <br />
                <input type="checkbox" name="csv" label="CSV Export" value="1">
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.contractorlogins.stats') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    <div class="table-responsive">
        <table class="tablesort table table-hover table-bordered table-sm table-hover w-auto">
            <thead>
                <tr>
                    <th data-type="string">Contractor</th>
                    <th data-type="number">#</th>
                    <th data-type="string">Location</th>
                    <th data-type="number">Logins</th>
                    <th data-type="number">IP Addresses</th>
                    <th data-type="number">UL</th>
                    <th data-type="number">DL</th>
                    <th data-type="number">Data Changes</th>
                    <th data-type="number">Status Triggers</th>
                    <th data-type="number">Page Views</th>
                    <th data-type="number">Time on Site</th>
                    <th data-type="number">Time on Site</th>
                    <th data-type="number">Avg Page View Time</th>
                    <th data-type="date">Updated At</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_logins = 0;
                    $total_uploads = 0;
                    $total_downloads = 0;
                    $total_datachanges = 0;
                    $total_statustriggers = 0;
                    $total_page_views = 0;
                    $total_time = 0;
                @endphp
                @foreach ($contractorlogins as $contractorlogin)
                    @php
                        $total_logins += $contractorlogin->login_count;
                        $total_uploads += $contractorlogin->total_uploads;
                        $total_downloads += $contractorlogin->total_downloads;
                        $total_datachanges += $contractorlogin->datachanges_count;
                        $total_statustriggers += $contractorlogin->statustriggers_count;
                        $total_page_views += $contractorlogin->total_page_views;
                        $total_time += $contractorlogin->total_time_on_site;
                    @endphp
                    <tr>
                        <td nowrap>
                            <a href="{{ route('user.contractorlogins.statsdaily', ['contractor' => $contractorlogin->contractor, 'from' => $from, 'to' => $to]) }}"><i class="fa-regular fa-clock"></i></a>
                            {{ $contractorlogin->contractor }}
                        </td>
                        <td data-order="{{ $contractorlogin->is_active ? 1 : 0 }}">
                            @if (!$contractorlogin->is_active)
                                <i class="fa-solid fa-person-circle-minus text-danger"></i>
                            @endif
                        </td>
                        <td nowrap>{{ $contractorlogin->location }}</td>
                        <td>{{ $contractorlogin->login_count }}</td>
                        <td>{{ $contractorlogin->ip_addresses }}</td>
                        <td>{{ $contractorlogin->total_uploads }}</td>
                        <td>{{ $contractorlogin->total_downloads }}</td>
                        <td>{{ $contractorlogin->datachanges_count }}</td>
                        <td>{{ $contractorlogin->statustriggers_count }}</td>
                        <td>{{ $contractorlogin->total_page_views }}</td>
                        <td>{{ $contractorlogin->total_time_on_site }}</td>
                        <td>{{ sprintf('%02d', floor($contractorlogin->total_time_on_site / 3600)) . gmdate(':i:s', $contractorlogin->total_time_on_site % 3600) }}</td>
                        <td>
                            @if ($contractorlogin->total_time_on_site && $contractorlogin->total_page_views)
                                {{ intval($contractorlogin->total_time_on_site / $contractorlogin->total_page_views) }}
                            @endif
                        </td>
                        <td nowrap>{{ $contractorlogin->updated_at }}</td>
                    </tr>
                @endforeach
            <tfoot>
                <tr>
                    <td>{{ $contractorlogins->count() }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $total_logins }}</td>
                    <td></td>
                    <td>{{ $total_uploads }}</td>
                    <td>{{ $total_downloads }}</td>
                    <td>{{ $total_datachanges }}</td>
                    <td>{{ $total_statustriggers }}</td>
                    <td>{{ $total_page_views }}</td>
                    <td>{{ $total_time }}</td>
                    <td>{{ sprintf('%02d', floor($total_time / 3600)) . gmdate(':i:s', $total_time % 3600) }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
            </tbody>
        </table>
    </div>

    <br />
    <br />

</x-user-layout>
