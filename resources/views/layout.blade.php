<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <style>
        @font-face {
            font-family: vazir;
            src: url({{ asset('fonts/Vazir.ttf') }});
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body style="direction: rtl !important;font-family: vazir;">
<div id="pageLoader" class="pageLoader d-flex justify-content-center align-items-center" style="z-index: 500">
    <img src="{{ asset('img/logo.png') }}"
         alt="tizviran logo"
         class="img-fluid"
         style="max-width: 200px">
</div>

<div id="app">
    <app-loading></app-loading>
    <app-header></app-header>
    <div class="mt-5"></div>
    @yield('content')
    <app-footer>
        تمامی حقوق سایت متعلق به تیزویران می باشد.
    </app-footer>
</div>
</body>
<script src="{{ asset('js/app.js') }}"></script>
</html>
