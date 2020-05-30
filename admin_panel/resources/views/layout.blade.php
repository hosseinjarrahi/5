<!DOCTYPE html>

<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>پنل مدیریت | @yield('title')</title>

    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/bootstrap-rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/custom-style.css') }}">
    @yield('head')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <x-top-navigation></x-top-navigation>

    <x-menu></x-menu>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@yield('title')</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            @yield('content')
        </div>
    </div>

    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            تیزویران
        </div>
    </footer>
</div>


<script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/dist/js/adminlte.js') }}"></script>

<script src="{{ asset('/assets/dist/js/demo.js') }}"></script>

<script src="{{ asset('/assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('/assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/chartjs-old/Chart.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/select2/select2.full.min.js') }}"></script>

<script src="{{ asset('/assets/dist/js/pages/dashboard2.js') }}"></script>

<script>
    function slugify(text) {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '');            // Trim - from end of text
    }
</script>

@yield('script')

</body>
</html>
