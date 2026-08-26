<x-email>

    Dear {{ $data['data']['data']['patient_first_name'] }} {{ $data['data']['data']['patient_last_name'] }},
    <br />
    <br />
    We hope this message finds you well.
    <br />
    <br />
    As part of your authorization request, please find your secure <strong>S.A.R.A. access code</strong> below. This
    code allows you to review and complete your authorization through our secure system.
    <br />
    <br />
    <strong>S.A.R.A. Access Code: {{ $data['data']['data']['access_code'] }}</strong>
    <br />
    <br />
    Please keep this code confidential and use it only for this request. If you experience any issues accessing the
    authorization or need assistance, our team is happy to help.
    <br />
    <br />
    Thank you for your cooperation. Your timely response helps keep your application moving forward.
    <br />
    <br />
    <br />
    Warm regards,
    <br />
    Express Imaging Services, Inc.<br />
    1805 W. 208th St., Suite 202<br />
    Torrance, CA 90501<br />
    t: 888-846-8804<br />
    www.expressimagingservices.com<br />
    <br />

    @php
        $encryptedId = encrypt($data['data']['data']['id']);
        $pixelUrl = route('docusigndocuments.dst') . '?id=' . rawurlencode($encryptedId);
    @endphp

    <img src="{{ $pixelUrl }}"
         alt=""
         width="1"
         height="1">

</x-email>
