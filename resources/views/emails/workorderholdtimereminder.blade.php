<x-email>

    *** THIS IS AN AUTOMATED NOTIFICATION. DO NOT REPLY ***
    <br />
    <br />
    Dear {{ $data['data']['workorderholdtime']['requestor_name'] }},
    <br />
    <br />
    We would like to inform you that we are still waiting for information/response from you before we can continue
    processing your APS request.
    <br />
    <br />
    Workorder: {{ $data['data']['workorderholdtime']['workorder_id'] }}
    <br />
    Company: {{ $data['data']['workorderholdtime']['company_name'] }}
    <br />
    Applicant Name: {{ $data['data']['workorderholdtime']['W_FirstName'] }}
    {{ $data['data']['workorderholdtime']['W_LastName'] }}
    <br />
    Facility / Dr.: {{ $data['data']['workorderholdtime']['W_Hospital'] }}
    <br />
    <br />
    Requested Information: {{ $data['data']['statustrigger']['laststatus'] }}
    <br />
    <br />
    Please feel free to contact our Account Manager {{ $data['data']['workorderholdtime']['contractor_name'] }} if you
    have any questions or concerns.
    <br />
    <br />
    Regards,<br />
    {{ $data['data']['workorderholdtime']['contractor_name'] }}<br />
    {{ $data['data']['workorderholdtime']['contractor_email'] }}<br />
    Express Imaging Services, Inc.<br />
    1805 W. 208th St., Suite 202<br />
    Torrance, CA 90501<br />
    t: 888-846-8804<br />
    www.expressimagingservices.com<br />
    <br />

</x-email>
