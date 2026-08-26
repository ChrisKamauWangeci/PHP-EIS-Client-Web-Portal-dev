<div class="overflow-auto bg-body p-2 border"
     style="height: 200px; word-break: break-all;"
     id="followupnote">
    {!! nl2br(e($workorder->W_Note3)) !!}
</div>

<br />

<form method="post"
      action="{{ route('user.workorders.updatefollowupnote', $workorder->W_WorkOrder) }}"
      hx-patch="{{ route('user.workorders.updatefollowupnote', $workorder->W_WorkOrder) }}"
      hx-target="#form-container"
      hx-swap="innerHTML"
      hx-indicator="#indicator"
      hx-disabled-elt="find textarea, find button"
      id="followupnoteform">
    @method('PATCH')
    @csrf

    <x-form.textarea name="W_Note3"
                     label="Note"
                     :value="isset($old) && is_array($old)
                         ? $old['W_Note3'] ?? (old('W_Note3') ?? '')
                         : old('W_Note3', '')"
                     :error="$errors->first('W_Note3') ?? null"
                     :rows="5"
                     minlength="2"
                     maxlength="500"
                     required />

    <div class="small counter"
         id="counter3"></div>

    <div class="p-1"></div>

    <button class="btn btn-sm btn-secondary submitbutton"
            type="submit">Submit</button>

    <i class="fa-solid fa-spinner fa-spin htmx-indicator"
       id="indicator"></i>

</form>
