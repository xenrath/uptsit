@extends('layouts.web')

@section('content')
    <section class="page-title bg-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">About</span>
                        <h1 class="text-capitalize mb-4 text-lg">Unit SIT</h1>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="index.html" class="text-white">Home</a>
                            </li>
                            <li class="list-inline-item">
                                <span class="text-white">/</span>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="text-white-50">About</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-info section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <div class="section-title">
                        <span class="h6 text-color">Visi dan Misi</span>
                        <h2 class="mt-3 content-title">Unit Sistem Informasi dan Teknologi</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="about-info-item mb-4 mb-lg-0">
                        <h3 class="mb-3">
                            <span class="text-color mr-2 text-md ">01.</span>
                            Visi
                        </h3>
                        <p>{{ $identitas->visi }}</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="about-info-item mb-4 mb-lg-0">
                        <h3 class="mb-3">
                            <span class="text-color mr-2 text-md">02.</span>
                            Misi
                        </h3>
                        <ol style="padding-left: 16px;">
                            @foreach ($identitas->misi as $misi)
                                <li style="padding-left: 8px;">
                                    <p class="mb-0">{{ $misi }}</p>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- section Counter Start -->
    <section class="section counter bg-counter">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="counter-item text-center mb-5 mb-lg-0">
                        <i class="ti-desktop color-one text-md"></i>
                        <h3 class="mt-2 mb-0 text-white">
                            <span class="counter-stat font-weight-bold">{{ $identitas->sistem }}</span>
                        </h3>
                        <p class="text-white-50">Jumlah Sistem</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="counter-item text-center mb-5 mb-lg-0">
                        <i class="ti-world color-one text-md"></i>
                        <h3 class="mt-2 mb-0 text-white">
                            <span class="counter-stat font-weight-bold">{{ $identitas->website }}</span>
                        </h3>
                        <p class="text-white-50">Jumlah Website</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="counter-item text-center mb-5 mb-lg-0">
                        <i class="ti-rss-alt color-one text-md"></i>
                        <h3 class="mt-2 mb-0 text-white">
                            <span class="counter-stat font-weight-bold">{{ $identitas->ap }}</span>
                        </h3>
                        <p class="text-white-50">Jumlah Akses Point</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section Counter End  -->

    <!--  Section Services Start -->
    <section class="section team">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <div class="section-title">
                        <span class="h6 text-color">Tim Kami</span>
                        <h2 class="mt-3 content-title">Unit Sistem Informasi dan Teknologi</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach ($users as $user)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="team-item-wrap mb-5">
                            <div class="team-item position-relative">
                                @if ($user->foto)
                                    <img src="{{ asset('storage/uploads/' . $user->foto) }}" alt="{{ $user->nama }}"
                                        class="img-fluid w-100">
                                @else
                                    <img src="{{ asset('storage/uploads/asset/user-placeholder.jpg') }}"
                                        alt="{{ $user->nama }}" class="img-fluid w-100">
                                @endif
                                <div class="team-img-hover">
                                    <ul class="team-social list-inline">
                                        <li class="list-inline-item">
                                            <a href="{{ url('hubungi/' . $user->telp) }}" class="instagram"
                                                style="background: #25D366" target="_blank">
                                                <i class="fab fa-whatsapp" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="team-item-content">
                                <h4 class="mt-3 mb-0 text-capitalize">{{ $user->nama }}</h4>
                                <p>
                                    @if ($user->bagian == 'programmer')
                                        Staf Programmer
                                    @elseif ($user->bagian == 'jaringan')
                                        Staf Jaringan Komputer dan Umum
                                    @elseif ($user->bagian == 'support')
                                        Staf IT Support
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--  Section Services End -->
@endsection
