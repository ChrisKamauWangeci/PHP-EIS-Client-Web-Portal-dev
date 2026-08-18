<x-user-layout>

    <h1>Edit Contractor</h1>

    <br />

    <h2>{{ $contractor->C_Name }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

        <form method="post" action="{{ route('user.contractors.update', $contractor->id ) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="C_Location" id="C_Location" label="Location" :value="old('C_Location', $contractor->C_Location )" />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-user-layout>