<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Edit EHR Orders Search Results Exclusion</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.ehrorderssearchresultsexclusions.index') }}" class="btn btn-sm btn-secondary">View EHR Orders Search Results Exclusions</a>
        </div>
    </div>

    <br />
    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('user.ehrorderssearchresultsexclusions.update', $ehrorderssearchresultsexclusion->id ) }}">
                @csrf
                @method('PATCH')

                <br />

                <x-form.input name="managing_organization" id="managing_organization" label="Managing Organization" :value="old('managing_organization', $ehrorderssearchresultsexclusion->managing_organization)" required />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

    <a href="{{ route('user.ehrorderssearchresultsexclusions.show', $ehrorderssearchresultsexclusion->id) }}" class="btn btn-sm btn-secondary">View</a>

    <br />
    <br />

</x-user-layout>