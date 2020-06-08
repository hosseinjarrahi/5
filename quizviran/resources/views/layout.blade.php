<!DOCTYPE html>
<html lang="fa">
<head>
    @authEl
    <meta charset="utf-8">
    <meta name="keywords" content="@yield('keywords','')">
    <meta name="description" content="@yield('description','')">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme" color="red">
    <link rel="icon" href="/img/favicon.png" type="image/png" sizes="50x50">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('quiz-assets/css/app.css?version-2') }}">
    @yield('head')
    <title>@yield('title')</title>
</head>
<body style="direction: rtl !important;">

<div id="pageLoader" class="pageLoader flex-column d-flex justify-content-center align-items-center" style="z-index: 500">
    <img src="{{ asset('img/logo.png') }}"
         alt="tizviran logo"
         class="img-fluid"
         style="max-width: 200px">

    <div class="sk-chase mt-5">
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
    </div>
</div>

<div id="app">
    <app-loading></app-loading>

    @if(auth()->check() && auth()->user()->isAdmin())
        <a class="d-block text-white bg-gray p-1 text-center" style="position:fixed;bottom: 10px;left: 10px;"
           href="{{ url('/manager') }}">مدیریت</a>
    @endif

    <app-header :event="{{ $topEvent->toJson() }}" :notifications="{{ $notifications }}"></app-header>
    @yield('content')
    <app-footer>
        تمامی حقوق سایت متعلق به تیزویران می باشد.
    </app-footer>
</div>

</body>

<script src="{{ asset('quiz-assets/js/app.js?version-2') }}"></script>
<script async src="https://cdn.jsdelivr.net/npm/mathjax@2/MathJax.js?config=TeX-MML-AM_SVG"></script>
@yield('script')
</html>
