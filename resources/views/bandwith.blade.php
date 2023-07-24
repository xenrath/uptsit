@extends('layouts.web')

@section('content')
  <section class="page-title bg-1">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block text-center">
            <span class="text-white">Bandwith</span>
            <h1 class="text-capitalize mb-4 text-lg">Unit SIT</h1>
            <ul class="list-inline">
              <li class="list-inline-item">
                <a href="{{ url('/') }}" class="text-white">Home</a>
              </li>
              <li class="list-inline-item">
                <span class="text-white">/</span>
              </li>
              <li class="list-inline-item">
                <a href="#" class="text-white-50">Bandwith</a>
              </li>
            </ul>
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
            <h2 class="mt-3 content-title">{{ $unit->nama }}</h2>
          </div>
        </div>
      </div>
      <p class="mb-5">{!! $unit->deskripsi !!}</p>
    </div>
  </section>
  <!-- Section Intro END -->
  
  <section class="cta-2">
    <div class="container">
      <table class="table table-bordered">
        <thead>
          <tr>
            <td style="width: 60px; text-align: center; font-weight: 600;">No.</td>
            <td style="font-weight: 600;">Tupoksi</td>
            <td style="width: 120px; text-align: center; font-weight: 600;">Opsi</td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="text-align: center; vertical-align: middle">1.</td>
            <td style="vertical-align: middle">Nama</td>
            <td>
              <a href="" class="btn btn-info" target="_blank">Download</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
@endsection
