<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0" />
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.4;
        }

        .text-center {
            text-align: center !important;
        }

        h1 {
            margin: 0;
        }

        h2 {
            margin: 0;
        }

        .w-100 {
            width: 100% !important;
        }

        .border {
            border: 1px solid #000;
        }

        b,
        strong {
            font-weight: bolder;
        }

        small,
        .small {
            font-size: 0.875em;
        }

        .fw-bold {
            font-weight: 700 !important;
        }

        .p-1 {
            padding: 0.25rem !important;
        }

        .p-2 {
            padding: 0.5rem !important;
        }

        .p-3 {
            padding: 1rem !important;
        }

        .p-4 {
            padding: 1.5rem !important;
        }

        .p-5 {
            padding: 3rem !important;
        }

        .pt-1 {
            padding-top: 0.25rem !important;
        }

        .pt-2 {
            padding-top: 0.5rem !important;
        }

        .float-start {
            float: left !important;
        }

        .float-end {
            float: right !important;
        }
    </style>
</head>

<body>
    {{ $slot }}
</body>

</html>
