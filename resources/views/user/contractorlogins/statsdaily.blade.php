<x-user-layout title="">

    <h1>Contractor Stats Daily</h1>

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('user.contractorlogins.statsdaily') }}">

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
                <br />
                <x-form.checkbox name="csv_stats" id="csv_stats" label="Export Stats" :checked="request('csv_stats')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.checkbox name="csv_summary" id="csv_summary" label="Export Summary" :checked="request('csv_summary')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.contractorlogins.statsdaily') }}" class="btn btn-sm btn-secondary">Reset</a>
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
                    <th data-type="string">Login Date</th>
                    <th data-type="number">Logins</th>
                    <th data-type="number">IP Addresses</th>
                    <th data-type="number">UL</th>
                    <th data-type="number">DL</th>
                    <th data-type="number">Page Views</th>
                    <th data-type="number">Time on Site</th>
                    <th data-type="number">Time on Site</th>
                    <th data-type="number">Regular Time</th>
                    <th data-type="number">Over Time</th>
                    <th data-type="number">Avg Page View Time</th>
                    <th data-type="date">Login First</th>
                    <th data-type="date">Login Last</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contractorlogins as $contractorlogin)
                <tr>
                    <td nowrap>{{ $contractorlogin->contractor }}</td>
                    <td data-order="{{ $contractorlogin->is_active ? 1 : 0 }}">
                        @if(!$contractorlogin->is_active)
                        <i class="fa-solid fa-person-circle-minus text-danger"></i>
                        @endif
                    </td>
                    <td nowrap>{{ $contractorlogin->location }}</td>
                    <td nowrap>{{ $contractorlogin->login_date->format('m/d/Y') }}</td>
                    <td>{{ $contractorlogin->login_count }}</td>
                    <td>{{ $contractorlogin->ip_addresses }}</td>
                    <td>{{ $contractorlogin->total_uploads }}</td>
                    <td>{{ $contractorlogin->total_downloads }}</td>
                    <td>{{ $contractorlogin->total_page_views }}</td>
                    <td>{{ $contractorlogin->total_time_on_site }}</td>
                    <td class="{{ $contractorlogin->total_time_on_site > 8 * 3600 ? 'text-primary' : '' }}">{{ $contractorlogin->formatted_time }}</td>
                    <td class="{{ $contractorlogin->regular_seconds >= 8 * 3600 ? 'text-success' : '' }}">{{ $contractorlogin->regular_time }}</td>
                    <td class="{{ $contractorlogin->overtime_seconds > 0 ? 'text-danger' : '' }}">{{ $contractorlogin->overtime_time ?? 0 }}</td>
                    <td>
                        @if ($contractorlogin->total_time_on_site && $contractorlogin->total_page_views)
                        {{ intval($contractorlogin->total_time_on_site / $contractorlogin->total_page_views) }}
                        @endif
                    </td>
                    <td nowrap>{{ $contractorlogin->first_login->format('m/d/Y g:i a') }}</td>
                    <td nowrap>{{ $contractorlogin->last_activity->format('m/d/Y g:i a') }}</td>
                </tr>
                @endforeach
            <tfoot class="fw-bold">
                <tr>
                    <td>{{ $contractorlogins->count() }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ $totals['logins'] }}</td>
                    <td></td>
                    <td>{{ $totals['uploads'] }}</td>
                    <td>{{ $totals['downloads'] }}</td>
                    <td>{{ $totals['page_views'] }}</td>
                    <td>{{ $totals['time'] }}</td>
                    <td>{{ sprintf('%02d%s', floor($totals['time']/3600), gmdate(':i:s', $totals['time'] % 3600)) }}</td>
                    <td>{{ sprintf('%02d%s', floor($totals['regular_time']/3600), gmdate(':i:s', $totals['regular_time'] % 3600)) }}</td>
                    <td class="text-danger">{{ sprintf('%02d%s', floor($totals['over_time']/3600), gmdate(':i:s', $totals['over_time'] % 3600)) }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
            </tbody>
        </table>
    </div>

    <br />
    <br />

    <h2>Contractor Summary - Total Hours</h2>

    <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm w-auto tablesort">
            <thead>
                <tr>
                    <th>Contractor</th>
                    <th data-type="number">Days</th>
                    <th data-type="number">Total Hours</th>
                    <th data-type="number">Regular Time</th>
                    <th data-type="number">Overtime</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contractorSummaries as $contractorSummary)
                <tr>
                    <td nowrap>{{ $contractorSummary['contractor'] }}</td>
                    <td>{{ $contractorSummary['days'] }}</td>
                    <td>
                        {{ sprintf('%02d', floor($contractorSummary['total_time'] / 3600)) . gmdate(':i:s', $contractorSummary['total_time'] % 3600) }}
                    </td>
                    <td class="text-success">
                        {{ sprintf('%02d', floor($contractorSummary['regular_time'] / 3600)) . gmdate(':i:s', $contractorSummary['regular_time'] % 3600) }}
                    </td>
                    <td class="{{ $contractorSummary['overtime'] > 0 ? 'text-danger' : 'text-muted' }}">
                        {{ $contractorSummary['overtime'] > 0 ? sprintf('%02d', floor($contractorSummary['overtime'] / 3600)) . gmdate(':i:s', $contractorSummary['overtime'] % 3600) : '0' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="fw-bold">
                    <td>{{ count($contractorSummaries) }}</td>
                    <td>{{ array_sum(array_column($contractorSummaries, 'days')) }}</td>
                    <td>{{ sprintf('%02d', floor($totals['time'] / 3600)) . gmdate(':i:s', $totals['time'] % 3600) }}</td>
                    <td class="text-success">{{ sprintf('%02d', floor($totals['regular_time'] / 3600)) . gmdate(':i:s', $totals['regular_time'] % 3600) }}</td>
                    <td class="text-danger">{{ sprintf('%02d', floor($totals['over_time'] / 3600)) . gmdate(':i:s', $totals['over_time'] % 3600) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <br />
    <br />

</x-user-layout>