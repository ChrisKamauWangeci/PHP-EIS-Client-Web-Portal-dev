<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Edit Inquiry</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.inquiries.index') }}"
               class="btn btn-sm btn-secondary">Inquiries</a>
            <a href="{{ route('user.inquiries.update', $inquiry->id) }}"
               class="btn btn-sm btn-secondary">View Inquiry</a>
        </div>
    </div>

    <br />
    <br />

    <div class="row">
        <div class="col-md-6">

            <form method="post"
                  action="{{ route('user.inquiries.update', $inquiry->id) }}">
                @csrf
                @method('PATCH')

                <x-form.textarea name="message"
                                 id="message"
                                 label="Address"
                                 :value="old('message', $inquiry->message)" />

                <br />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>
        </div>
    </div>

    <br />
    <br />

</x-user-layout>
