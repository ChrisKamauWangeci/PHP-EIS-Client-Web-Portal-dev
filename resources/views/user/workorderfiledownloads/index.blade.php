<x-user-layout title="Workorder File Downloads">

    <style>
        .htmx-indicator {
            display: none;
        }

        .htmx-indicator.htmx-request {
            display: inline-block;
        }

        tr.htmx-swapping {
            opacity: 0;
            transition: opacity 200ms ease-out;
        }
    </style>

    <h1>Workorder File Downloads</h1>

    <form
        hx-get="{{ route('user.workorderfiledownloads.index') }}"
        hx-target="#results"
        hx-push-url="false"
        hx-indicator="#loading"
        hx-trigger="keyup delay:600ms from:input, change from:select, submit">

        <div class="row">

            <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.select name="order_type" label="Order Type" :value="request('order_type')" :options="['aps' => 'APS', 'ehr' => 'EHR']" :default="request('order_type')" />
            </div>

            <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="workorder_id" label="Workorder ID" :value="request('workorder_id')" type="number" min="1" max="9999999" autocomplete="off" />
            </div>

            <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="company" label="Company" :value="request('company')" autocomplete="off" />
            </div>

            <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 pt-2">
                <label>&nbsp; </label>
                <br />
                <x-form.button type="submit">Submit</x-form.button>
            </div>

        </div>

    </form>

    <br />
    <br />

    <div
        id="loading"
        class="text-muted htmx-indicator">
        <span class="spinner-border spinner-border-sm"></span>
        Loading…
    </div>

    <div id="results">
        @include('user.workorderfiledownloads._table')
    </div>

    <script>
        document.body.addEventListener('htmx:configRequest', function(event) {
            event.detail.headers['X-CSRF-TOKEN'] =
                document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        });
    </script>

</x-user-layout>
