<x-email>

    <h1>Login Verification Code</h1>

    verification code: <strong>{{ $data['code'] }}</strong>

    <br />
    <br />

    https://{{ $data['subdomain'] }}.expressimagingservices.net/contractors/ipconfirm?code={{ $data['code'] }}

    <br />

</x-email>
