<x-app-layout title="">

    <h1>Login</h1>

    <div class="row">
        <div class="col-11 col-sm-6 col-md-5 col-lg-4">

            <form method="POST"
                  action="{{ route('authuser.in') }}">
                @csrf

                <x-form.input name="C_Name"
                              label="Name"
                              :value="old('C_Name')"
                              maxlength="50"
                              required />

                <br />

                <x-form.input type="password"
                              name="C_Password"
                              label="Password"
                              maxlength="50"
                              required />

                <br />

                <x-form.button>Submit</x-form.button>

            </form>

            @if ($errors->any())
                <div class="py-4 text-danger">{{ $errors->first() }}</div>
            @endif

        </div>
    </div>


    <br />
    <br />
    <a href="{{ route('passwordresets.index') }}">Password Reset</a>
    <br />
    <br />
    <a href="{{ route('authadmin.login') }}">Admin Login</a>
    <br />
    <br />

    <small>IP Address: {{ request()->ip() }}</small>

    <br />
    <br />

    <div class="p-3 bg-body-tertiary">

        <strong>WARNING: Authorized Use Only</strong>
        <br />
        <br />

        This system is for authorized use only. By accessing this system, you acknowledge and agree to the following:
        <br />
        <br />

        Compliance: You will comply with all applicable legal, regulatory, and company policies.
        <br />
        <br />

        Security Monitoring: All activities on this system are monitored and logged for security and compliance
        purposes. Unauthorized access or use may be subject to disciplinary action, prosecution, or penalties under
        applicable laws.
        <br />
        <br />

        Confidentiality: You agree to handle all data securely and responsibly, ensuring no unauthorized access to
        sensitive or confidential information.
        <br />
        <br />

        If you are not an authorized user, please disconnect immediately.
        <br />

    </div>

</x-app-layout>
