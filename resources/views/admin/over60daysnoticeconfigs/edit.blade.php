<x-admin-layout>

    <h1>Edit Over 60 Days Notice Config</h1>

    <br />

    <h2>{{ $over60daysnoticeconfig->C_Name }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('admin.over60daysnoticeconfigs.update', $over60daysnoticeconfig->id) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="Company"
                              label="Company"
                              :value="old('Company', $over60daysnoticeconfig->Company)"
                              required />
                <br />

                <x-form.input name="EmailTo"
                              label="Email To"
                              :value="old('EmailTo', $over60daysnoticeconfig->EmailTo)"
                              required />
                <br />

                <x-form.input name="SendNoticeDays"
                              label="Send Notice Days"
                              :value="old('SendNoticeDays', $over60daysnoticeconfig->SendNoticeDays)"
                              required />
                <br />

                <x-form.input name="CancelDays"
                              label="Cancel Days"
                              :value="old('CancelDays', $over60daysnoticeconfig->CancelDays)"
                              required />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            company
            @php dump(@$company) @endphp
        </div>
    @endif

</x-admin-layout>
