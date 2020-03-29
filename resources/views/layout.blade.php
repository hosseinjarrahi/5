<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description','تیزویران - آموزن ساز , آموزش رایگان هفتم هشتم نهم , بهترین سایت آموزش دروس متوسطه')">
    <meta name="keywords" content="@yield('keywords','تیزویران - آموزن ساز , آموزش رایگان هفتم هشتم نهم , بهترین سایت آموزش دروس متوسطه')">

    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body style="direction: rtl !important;">
    
<div id="pageLoader" class="pageLoader flex-column d-flex justify-content-center align-items-center" style="z-index: 500">
    <img src="{{ asset('img/logo.png') }}"
         alt="tizviran logo"
         class="img-fluid"
         style="max-width: 200px">

    <div class="spinner-border text-white" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<div id="app">
    <app-loading></app-loading>

    @if(auth()->check() && auth()->user()->isAdmin())
        <a class="d-block text-white bg-gray p-1 text-center admin-panel"
           href="{{ url('admin') }}">مدیریت</a>
    @endif

    <app-header></app-header>
    @yield('content')
    <app-footer>
        تمامی حقوق سایت متعلق به تیزویران می باشد.
    </app-footer>
</div>

</body>
<script src="{{ mix('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js?config=TeX-AMS_HTML"></script>
</html>
