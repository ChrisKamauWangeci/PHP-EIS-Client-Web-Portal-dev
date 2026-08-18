<tr data-id="{{ $apscancellation->CancellationID }}" id="item-{{ $apscancellation->CancellationID }}" @class(['flash'=> $flash ?? false])>
    <td>
        <a href="{{ route('user.workorders.show', $apscancellation->EISWorkOrderID) }}">{{ $apscancellation->EISWorkOrderID }}</a>
    </td>
    <td>{{ $apscancellation->workorder->W_Status ?? '' }}</td>
    <td>{{ $apscancellation->RequestID }}</td>
    <td>{{ $apscancellation->CompanyName }}</td>

    <td>

        <form method="post">
            @csrf
            @method('PATCH')
            <input type="hidden" name="CancellationID" value="{{ $apscancellation->CancellationID }}">

            <x-form.select
                hx-post="{{ route('user.apscancellations.update', $apscancellation->CancellationID) }}"
                hx-target="#item-{{ $apscancellation->CancellationID }}"
                hx-swap="outerHTML"
                hx-trigger="change"
                hx-include="closest form"
                hx-indicator="#loading-{{ $apscancellation->CancellationID }}"
                hx-confirm1="Are you sure you want to change this status?"
                name="CancellationStatusID"
                id="CancellationStatusID-{{ $apscancellation->CancellationID }}"
                :options="$cancellationStatusOptions"
                empty="-"
                :default="$apscancellation->CancellationStatusID" />
        </form>

    </td>

    <td class="align-middle">

        @if ($apscancellation->CancellationStatusID == 3 or $apscancellation->CancellationStatusID == 4)

        -

        @else

        <form method="post">
            @csrf
            @method('PATCH')

            <input type="hidden" name="CancellationID" value="{{ $apscancellation->CancellationID }}">
            <input type="hidden" name="IsNotified" value="0">

            <input
                hx-post="{{ route('user.apscancellations.update', $apscancellation->CancellationID) }}"
                hx-target="#item-{{ $apscancellation->CancellationID }}"
                hx-swap="outerHTML"
                hx-trigger="change"
                hx-include="closest form"
                hx-indicator="#loading-{{ $apscancellation->CancellationID }}"
                type="checkbox"
                name="IsNotified"
                class="form-check-input border border-black"
                value="1"
                @checked($apscancellation->IsNotified)
            />
        </form>

        @endif

    </td>
    <td>{{ $apscancellation->Inserted }}</td>
    <td>{{ $apscancellation->Username }}</td>
    <td class="actions">
        <a href="{{ route('user.apscancellations.show', $apscancellation->CancellationID) }}" class="btn btn-xs btn-secondary">Show</a>
        &nbsp;
        <a href="{{ route('user.apscancellations.edit', $apscancellation->CancellationID) }}" class="btn btn-xs btn-secondary">Edit</a>
        <i id="loading-{{ $apscancellation->CancellationID }}" class="fa-solid fa-spinner fa-spin htmx-indicator"></i>
    </td>
</tr>