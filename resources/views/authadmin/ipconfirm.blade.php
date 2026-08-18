<x-app-layout title="">

    <h1>Admin Login Verification Code</h1>

    <br />

    We've sent an email message containing a verification code to your inbox.

    <br />
    <br />

    <div class="row">
        <div class="col-11 col-sm-6 col-md-5 col-lg-4">

            <form method="post" action="{{ route('authadmin.ipconfirmin') }}">
                @csrf

                <x-form.input name="code" label="Verification Code" :value="old('code')" maxlength="8" required />
                <br />

                <x-form.button>Submit</x-form.button>

            </form>

        </div>
    </div>

    <br />
    <br />
    <br />
    <br />

    <small>IP Address: {{ request()->ip() }}</small>

</x-app-layout>