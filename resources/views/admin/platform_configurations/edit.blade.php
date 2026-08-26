<x-admin-layout>
    <div class="row">
        <div class="col-auto">
            <h1>Edit Platform Configuration</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.platform-configurations.show', $platformConfiguration->id) }}"
               class="btn btn-sm btn-secondary">View Platform Configuration</a>
        </div>
    </div>

    <br />

    <h2>{{ $platformConfiguration->id }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('admin.platform-configurations.update', $platformConfiguration->id) }}">
                @csrf
                @method('PATCH')

                <input type="hidden"
                       name="company"
                       value="{{ $platformConfiguration->company }}" />

                <x-form.select name="platform"
                               label="Platform"
                               :options="Helper::platforms()"
                               empty="-"
                               :default="old('platform', $platformConfiguration->platform)"
                               required />
                <br />

                <x-form.select name="order_type"
                               label="Order Type"
                               :options="Helper::ordertypes()"
                               empty="-"
                               :default="old('order_type', $platformConfiguration->order_type)"
                               required />
                <br />

                <x-form.select name="submission_type"
                               label="Submission Type"
                               :options="Helper::submissiontypes()"
                               empty="-"
                               :default="old('submission_type', $platformConfiguration->submission_type)"
                               required />
                <br />

                <x-form.select name="wait_days"
                               label="Wait Days"
                               :options="array_combine(range(1, 30), range(1, 30))"
                               empty="-"
                               :default="old('wait_days', $platformConfiguration->wait_days)"
                               required />
                <br />

                <x-form.select name="sequence"
                               label="Sequence"
                               :options="array_combine(range(1, 30), range(1, 30))"
                               empty="-"
                               :default="old('sequence', $platformConfiguration->sequence)"
                               required />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-admin-layout>
