<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>پنل ادمین</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
</head>
<body>

<div id="app">
    <v-app class="font">
        <app-menu></app-menu>
        <app-bar></app-bar>

        <v-content>
        @yield('content')
        </v-content>
    </v-app>
</div>

</body>
<script src="{{ asset('assets/js/app.js') }}"></script>
</html>