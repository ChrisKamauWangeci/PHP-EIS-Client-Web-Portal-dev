<!doctype html>
<html>

<head>

    <title></title>

    <style type="text/css">
        html {
            font-size: 100%;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            background-color: #FFFFFF;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
            /* line-height: 15px; */
            color: #333333;
            background-color: #FFFFFF;
            margin: 10px;
        }

        img {
            border: none;
            max-width: 100%;
        }
    </style>

</head>

<body>

    <!--[if mso]>
    <table role="presentation" width="800" cellpadding="0" cellspacing="0" border="0" align="left" style="width: 800px;">
    <tr><td>
    <![endif]-->

    <div style="max-width: 800px;">
        {{ $slot }}
    </div>

    <!--[if mso]>
    </td></tr>
    </table>
    <![endif]-->

</body>

</html>
