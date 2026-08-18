EIS Login Verification

Contractor: {{ $data['session']['contractor']['C_Name'] }}
Database: {{ $data['subdomain'] }}
IP Address: {{ request()->ip() }}

Code: {{ $data['code'] }}

https://{{ $data['subdomain'] }}.expressimagingservices.net/contractors/ipconfirm?code={{ $data['code'] }}
