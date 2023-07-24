@extends('layouts.app')

@section('title', 'Anggota Unit')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Anggota Unit</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="{{ url('admin/anggota') }}">Anggota Unit</a>
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
          <form action="{{ url('admin/anggota') }}" method="post" enctype="multipart/form-data" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="card-body">
              <div class="form-group">
                <label for="nama">Nama Anggota</label>
                <input type="text" class="form-control" id="nama" name="nama"
                  placeholder="Masukan nama anggota" value="{{ old('nama') }}">
              </div>
              <div class="form-group">
                <label for="telp">No. Telepon</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">+62</span>
                  </div>
                  <input type="text" id="telp" name="telp" class="form-control"
                    placeholder="Masukan nomor telepon" value="{{ old('telp') }}">
                </div>
              </div>
              <div class="form-group">
                <label for="foto">Foto
                  <small>(opsional)</small>
                </label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="foto" name="foto" accept="image/*">
                  <label class="custom-file-label" for="foto">Pilih Foto</label>
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
  </div>
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
