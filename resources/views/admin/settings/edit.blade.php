<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Edit Setting</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.settings.show', $setting->id) }}" class="btn btn-sm btn-secondary">View Setting</a>
        </div>
    </div>

    <br />

    <h2>{{ $setting->id }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('admin.settings.update', $setting->id ) }}">
                @csrf
                @method('PATCH')

                <br />

                <x-form.input name="category" id="category" label="Category" :value="old('category', $setting->category)" required />
                <br />

                <x-form.input name="name" id="name" label="Name" :value="old('name', $setting->name)" required />
                <br />

                <x-form.input name="value" id="value" label="Value" :value="old('value', $setting->value)" required />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-admin-layout>