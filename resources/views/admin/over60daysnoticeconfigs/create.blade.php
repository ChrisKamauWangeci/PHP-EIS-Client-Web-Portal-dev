<x-admin-layout>

    <h1>Create Over 60 Days Notice Config</h1>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('admin.over60daysnoticeconfigs.store') }}">
                @csrf

                <x-form.input name="Company"
                              label="Company"
                              :value="old('Company')"
                              required />
                <br />

                <x-form.input name="EmailTo"
                              label="Email To"
                              :value="old('EmailTo')"
                              required />
                <br />

                <x-form.input name="SendNoticeDays"
                              label="Send Notice Days"
                              :value="old('SendNoticeDays')"
                              required />
                <br />

                <x-form.input name="CancelDays"
                              label="Cancel Days"
                              :value="old('CancelDays')"
                              required />
                <br />

                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-admin-layout>
