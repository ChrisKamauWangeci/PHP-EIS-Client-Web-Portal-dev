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

    <h1>Synodex Transmissions</h1>

    <form
        hx-get="{{ route('user.synodextransmissions.index') }}"
        hx-target="#results"
        hx-push-url="false"
        hx-indicator="#loading"
        hx-trigger="keyup delay:600ms from:input, change from:select, submit">

        <div class="row">

            <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="WorkOrderID" label="Workorder ID" :value="request('WorkOrderID')" type="number" min="1" max="9999999" autocomplete="off" />
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
        @include('user.synodextransmissions._table')
    </div>

    <script>
        document.body.addEventListener('htmx:configRequest', function(event) {
            event.detail.headers['X-CSRF-TOKEN'] =
                document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        });
    </script>

</x-user-layout>
