<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Create EHR Orders Search Results Exclusion</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.ehrorderssearchresultsexclusions.index') }}"
               class="btn btn-sm btn-secondary">View EHR Orders Search Results Exclusions</a>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('user.ehrorderssearchresultsexclusions.store') }}">
                @csrf

                <x-form.input name="managing_organization"
                              id="managing_organization"
                              label="Managing Organization"
                              :value="old('managing_organization')"
                              required />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-user-layout>
