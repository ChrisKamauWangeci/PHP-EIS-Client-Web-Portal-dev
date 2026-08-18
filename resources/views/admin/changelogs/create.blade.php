<x-admin-layout>

    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <style>
        #editor {
            height: 400px;
        }
    </style>

    <div class="row">
        <div class="col-auto">
            <h1>Create Changelog</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.changelogs.index') }}" class="btn btn-sm btn-secondary">View Changelogs</a>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('admin.changelogs.store') }}">
                @csrf

                <x-form.input name="title" label="Title" :value="old('title')" />
                <br />

                <div style="margin-top: 10px;">
                    <label for="content">Description:</label>
                    <div id="editor">{!! old('description') !!}</div>

                    <textarea name="description" id="description" style="display:none;">{!! old('description') !!}</textarea>
                </div>
                <br />

                <x-form.input type="date" name="released_at" label="Release Date" :value="old('released_at')" />
                <br />

                <x-form.checkbox name="is_active" label="Is Active" :checked="old('is_active', false)" />
                <br />

                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

    <script src="https://cdn.quilljs.com/1.3.7/quill.js"></script>
    <script>
        const quill = new Quill('#editor', {
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, 3, false]
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'align': ''
                    }, {
                        'align': 'center'
                    }, {
                        'align': 'right'
                    }, {
                        'align': 'justify'
                    }],
                    ['link', 'image', 'blockquote', 'code-block', 'clean']
                ]
            },
            theme: 'snow',
        });

        // On form submit, copy HTML description from Quill to the hidden textarea
        document.querySelector('form').onsubmit = function() {
            document.querySelector('#description').value = quill.root.innerHTML;
        };
    </script>

</x-admin-layout>