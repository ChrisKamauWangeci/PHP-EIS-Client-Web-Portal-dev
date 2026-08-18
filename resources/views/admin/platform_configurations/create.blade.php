<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Create Platform Configurations</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.platform-configurations.index') }}" class="btn btn-sm btn-secondary">View Platform Configurations</a>
        </div>
    </div>

    <br />

    @fragment('formstore')

    <div class="row">
        <div class="col-sm-6">


            @if ($isHtmx)
            <form hx-post="{{ route('admin.platform-configurations.store') }}" hx-target="#validationerrors" hx-swap="innerHTML">
                @else
                <form method="post" action="{{ route('admin.platform-configurations.store') }}">
                    @endif

                    @csrf

                    <x-form.select name="company" label="Company" :options="$companies" empty="-" :default="old('company')" required />
                    <br />

                    <x-form.select name="platform" label="Platform" :options="Helper::platforms()" empty="-" :default="old('platform')" required />
                    <br />

                    <x-form.select name="order_type" label="Order Type" :options="Helper::ordertypes()" empty="-" :default="old('order_type')" required />
                    <br />

                    <x-form.select name="submission_type" label="Submission Type" :options="Helper::submissiontypes()" empty="-" :default="old('submission_type')" required />
                    <br />

                    <x-form.select name="wait_days" label="Wait Days" :options="array_combine(range(1, 30), range(1, 30))" empty="-" :default="old('wait_days')" required />
                    <br />

                    <x-form.select name="sequence" label="Sequence" :options="array_combine(range(1, 30), range(1, 30))" empty="-" :default="old('sequence')" required />
                    <br />

                    <x-form.checkbox name="is_active" label="Is Active" :checked="old('is_active')" />
                    <br />

                    <div id="validationerrors"></div>

                    <x-form.button>Submit</x-form.button>
                </form>

        </div>
    </div>

    @endfragment

    <br />
    <br />

</x-admin-layout>