<div id="htmxfollowupstatus">

    <strong class="h6 fw-bold">Follow-Up Status</strong>
    &nbsp;
    <span data-bs-toggle="modal"
          data-bs-target="#modal"
          data-label="Follow-Up Status"
          id="followupstatusview"><i class="fa-solid fa-magnifying-glass"></i></span>
    &nbsp;
    <i class="fa-solid fa-maximize"
       onclick="expand();"></i>

    <div class="p-1"></div>

    <div class="overflow-auto bg-white p-2 border expandables"
         style="height: 300px; word-break: break-all;"
         id="followupstatustext">
        {!! nl2br(e($workorder->W_FollowUpStatus ?? '')) !!}
    </div>

    <br />
    <span class="d-print-none">

        <form hx-patch="/user/workorders/workorderfollowupstatusupdate/{{ $workorder->W_WorkOrder }}"
              hx-target="#htmxfollowupstatus"
              hx-swap="outerHTML"
              hx-indicator="#followup-spinner"
              hx-on::before-request="
            document.getElementById('followup-submit-btn').disabled = true;
            document.getElementById('followup-spinner').style.display = 'inline';"
              hx-on::after-request="
            document.getElementById('followup-submit-btn').disabled = false;
            document.getElementById('followup-spinner').style.display = 'none';
            this.reset();"
              id="followupstatusnote">
            @csrf

            Follow up Date <span id="w-follow-up-status-date2"></span>
            <input type="date"
                   name="w_follow_up_status_date"
                   id="w-follow-up-status-date"
                   class="form-control form-control-sm required"
                   autocomplete="off"
                   value="{{ date('Y-m-d') }}"
                   min="{{ now()->subMonths(3)->toDateString() }}"
                   max="{{ now()->addMonths(3)->toDateString() }}"
                   required />
            <br />

            <x-form.select name="followupstatuslists"
                           id="followupstatuslists"
                           label="Status"
                           :options="$followupstatuslists"
                           empty="-"
                           required />
            <br />

            <x-form.textarea name="W_FollowUpStatus"
                             id="W_FollowUpStatus"
                             label="Note"
                             :value="old('W_FollowUpStatus')"
                             :rows="5"
                             minlength="5"
                             maxlength="500"
                             required />
            <div class="small counter"
                 id="counter2"></div>
            <br />

            <div id="validationerrors">
                @include('components.form.errors')
            </div>

            <button class="btn btn-sm btn-secondary submitbutton"
                    type="submit"
                    id="followup-submit-btn">
                Submit
                <i class="fas fa-sync-alt fa-spin"
                   id="followup-spinner"
                   style="display: none;"></i>
            </button>

        </form>

    </span>
</div>

@if (request()->header('HX-Request'))
    <div hx-swap-oob="true"
         id="w_followupdt"
         class="oob-flash"><strong>{{ $workorder->W_FollowUpDt?->format('m/d/Y') }}</strong></div>
    <div hx-swap-oob="true"
         id="w_upduser"
         class="oob-flash"><strong>{{ $workorder->W_UpdUser }}</strong></div>
    <div hx-swap-oob="true"
         id="w_upddate"
         class="oob-flash"><strong>{{ $workorder->W_UpdDate?->format('m/d/Y g:i a') }} pst</strong></div>
@endif
