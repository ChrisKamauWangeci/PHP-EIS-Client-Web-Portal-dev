<x-email>

    <h1>Login Verification Code</h1>

    {{ $data['contractor']->C_Name }}
    <br />
    <br />

    Verification Code: <strong>{{ $data['code'] }}</strong>
    <br />
    <br />

    https://{{ $data['subdomain'] }}.expressimagingservices.net/authadmin/ipconfirm?code={{ $data['code'] }}

    <br />

</x-email>
