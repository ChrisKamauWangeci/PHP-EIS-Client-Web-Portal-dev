<!DOCTYPE html>
<html lang="en">
<head>
    <title>EIS Online</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="apple-touch-icon" href="/img/apple-touch-icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/css.css">
    <script src="/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">

        <div class="p-3 bg-white">
            <div class="row">
                <div class="col-sm-2 d-none1 d-sm-block">
                    <img src="/img/eis-logo.png" height="70" alt="EIS">
                </div>
                <div class="col-12 col-sm-8">
                    <div class="d-flex justify-content-center">
                    </div>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-dark border-start border-danger border-4 bg{{ $subdomain }}">
            <div class="container-fluid">
                <span class="navbar-brand">EIS</span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="/contractors/login">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="p-3 bg-white">
            <x-flash />
            {{ $slot }}
        </div>

        @include('partials.footer')

    </div>
</body>
</html>