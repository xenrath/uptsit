<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <!--Favicon-->
    <link rel="icon" href="{{ asset('storage/uploads/asset/logo-bhamada-sm.png') }}" type="image/x-icon">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css?v=3.2.0') }}">

    @yield('css')

</head>

<body class="hold-transition sidebar-mini layout-fixed">

    @include('sweetalert::alert')

    <div class="wrapper">

        @yield('loader')

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="" class="brand-link">
                <img src="{{ asset('storage/uploads/unit/logo.png') }}" alt="Admin SIT" class="brand-image"
                    style="border-radius: 50%">
                <span class="brand-text font-wight-bold">UPT SIT</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @if (auth()->user()->isAdmin())
                            @include('layouts.menu.admin')
                        @endif
                        @if (auth()->user()->isUser())
                            @include('layouts.menu.user')
                        @endif
                        <br><br>
                        <li class="nav-item">
                            <button type="button" class="btn btn-danger btn-block btn-flat" data-toggle="modal"
                                data-target="#modal-logout">Logout</button>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        @yield('content')

        <div class="modal fade" id="modal-logout">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Logout</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin keluar sistem <strong>UPT SIT</strong>?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm btn-flat"
                            data-dismiss="modal">Batal</button>
                        <form action="{{ url('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm btn-flat">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <footer class="main-footer">
            <strong>Copyright © 2023. All right reserved.</strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 2.10.10
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js?v=3.2.0') }}"></script>

    @yield('script')
    
</body>

</html>
