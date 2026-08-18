<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Create Setting</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.settings.index') }}" class="btn btn-sm btn-secondary">View Settings</a>
        </div>
    </div>

    <br />

    @fragment('formstore')

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                @if($isHtmx)
                hx-post="{{ route('admin.settings.store') }}"
                hx-target="#validationerrors"
                hx-swap="innerHTML"
                @else
                action="{{ route('admin.settings.store') }}"
                @endif>

                @csrf

                <x-form.input name="category" id="category" label="Category" :value="old('category')" required />
                <br />

                <x-form.input name="name" id="name" label="Name" :value="old('name')" required />
                <br />

                <x-form.input name="value" id="value" label="Value" :value="old('value')" required />
                <br />

                <div id="validationerrors"></div>

                <x-form.button>Submit</x-form.button>

                <div id="loading" class="htmx-indicator">
                    <x-loadingindicator />
                </div>

            </form>

        </div>
    </div>

    @endfragment

    <br />
    <br />

</x-admin-layout>