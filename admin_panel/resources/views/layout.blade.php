<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>پنل ادمین</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body style="background-color: #f5f5f5">

<div id="app">
    <main class="container">
        @yield('content')
    </main>
    <app-menu></app-menu>
</div>

</body>
<script src="{{ asset('assets/js/app.js') }}"></script>
</html>