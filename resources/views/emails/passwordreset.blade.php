<x-email>

    <h1>Password Reset</h1>

    <h2>{{ $data['subdomain'] }}</h2>

    You are receiving this email because we received a password reset request for your account.

    <br />
    <br />

    https://{{ $data['subdomain'] }}.expressimagingservices.net/passwordresets/create?token={{ $data['token'] }}

    <br />
    <br />

    {{ $data['contractor']['C_Email'] }}

    <br />

    {{ request()->ip() }}

    <br />
    <br />

    If you did not request a password reset, no further action is required.

    <br />
    <br />

</x-email>
