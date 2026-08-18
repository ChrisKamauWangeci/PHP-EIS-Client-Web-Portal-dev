<x-admin-layout title="">

    <h1>Azure Editor</h1>

    <div class="row">
        <div class="col-12 col-md-11 col-lg-10 col-xl-9 pt-2">

            <form method="POST" action="{{ route('admin.azure.update', 1) }}">
                @csrf
                @method('PUT')
                <x-form.textarea name="content" id="content" label="Content" :value="old('content', $content)" :rows="100" :cols="120" required />
                <br>
                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-admin-layout>
