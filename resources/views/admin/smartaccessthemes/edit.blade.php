<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Edit Smart Access Theme</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.smartaccessthemes.show', $smartaccesstheme->id) }}" class="btn btn-sm btn-secondary">View Smart Access Theme</a>
        </div>
    </div>

    <br />

    <h2>{{ $smartaccesstheme->id }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('admin.smartaccessthemes.update', $smartaccesstheme->id ) }}">
                @csrf
                @method('PATCH')

                <br />

                <x-form.input name="company_name" id="company_name" label="Company Name" :value="old('company_name', $smartaccesstheme->company_name)" required />
                <br />

                <x-form.input name="slug" id="slug" label="Slug" :value="old('slug', $smartaccesstheme->slug)" required />
                <br />

                <x-form.input name="backgroundcolor" id="backgroundcolor" label="Background Color" :value="old('backgroundcolor', $smartaccesstheme->backgroundcolor)" required />
                <br />

                <x-form.input name="headercolor" id="headercolor" label="Header Color" :value="old('headercolor', $smartaccesstheme->headercolor)" required />
                <br />

                <x-form.input name="fontcolor" id="fontcolor" label="Font Color" :value="old('fontcolor', $smartaccesstheme->fontcolor)" required />
                <br />

                <x-form.input name="logobackgroundcolor" id="logobackgroundcolor" label="Logo Background Color" :value="old('logobackgroundcolor', $smartaccesstheme->logobackgroundcolor)" required />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-admin-layout>