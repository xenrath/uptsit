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
              Vision
            </h3>
            <p>{!! $visimisi->visi !!}</p>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="about-info-item mb-4 mb-lg-0">
            <h3 class="mb-3">
              <span class="text-color mr-2 text-md">02.</span>
              Mision
            </h3>
            <p>{!! $visimisi->misi !!}</p>
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
              <span class="counter-stat font-weight-bold">{{ $unit->sistem }}</span>
            </h3>
            <p class="text-white-50">Jumlah Sistem</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="counter-item text-center mb-5 mb-lg-0">
            <i class="ti-world color-one text-md"></i>
            <h3 class="mt-2 mb-0 text-white">
              <span class="counter-stat font-weight-bold">{{ $unit->website }}</span>
            </h3>
            <p class="text-white-50">Jumlah Website</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="counter-item text-center mb-5 mb-lg-0">
            <i class="ti-rss-alt color-one text-md"></i>
            <h3 class="mt-2 mb-0 text-white">
              <span class="counter-stat font-weight-bold">{{ $unit->ap }}</span>
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
        @foreach ($anggotas as $anggota)
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="team-item-wrap mb-5">
            <div class="team-item position-relative">
              <img src="{{ asset('megakit/source/images/team/team-2.jpg') }}" alt="" class="img-fluid w-100">
              <div class="team-img-hover">
                <ul class="team-social list-inline">
                  <li class="list-inline-item">
                    <a href="#" class="instagram">
                      <i class="fab fa-instagram" aria-hidden="true"></i>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="team-item-content">
              <h4 class="mt-3 mb-0 text-capitalize">{{ $anggota->nama }}</h4>
              {{-- <p>Digital Marketer</p> --}}
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  <!--  Section Services End -->
@endsection
