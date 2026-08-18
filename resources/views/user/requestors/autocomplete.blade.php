@if ($requestors->count())
    @foreach ($requestors as $r)
        <button
            type="button"
            class="list-group-item list-group-item-action"
            onmousedown="
                event.preventDefault();
                document.querySelector('[name=W_Requestor]').value = this.dataset.name;
                document.getElementById('company').innerHTML = this.dataset.company;
                document.getElementById('requestor-list').innerHTML='';
            "
            data-company="{{ $r->R_Company }}"
            data-name="{{ $r->R_Name }}"
            >
            <strong>{{ $r->R_Name }}</strong>
            <br />
            {{ $r->R_Company }} - {{ $r->R_Email }}
        </button>
    @endforeach
@else
    <div class="list-group-item text-muted">No results</div>
@endif
