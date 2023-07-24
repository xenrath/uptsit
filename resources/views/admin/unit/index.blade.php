@extends('layouts.app')

@section('title', 'Identitas Unit')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Identitas Unit</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="{{ url('admin/unit') }}">Identitas Unit</a>
              </li>
              <li class="breadcrumb-item active">Ubah</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
        @if (session('success'))
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5>
              <i class="icon fas fa-check"></i> Success
            </h5>
            {{ session('success') }}
          </div>
        @endif
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
            <h3 class="card-title">Identitas Unit</h3>
          </div>
          <!-- /.card-header -->
          <form action="{{ url('admin/unit/update') }}" method="post" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="nama">Nama Unit</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan nama unit"
                  value="{{ old('nama', $unit->nama) }}">
              </div>
              <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="summernote" name="deskripsi">
                {{ old('deskripsi', $unit->deskripsi) }}
              </textarea>
              </div>
              <div class="form-group">
                <label for="sistem">Jumlah Sistem</label>
                <input type="number" class="form-control" id="sistem" name="sistem"
                  placeholder="Masukan jumlah sistem" value="{{ old('sistem', $unit->sistem) }}">
              </div>
              <div class="form-group">
                <label for="website">Jumlah Website</label>
                <input type="number" class="form-control" id="website" name="website"
                  placeholder="Masukan jumlah website" value="{{ old('website', $unit->website) }}">
              </div>
              <div class="form-group">
                <label for="ap">Jumlah Akses Point</label>
                <input type="number" class="form-control" id="ap" name="ap"
                  placeholder="Masukan jumlah akses point" value="{{ old('ap', $unit->ap) }}">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukan email unit"
                  value="{{ old('email', $unit->email) }}">
              </div>
              <div class="form-group">
                <label for="telp">Telepon Unit</label>
                <input type="text" class="form-control" id="telp" name="telp"
                  placeholder="Masukan nomor telepon unit" value="{{ old('telp', $unit->telp) }}">
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
  </div>
@endsection
