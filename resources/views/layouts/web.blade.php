<!DOCTYPE html>
<html lang="zxx">

<head>
    {{-- <!-- ** Basic Page Needs ** -->
  <meta charset="utf-8">
  <title>Website IT Bhamada</title>
  <!-- ** Mobile Specific Metas ** -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Agency HTML Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Html5 Agency Template v1.0">
  <!-- theme meta -->
  <meta name="theme-name" content="megakit" /> --}}

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    {!! SEO::generate(true) !!}

    <!-- bootstrap.min css -->
    <link rel="stylesheet" href="{{ asset('megakit/theme/plugins/bootstrap/bootstrap.min.css') }}">
    <!-- Icon Font Css -->
    <link rel="stylesheet" href="{{ asset('megakit/theme/plugins/themify/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('megakit/theme/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('megakit/theme/plugins/magnific-popup/magnific-popup.css') }}">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="{{ asset('megakit/theme/plugins/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('megakit/theme/plugins/slick/slick-theme.css') }}">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('megakit/theme/css/style.css') }}">
    <!--Favicon-->
    <link rel="icon" href="{{ asset('megakit/theme/images/logo-bhamada-sm.png') }}" type="image/x-icon">
</head>

<body>

    <!-- Header Start -->
    <header class="navigation">
        <div id="navbar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg px-0 py-4">
                            <a class="navbar-brand" href="{{ url('/') }}">
                                <img src="{{ asset('megakit/theme/images/logo-bhamada-sm.png') }}" alt="Logo Bhamada"
                                    class="logo-image">
                                <div class="logo-title">
                                    <p>
                                        <span class="d-none d-md-inline">UPT Sistem Informasi dan Teknologi</span>
                                        <span class="d-inline d-md-none" id="logo-title-sm">UPT SIT</span>
                                        <span class="d-none d-md-inline"><br>Universitas Bhamada</span>
                                    </p>
                                </div>
                            </a>
                            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                                data-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span class="fa fa-bars"></span>
                            </button>

                            <div class="collapse navbar-collapse text-center" id="navbarsExample09">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ url('/') }}">Beranda</a>
                                    </li>
                                    <li class="nav-item {{ request()->is('about') ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ url('about') }}">Tentang</a>
                                    </li>
                                    <li
                                        class="nav-item dropdown {{ request()->is('tupoksi') || request()->is('bandwith') || request()->is('sistem') || request()->is('sop') ? 'active' : '' }}">
                                        <a class="nav-link dropdown-toggle" href="#" id="informasi"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Informasi
                                            <i class="fas fa-chevron-down small"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="informasi">
                                            <li>
                                                <a class="dropdown-item {{ request()->is('tupoksi') ? 'active' : '' }}"
                                                    href="{{ url('tupoksi') }}">Tupoksi</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item {{ request()->is('bandwith') ? 'active' : '' }}"
                                                    href="{{ url('bandwith') }}">Bandwith</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item {{ request()->is('sistem') ? 'active' : '' }}"
                                                    href="{{ url('sistem') }}">Sistem</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item {{ request()->is('sop') ? 'active' : '' }}"
                                                    href="{{ url('sop') }}">SOP</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item {{ request()->is('kuesioner') ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ url('kuesioner') }}">Kuesioner</a>
                                    </li>
                                    <li class="nav-item {{ request()->is('kontak') ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ url('kontak') }}">Kontak</a>
                                    </li>
                                </ul>
                                {{-- <div class="my-2 my-md-0 ml-lg-4 text-center">
                                    <a href="{{ url('login') }}" class="btn btn-solid-border btn-round-full"
                                        style="{{ request()->is('login') ? 'background-color: #FDED02; color: rgba(0, 0, 0, 0.65);' : '' }}">Buat
                                        Pengaduan</a>
                                </div> --}}
                                <div class="my-2 my-md-0 ml-lg-4 text-center">
                                    <a href="{{ url('peminjaman-cbt/create') }}" class="btn btn-solid-border btn-round-full"
                                        style="{{ request()->is('peminjaman-cbt/create') ? 'background-color: #FDED02; color: rgba(0, 0, 0, 0.65);' : '' }}">Peminjaman
                                        CBT</a>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Close -->

    @yield('content')

    <footer class="footer section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="widget">
                        <h4 class="text-capitalize mb-4">Tautan Langsung</h4>
                        <ul class="list-unstyled footer-menu lh-35">
                            <div class="row">
                                <div class="col-md-6">
                                    <li>
                                        <a href="{{ url('/') }}" class="text-color">Beranda</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('about') }}" class="text-color">Tentang</a>
                                    </li>
                                </div>
                                <div class="col-md-6">
                                    <li>
                                        <a href="{{ url('tupoksi') }}" class="text-color">Tupoksi</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('kontak') }}" class="text-color">Kontak</a>
                                    </li>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <div class="widget">
                        <div class="logo mb-4">
                            <h3>Unit Sistem Informasi dan Informasi</h3>
                            <h4>Universitas Bhamada Slawi</h4>
                        </div>
                        <h6>
                            <span>it@bhamada.ac.id</span>
                        </h6>
                        <span class="text-color h4">+23-456-6588</span>
                    </div>
                </div>
            </div>

            <div class="footer-btm pt-4 pb-2">
                <div class="copyright">
                    Copyright &copy; 2023, Designed &amp; Developed by <a href="">IT Bhamada</a>
                </div>
            </div>
        </div>
    </footer>

    <!--Scroll to top-->
    <div id="scroll-to-top" class="scroll-to-top">
        <span class="icon fa fa-angle-up"></span>
    </div>

    <!-- Main jQuery -->
    <script src="{{ asset('megakit/theme/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4.3.1 -->
    <script src="{{ asset('megakit/theme/plugins/bootstrap/bootstrap.min.js') }}"></script>
    <!--  Magnific Popup-->
    <script src="{{ asset('megakit/theme/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <!-- Slick Slider -->
    <script src="{{ asset('megakit/theme/plugins/slick/slick.min.js') }}"></script>
    <!-- Counterup -->
    <script src="{{ asset('megakit/theme/plugins/counterup/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('megakit/theme/plugins/counterup/jquery.counterup.min.js') }}"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC9sQe0xe3lP-1rJPA3kwl9JNVzTpGKunw" defer></script>
    <script src="{{ asset('megakit/theme/plugins/google-map/map.js') }}" defer></script>
    <script src="{{ asset('megakit/theme/js/script.js') }}"></script>
</body>

</html>
