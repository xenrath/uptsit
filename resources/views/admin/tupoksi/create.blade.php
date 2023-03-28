@extends('layouts.admin')

@section('title', 'Tupoksi Unit')

@section('content')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tupoksi Unit</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="{{ url('admin/tupoksi') }}">Tupoksi Unit</a>
            </li>
            <li class="breadcrumb-item active">Tambah</li>
          </ol>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <section class="content">
    <div class="container-fluid">
      @if (session('error'))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5>
            <i class="icon fas fa-ban"></i> Error!
          </h5>
          @foreach (session('error') as $error)
            - {{ $error }} <br>
          @endforeach
        </div>
      @endif
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Tambah User</h3>
        </div>
        <!-- /.card-header -->
        <form action="{{ url('admin/tupoksi') }}" method="post" enctype="multipart/form-data" autocomplete="off">
          @csrf
          @method('PUT')
          <div class="card-body">
            <div class="form-group">
              <label for="nama">Nama Tupoksi</label>
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan nama tupoksi"
                value="{{ old('nama') }}">
            </div>
            <div class="form-group">
              <label for="deskripsi">Deskripsi</label>
              <textarea id="summernote" name="deskripsi">
                {{ old('deskripsi') }}
              </textarea>
            </div>
            <div class="form-group">
              <label for="icon">
                Ikon
                <small>(cari di <a href="https://themify.me/themify-icons" target="_blank">Themify Icons</a>)</small>
              </label>
              <input type="text" class="form-control" id="icon" name="icon" placeholder="contoh: ti-user"
                value="{{ old('icon') }}">
            </div>
            <div class="form-group">
              <label for="file">File</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="file" name="file">
                <label class="custom-file-label" for="file">Pilih File</label>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </section>
  <script>
    var role = document.getElementById('role');
    var layout_layanan = document.getElementById('layout_layanan');
    var layanan_id = document.getElementById('layanan_id');
    if (role.value == 'teknisi') {
      layout_layanan.style.display = "inline";
    } else {
      layout_layanan.style.display = "none";
      layanan_id.value = "";
    }
    role.addEventListener('change', function() {
      if (role.value == 'teknisi') {
        layout_layanan.style.display = "inline";
      } else {
        layout_layanan.style.display = "none";
        layanan_id.value = "";
      }
    });
  </script>
@endsection
