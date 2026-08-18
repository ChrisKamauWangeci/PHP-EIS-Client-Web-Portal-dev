{{ $workorderfiletransfers->links('user.workorderfiletransfers.htmxpagination') }}

<form id="htmx-state">
    <input type="hidden" name="sort_field" value="{{ request('sort_field') }}">
    <input type="hidden" name="sort_direction" value="{{ request('sort_direction') }}">
</form>

<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered w-auto">
        <thead>
            <tr>
                <th>
                    <a hx-get="{{ request()->fullUrlWithQuery(['sort_field' => 'workorder_id', 'sort_direction' => $sort_direction]) }}" hx-target="#results" hx-push-url="false">Workorder ID</a>
                </th>

                <th>
                    <a hx-get="{{ request()->fullUrlWithQuery(['sort_field' => 'company', 'sort_direction' => $sort_direction]) }}" hx-target="#results" hx-push-url="false">Company</a>
                </th>

                <th>
                    <a hx-get="{{ request()->fullUrlWithQuery(['sort_field' => 'requestor', 'sort_direction' => $sort_direction]) }}" hx-target="#results" hx-push-url="false">Requestor</a>
                </th>

                <th>
                    <a hx-get="{{ request()->fullUrlWithQuery(['sort_field' => 'filename', 'sort_direction' => $sort_direction]) }}" hx-target="#results" hx-push-url="false">Filename</a>
                </th>

                <th>
                    <a hx-get="{{ request()->fullUrlWithQuery(['sort_field' => 'ip_address', 'sort_direction' => $sort_direction]) }}" hx-target="#results" hx-push-url="false">IP Address</a>
                </th>

                <th>
                    <a hx-get="{{ request()->fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}" hx-target="#results" hx-push-url="false">Created</a>
                </th>
            </tr>
        </thead>

        <tbody>
            @foreach ($workorderfiletransfers as $workorderfiletransfer)
                <tr id="workorderfiletransfer-{{ $workorderfiletransfer->id }}">
                    <td>
                        @if ($order_type === 'aps')
                            <a href="{{ route('user.workorders.show', $workorderfiletransfer->workorder_id) }}">
                                {{ $workorderfiletransfer->workorder_id }}
                            </a>
                        @else
                            <a href="https://ehr.expressimagingservices.net/user/workorders/{{ $workorderfiletransfer->workorder_id }}" target="_blank">
                                {{ $workorderfiletransfer->workorder_id }}
                            </a>
                        @endif
                    </td>
                    <td>{{ $workorderfiletransfer->company }}</td>
                    <td>{{ $workorderfiletransfer->requestor }}</td>
                    <td>{{ $workorderfiletransfer->filename }}</td>
                    <td>{{ $workorderfiletransfer->ip_address }}</td>
                    <td>{{ $workorderfiletransfer->created_at?->format('m/d/Y H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $workorderfiletransfers->links('user.workorderfiletransfers.htmxpagination') }}

<br />
<br />
