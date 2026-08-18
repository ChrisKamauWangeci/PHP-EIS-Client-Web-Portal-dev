<x-app-layout title="">

    <h1>Password Reset</h1>

    <div class="row">
        <div class="col-11 col-sm-6 col-md-5 col-lg-4">

            To reset your password, please enter your email address.

            <br />
            <br />

            <form method="post" action="{{ route('passwordresets.index') }}">
                @csrf

                <x-form.input type="email" name="C_Email" label="Email" :value="old('C_Email')" required autofocus  minlength="5" maxlength="50" />

                <br />

                <x-form.button>Submit</x-form.button>

            </form>

        </div>
    </div>

    <br />
    <br />

</x-app-layout>