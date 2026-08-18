{{ $workorderfiledownloads->links('user.workorderfiledownloads.htmxpagination') }}

<style>
    tr {
        transition: opacity 500ms ease, height 500ms ease, padding 500ms ease;
    }

    tr.htmx-swapping {
        opacity: 0;
        height: 0;
        padding-top: 0;
        padding-bottom: 0;
        overflow: hidden;
    }
</style>

<form id="htmx-state">
    <input type="hidden" name="sort_field" value="{{ request('sort_field') }}">
    <input type="hidden" name="sort_direction" value="{{ request('sort_direction') }}">
</form>

<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered w-auto">
        <thead>
            <tr>
                <th>
                    <a
                        hx-get="{{ request()->fullUrlWithQuery(['sort_field' => 'workorder_id', 'sort_direction' => $sort_direction]) }}"
                        hx-target="#results"
                        hx-push-url="false">
                        Workorder ID
                    </a>
                </th>

                <th>
                    <a
                        hx-get="{{ request()->fullUrlWithQuery(['sort_field' => 'company', 'sort_direction' => $sort_direction]) }}"
                        hx-target="#results"
                        hx-push-url="false">
                        Company
                    </a>
                </th>

                <th>PDF</th>
                <th>TIF</th>

                <th>
                    <a
                        hx-get="{{ request()->fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}"
                        hx-target="#results"
                        hx-push-url="false">
                        Created
                    </a>
                </th>

                <th>
                    <a
                        hx-get="{{ request()->fullUrlWithQuery(['sort_field' => 'updated_at', 'sort_direction' => $sort_direction]) }}"
                        hx-target="#results"
                        hx-push-url="false">
                        Updated
                    </a>
                </th>

                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($workorderfiledownloads as $row)
                <tr id="row-{{ $row->id }}">
                    <td>
                        @if ($order_type === 'aps')
                            <a href="{{ route('user.workorders.show', $row->workorder_id) }}">
                                {{ $row->workorder_id }}
                            </a>
                        @else
                            <a href="https://ehr.expressimagingservices.net/user/workorders/{{ $row->workorder_id }}" target="_blank">
                                {{ $row->workorder_id }}
                            </a>
                        @endif
                    </td>

                    <td>{{ $row->company }}</td>

                    <td>
                        {{ $row->pdf_filename }}<br>
                        {{ $row->pdf_download_by }}<br>
                        {{ $row->pdf_download_count }}<br>
                        {{ $row->pdf_download_at }}
                    </td>

                    <td>
                        {{ $row->tif_filename }}<br>
                        {{ $row->tif_download_by }}<br>
                        {{ $row->tif_download_count }}<br>
                        {{ $row->tif_download_at }}
                    </td>

                    <td>{{ $row->created_at?->format('m/d/Y H:i:s') }}</td>
                    <td>{{ $row->updated_at?->format('m/d/Y H:i:s') }}</td>

                    <td>
                        <button
                            class="btn btn-xs btn-danger"
                            hx-delete="{{ route('user.workorderfiledownloads.destroy', $row) }}"
                            hx-vals='{"order_type":"{{ $order_type }}"}'
                            hx-confirm="Delete this record?"
                            hx-target="#row-{{ $row->id }}"
                            hx-swap="delete swap:500ms"
                            hx-indicator="#loading">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $workorderfiledownloads->links('user.workorderfiledownloads.htmxpagination') }}
