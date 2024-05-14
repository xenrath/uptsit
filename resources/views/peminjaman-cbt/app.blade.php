<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css?v=3.2.0') }}">

    @yield('css')
</head>

<body class="hold-transition layout-top-nav">

    @include('sweetalert::alert')

    <div class="wrapper">

        @yield('content')

        <footer class="main-footer">
            <strong>Copyright &copy; 2023, Designed &amp; Developed by <a href="">IT Bhamada</a></strong>
        </footer>
    </div>

    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js?v=3.2.0') }}"></script>

    @yield('script')
</body>

</html>
