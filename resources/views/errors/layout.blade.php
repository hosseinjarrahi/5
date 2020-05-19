<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <meta name="description" content=" تیزویران | @yield('code')">
    <link rel="icon" href="/img/favicon.png" type="image/png" sizes="50x50">

    <title>@yield('title')</title>
    <style>
        body {
            height: 100%;
            width: 100%;
            background: #F00000; /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #DC281E, #F00000); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #DC281E, #F00000); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }
    </style>
</head>
<body>

<div id="pageLoader" class="pageLoader flex-column d-flex justify-content-center align-items-center" style="z-index: 500">
    <img src="{{ asset('img/logo.png') }}"
         alt="tizviran logo"
         class="img-fluid"
         style="max-width: 200px">

    <div class="mt-5 bg-light shadow px-2 py-1 rounded" style="font-size: 1.5rem">
        @yield('message')
    </div>

    <a href="{{ route('home') }}" class="mt-5 btn btn-info shadow">
        بازگشت به صفحه اصلی
        <span class="mx-1 fas fa-arrow-left"></span>
    </a>
</div>

</body>
</html>
