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
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body style="direction: rtl !important;font-family: vazir;" class="bg">
     <div id="app">
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
