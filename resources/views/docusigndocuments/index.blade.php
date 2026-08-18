<x-nomenu-layout title="">

    <h1>Request Docusign Security Code</h1>

    <div class="row">
        <div class="col-11 col-sm-6 col-md-5 col-lg-4">

            <form method="POST" action="{{ route('docusigncode.sendcode') }}">
                @csrf

                <x-form.input name="email" label="Email" :value="old('email')" required autofocus maxlength="50" />

                <br />
                <br />

                <x-form.button>Submit</x-form.button>

            </form>

            @if($errors->any())
            <div class="py-4 text-danger">{{$errors->first()}}</div>
            @endif

        </div>
    </div>


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

        Security Monitoring: All activities on this system are monitored and logged for security and compliance purposes. Unauthorized access or use may be subject to disciplinary action, prosecution, or penalties under applicable laws.

        <br />
        <br />

        Confidentiality: You agree to handle all data securely and responsibly, ensuring no unauthorized access to sensitive or confidential information.

        <br />
        <br />

        If you are not an authorized user, please disconnect immediately.

        <br />

    </div>

</x-nomenu-layout>