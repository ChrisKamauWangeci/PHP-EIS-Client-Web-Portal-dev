<tr id="ehrorderssearchresult-{{ $ehrorderssearchresult->id }}">
    <td>
        @if (is_null($ehrorderssearchresult->consent_required) && is_null($ehrorderssearchresult->status))
            <form hx-post="/user/ehrorderssearchresults/{{ $ehrorderssearchresult->id }}/requestrecords"
                  hx-confirm="Are you sure you want to request records?"
                  hx-target="#ehrorderssearchresult-{{ $ehrorderssearchresult->id }}"
                  hx-swap="outerHTML">
                @csrf
                <button type="submit"
                        class="btn btn-xs btn-primary">Request</button>
            </form>
        @endif
    </td>
    <td>
        <a
           href="{{ route('user.ehrorderssearchresults.show', $ehrorderssearchresult->id) }}">{{ $ehrorderssearchresult->managing_organization }}</a>
    </td>
    <td>{{ $ehrorderssearchresult->consent_required }}</td>
    <td>{{ $ehrorderssearchresult->status }}</td>
    <td>{{ $ehrorderssearchresult->created_by }}</td>
    <td>{{ $ehrorderssearchresult->requested_at }}</td>
    <td>{{ $ehrorderssearchresult->submitted_at }}</td>
    <td class="{{ $ehrorderssearchresult->received_at ? 'bg-success-subtle' : '' }}">
        {{ $ehrorderssearchresult->received_at }}</td>
    <td class="{{ $ehrorderssearchresult->operation_outcome ? 'bg-danger-subtle' : '' }} small">
        {{ $ehrorderssearchresult->operation_outcome }}</td>
</tr>
