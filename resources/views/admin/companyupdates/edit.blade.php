<x-admin-layout>

    <h1>Edit Company</h1>

    <br />

    <h2>{{ $companyupdate->name }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('admin.companyupdates.update', $companyupdate->id) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="name"
                              id="name"
                              label="Contact"
                              :value="old('name', $companyupdate->name)" />
                <br />

                <x-form.input name="filename"
                              id="filename"
                              label="Contact"
                              :value="old('filename', $companyupdate->filename)" />
                <br />

                <br />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            companyupdate
            @php dump(@$companyupdate) @endphp
        </div>
    @endif

</x-admin-layout>
