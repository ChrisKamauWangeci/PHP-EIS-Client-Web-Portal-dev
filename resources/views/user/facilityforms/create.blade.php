<x-user-layout title="">

    <div class="row">
        <div class="col">
            <h1>Create Facility Form</h1>
        </div>
        <div class="col-auto text-end">
            <a href="{{ route('user.facilityforms.index') }}"
               class="btn btn-sm btn-secondary">Facility Forms</a>
        </div>
    </div>

    <br />

    <div class="col-md-6">

        <form method="post"
              action="{{ route('user.facilityforms.store') }}">
            @csrf

            <x-form.input name="name"
                          label="Name"
                          :value="old('name')"
                          maxlength="50"
                          required />
            <br />

            <x-form.input name="slug"
                          label="Slug"
                          :value="old('slug')"
                          maxlength="50" />
            <br />

            <x-form.input name="file_name"
                          label="File Name"
                          :value="old('file_name')"
                          maxlength="50" />
            <br />

            <x-form.input name="docusign_templateid_production"
                          label="Docusign Template ID Production"
                          :value="old('docusign_templateid_production')"
                          maxlength="50" />
            <br />

            <x-form.checkbox name="internal_form"
                             label="Internal Form" />
            <br />

            <x-form.input name="website"
                          label="Website"
                          :value="old('website')"
                          maxlength="100" />
            <br />

            <x-form.input name="version"
                          label="Version"
                          :value="old('version')"
                          maxlength="50" />
            <br />

            <x-form.input type="date"
                          name="revision_date"
                          label="Revision Date"
                          :value="old('revision_date')" />
            <br />

            <x-form.button>Submit</x-form.button>

        </form>

    </div>

    <br />
    <br />

    <script>
        function slug(string) {
            string = string.toString()
                .normalize('NFD')
                .toLowerCase()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/&/g, '-and-') // Replace & with 'and'
                .replace(/[^\w\-]+/g, '') // Remove all non-word characters
                .replace(/\-\-+/g, '-') // Replace multiple - with single -
                .replace(/^-+/, '') // Trim - from start of text
                .replace(/-+$/, '');
            return string;
        }

        document.getElementById('name').addEventListener('input', function() {
            let string = document.getElementById('name').value;
            const newstring = slug(string);
            document.getElementById('name').value = string.split(' ')
                .map(function(a) {
                    return a.charAt(0).toUpperCase() + a.substr(1);
                })
                .join(' ');
            document.getElementById('slug').value = newstring;
            document.getElementById('file_name').value = newstring + '.pdf';
        });
    </script>

</x-user-layout>
