{{ $synodextransmissions->links('user.synodextransmissions.htmxpagination') }}

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
    <input type="hidden"
           name="sort_field"
           value="{{ request('sort_field') }}">
    <input type="hidden"
           name="sort_direction"
           value="{{ request('sort_direction') }}">
</form>

<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered w-auto">
        <thead>
            <tr>
                <th>
                    <a hx-get="{{ request()->fullUrlWithQuery(['sort_field' => 'WorkOrderID', 'sort_direction' => $sort_direction]) }}"
                       hx-target="#results"
                       hx-push-url="false">
                        Workorder ID
                    </a>
                </th>

                <th>
                    <a hx-get="{{ request()->fullUrlWithQuery(['sort_field' => 'AcordReferenceID', 'sort_direction' => $sort_direction]) }}"
                       hx-target="#results"
                       hx-push-url="false">
                        Acord Reference ID
                    </a>
                </th>

                <th>
                    <a hx-get="{{ request()->fullUrlWithQuery(['sort_field' => 'Inserted', 'sort_direction' => $sort_direction]) }}"
                       hx-target="#results"
                       hx-push-url="false">
                        Inserted
                    </a>
                </th>

                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($synodextransmissions as $synodextransmission)
                <tr id="row-{{ $synodextransmission->id }}">
                    <td><a
                           href="{{ route('user.workorders.show', $synodextransmission->WorkOrderID) }}">{{ $synodextransmission->WorkOrderID }}</a>
                    </td>
                    <td>{{ $synodextransmission->AcordReferenceID }}</td>
                    <td>{{ $synodextransmission->Inserted?->format('m/d/Y H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $synodextransmissions->links('user.synodextransmissions.htmxpagination') }}
