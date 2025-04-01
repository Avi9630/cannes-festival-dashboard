<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('public/admin-iffi/images/favicon.png') }}">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-iffi/css/css.css') }}">
    <link href="{{ asset('admin-iffi/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="iffi-page-wrapper pt-5">
        <div class="iffi-one-bg-position iffi-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>
            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>
        <div class="iffi-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-4 text-white-50">
                            <div>
                                <a href="{{ url('/') }}" class="d-inline-block iffi-logo">
                                    <img src="{{ asset('cannes/CANNES.png') }}" alt="" style="height: 60px">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @yield('content')
            </div>
        </div>
    </div>
    @include('auth.layouts.footer')
</body>

</html>
