@extends('layouts.web')

@section('content')
    <!-- Slider Start -->
    <section class="slider">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-10">
                    <div class="block">
                        <span class="d-block mb-4 text-white">Selamat Datang di</span>
                        <h1 class="animated fadeInUp mb-4">UPT Sistem Informasi<br>& Teknologi</h1>
                        <p>Universitas Bhamada Slawi</p>
                        <a href="{{ url('about') }}" class="btn btn-main animated fadeInUp btn-round-full"
                            aria-label="Get started">
                            Lihat
                            <i class="btn-icon fa fa-angle-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Intro Start -->
    <section class="section intro">
        <div class="container">
            <div class="row ">
                <div class="col-lg-8">
                    <div class="section-title">
                        <span class="h6 text-color">Home</span>
                        <h2 class="mt-3 content-title">{{ $identitas->nama }}</h2>
                    </div>
                </div>
            </div>
            <p class="mb-5">{{ $identitas->deskripsi }}</p>
        </div>
    </section>
    <!-- Section Intro END -->

    <!-- Section About Start -->
    <section class="section about position-relative">
        <div class="bg-about"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-6 offset-md-0">
                    <div class="about-item">
                        <span class="h6 text-color">Visi dan Misi</span>
                        <h2 class="my-3 position-relative content-title">{{ $identitas->nama }}</h2>
                        <div class="about-content">
                            <table>
                                <tr>
                                    <td class="number">
                                        <span class="h6 text-color">#</span>
                                    </td>
                                    <td class="description">
                                        <span class="h6 text-color">Visi</span>
                                        <p>{{ $identitas->visi }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="number">
                                        <span class="h6 text-color">#</span>
                                    </td>
                                    <td class="description">
                                        <span class="h6 text-color">Misi</span>
                                        <ol style="padding-left: 16px;">
                                            @foreach ($identitas->misi as $misi)
                                                <li style="padding-left: 8px;">
                                                    <p class="mb-0">{{ $misi }}</p>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section About End -->

    <!-- section Counter Start -->
    <section class="section counter">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="counter-item text-center mb-5 mb-lg-0">
                        <h3 class="mb-0">
                            <span class="counter-stat font-weight-bold">{{ $identitas->sistem }}</span>
                        </h3>
                        <p class="text-muted">Jumlah Sistem</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="counter-item text-center mb-5 mb-lg-0">
                        <h3 class="mb-0">
                            <span class="counter-stat font-weight-bold">{{ $identitas->website }}</span>
                        </h3>
                        <p class="text-muted">Jumlah Website</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="counter-item text-center mb-5 mb-lg-0">
                        <h3 class="mb-0">
                            <span class="counter-stat font-weight-bold">{{ $identitas->ap }}</span>
                        </h3>
                        <p class="text-muted">Jumlah Akses Point</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section Counter End  -->
@endsection
