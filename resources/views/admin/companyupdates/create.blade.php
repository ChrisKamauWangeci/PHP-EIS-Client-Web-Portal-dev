<x-admin-layout>

    <h1>Create Company Update</h1>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('admin.companyupdates.store') }}">
                @csrf

                <x-form.input name="name"
                              id="name"
                              label="Name"
                              :value="old('name')" />
                <br />

                <x-form.input name="filename"
                              id="filename"
                              label="filename"
                              :value="old('filename')" />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-admin-layout>
