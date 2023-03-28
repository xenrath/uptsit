@extends('layouts.web')

@section('content')
  <section class="page-title bg-1">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block text-center">
            <span class="text-white">Kontak</span>
            <h1 class="text-capitalize mb-4 text-lg">Unit SIT</h1>
            <ul class="list-inline">
              <li class="list-inline-item">
                <a href="{{ url('/') }}" class="text-white">Home</a>
              </li>
              <li class="list-inline-item">
                <span class="text-white">/</span>
              </li>
              <li class="list-inline-item">
                <a href="#" class="text-white-50">Kontak</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- contact form start -->
  <section class="contact-form-wrap section">
    <div class="container">
      <span class="text-color">Buat Pengaduan</span>
      <h3 class="text-md mb-4">Unit Sistem Informasi dan Teknologi</h3>
      @if (session('success'))
        <div class="row">
          <div class="col-12">
            <div class="alert alert-success" role="alert">
              Success
              <p style="font-size: 14px">{{ session('success') }}</p>
            </div>
          </div>
        </div>
      @endif
      @if (session('error'))
        <div class="row">
          <div class="col-12">
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              Error!
              <p style="font-size: 14px">
                @foreach (session('error') as $error)
                  - {{ $error }} <br>
                @endforeach
              </p>
            </div>
          </div>
        </div>
      @endif
      <form id="contact-form" method="POST" action="{{ url('pengaduan/create') }}" autocomplete="off">
        @csrf
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <input name="nama" type="text" class="form-control" placeholder="Nama Pengadu">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input name="unit" type="text" class="form-control" placeholder="Unit / Bagian">
            </div>
          </div>
        </div>
        <div class="form-group-2 mb-4">
          <textarea name="deskripsi" class="form-control" rows="4" placeholder="Deskripsi Aduan" style="font-size: 14px"></textarea>
        </div>
        <button class="btn btn-main float-right" name="submit" type="submit">Kirim Aduan</button>
      </form>
    </div>
  </section>
@endsection
