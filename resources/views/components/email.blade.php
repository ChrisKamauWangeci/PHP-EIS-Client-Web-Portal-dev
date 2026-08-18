<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="x-apple-disable-message-reformatting">

    <title></title>

    <style type="text/css">
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 1.4;
            color: #333333;
            background-color: #ffffff;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        img {
            display: block;
            border: 0;
            max-width: 100%;
            height: auto;
        }

        table.table {
            border-collapse: collapse;
            border: 1px solid #888;
        }

        .table th,
        .table td {
            padding: 2px;
            text-align: left;
            border: 1px solid #888;
        }

    </style>

</head>

<body style="margin:0; padding:0; font-family:Helvetica, Arial, sans-serif; font-size:14px; line-height:1.4; color:#333333; background-color:#ffffff; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;">

    <div style="font-family:Helvetica, Arial, sans-serif; font-size:14px; line-height:1.4; color:#333333;">

        {{ $slot }}

        <br />
        <br />

        <table role="presentation" cellpadding="0" cellspacing="0">
            <tr>
                <td style="padding-right:10px;">
                    <img src="https://www.expressimagingservices.com/img/eis-logo-100.png" alt="Express Imaging Services" width="50" style="display:block; border:0; max-width:100%; height:auto;">
                </td>
                <td valign="middle">
                    &copy; {{ date('Y') }} Express Imaging Services, Inc.
                    <br />
                    <a href="https://www.expressimagingservices.com">www.expressimagingservices.com</a>
                </td>
            </tr>
        </table>

        <p style="font-size:12px; color:#777777;">
            <strong>CONFIDENTIALITY NOTICE:</strong> This message is intended to be viewed only by the listed recipient(s).
            It may contain information that is privileged, confidential, and/or exempt from disclosure under applicable law.
            Any dissemination, distribution, or copying of this message is strictly prohibited without prior written permission.
            If you are not an intended recipient, please notify us immediately by return e-mail and permanently remove the original message and any copies from your systems.
        </p>

    </div>

</body>

</html>