@extends('layouts.app')

@section('title', 'Web Hosting')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Web Hosting</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Web Hosting</li>
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
        <form action="{{ url('tamu/hosting') }}" method="post">
          @csrf
          @if (session('error_permohonan'))
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5>
                <i class="icon fas fa-ban"></i> Error!
              </h5>
              @foreach (session('error_permohonan') as $error)
                - {{ $error }} <br>
              @endforeach
            </div>
          @endif
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Permohonan Sub Domain</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="form-group">
                <label for="kategori">Kategori</label>
                <select class="custom-select" id="kategori" name="kategori">
                  <option value="">- Pilih -</option>
                  <option value="baru" {{ old('kategori') == 'baru' ? 'selected' : '' }}>Baru</option>
                  <option value="perubahan" {{ old('kategori') == 'perubahan' ? 'selected' : '' }}>Perubahan</option>
                  <option value="penambahan" {{ old('kategori') == 'penambahan' ? 'selected' : '' }}>Penambahan</option>
                </select>
              </div>
              <div class="form-group">
                <label for="nama_instansi">Nama Instansi</label>
                <input type="text" class="form-control" id="nama_instansi" name="nama_instansi"
                  placeholder="Masukan Nama Instansi" value="{{ old('nama_instansi') }}">
              </div>
            </div>
          </div>
          @if (session('error_kepala'))
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5>
                <i class="icon fas fa-ban"></i> Error!
              </h5>
              @foreach (session('error_kepala') as $error)
                - {{ $error }} <br>
              @endforeach
            </div>
          @endif
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Kepala / Direktur Lembaga / Organisasi</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="nama_kepala">Nama</label>
                <input type="text" class="form-control" id="nama_kepala" name="nama_kepala" placeholder="Masukan Nama"
                  value="{{ old('nama_kepala') }}">
              </div>
              <div class="form-group">
                <label for="nipy_kepala">NIPY</label>
                <input type="text" class="form-control" id="nipy_kepala" name="nipy_kepala" placeholder="Masukan NIPY"
                  value="{{ old('nipy_kepala') }}">
              </div>
              <div class="form-group">
                <label for="jabatan_kepala">Jabatan</label>
                <input type="text" class="form-control" id="jabatan_kepala" name="jabatan_kepala"
                  placeholder="Masukan Jabatan" value="{{ old('jabatan_kepala') }}">
              </div>
            </div>
          </div>
          @if (session('error_admin_1'))
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5>
                <i class="icon fas fa-ban"></i> Error!
              </h5>
              @foreach (session('error_admin_1') as $error)
                - {{ $error }} <br>
              @endforeach
            </div>
          @endif
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Administrator / Desainer / Developer Website (1)</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="nama_admin">Nama</label>
                <input type="text" class="form-control" id="nama_admin_1" name="nama_admin_1"
                  placeholder="Masukan Nama" value="{{ old('nama_admin_1') }}">
              </div>
              <div class="form-group">
                <label for="nipy_admin">NIPY</label>
                <input type="text" class="form-control" id="nipy_admin_1" name="nipy_admin_1"
                  placeholder="Masukan NIPY" value="{{ old('nipy_admin_1') }}">
              </div>
              <div class="form-group">
                <label for="jabatan_admin">Jabatan</label>
                <input type="text" class="form-control" id="jabatan_admin_1" name="jabatan_admin_1"
                  placeholder="Masukan Jabatan" value="{{ old('jabatan_admin_1') }}">
              </div>
              <div class="form-group">
                <label for="email_admin">Email</label>
                <input type="text" class="form-control" id="email_admin_1" name="email_admin_1"
                  placeholder="Masukan Email" value="{{ old('email_admin_1') }}">
              </div>
              <div class="form-group">
                <label for="telp_admin">No. Telepon</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">+62</span>
                  </div>
                  <input type="text" id="telp_admin_1" name="telp_admin_1" class="form-control"
                    placeholder="Masukan Nomor Telepon" value="{{ old('telp_admin_1') }}">
                </div>
              </div>
            </div>
          </div>
          @if (session('error_admin_2'))
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5>
                <i class="icon fas fa-ban"></i> Error!
              </h5>
              @foreach (session('error_admin_2') as $error)
                - {{ $error }} <br>
              @endforeach
            </div>
          @endif
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Administrator / Desainer / Developer Website (2)</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="nama_admin">Nama</label>
                <input type="text" class="form-control" id="nama_admin_2" name="nama_admin_2"
                  placeholder="Masukan Nama" value="{{ old('nama_admin_2') }}">
              </div>
              <div class="form-group">
                <label for="nipy_admin">NIPY</label>
                <input type="text" class="form-control" id="nipy_admin_2" name="nipy_admin_2"
                  placeholder="Masukan NIPY" value="{{ old('nipy_admin_2') }}">
              </div>
              <div class="form-group">
                <label for="jabatan_admin">Jabatan</label>
                <input type="text" class="form-control" id="jabatan_admin_2" name="jabatan_admin_2"
                  placeholder="Masukan Jabatan" value="{{ old('jabatan_admin_2') }}">
              </div>
              <div class="form-group">
                <label for="email_admin">Email</label>
                <input type="text" class="form-control" id="email_admin_2" name="email_admin_2"
                  placeholder="Masukan Email" value="{{ old('email_admin_2') }}">
              </div>
              <div class="form-group">
                <label for="telp_admin">No. Telepon</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">+62</span>
                  </div>
                  <input type="text" id="telp_admin_2" name="telp_admin_2" class="form-control"
                    placeholder="Masukan Nomor Telepon" value="{{ old('telp_admin_2') }}">
                </div>
              </div>
            </div>
          </div>
          @if (session('error_detail'))
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5>
                <i class="icon fas fa-ban"></i> Error!
              </h5>
              @foreach (session('error_detail') as $error)
                - {{ $error }} <br>
              @endforeach
            </div>
          @endif
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Detail Website</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukan Deskripsi">{{ old('deskripsi') }}</textarea>
              </div>
              <div class="form-group">
                <label for="sub_domain">
                  Sub Domain
                  <small>(Nama Sub Domain harus URL friendly / mudah dibaca)</small>
                </label>
                <input type="text" class="form-control" id="sub_domain" name="sub_domain"
                  placeholder="Masukan Sub Domain" value="{{ old('sub_domain') }}">
              </div>
              <div class="form-group">
                <label for="ip_address">
                  IP Address
                  <small>(Jika menggunakan server selain server lain)</small>
                </label>
                <input type="text" class="form-control" id="ip_address" name="ip_address"
                  placeholder="Masukan IP Address" value="{{ old('ip_address') }}">
              </div>
              <div class="form-group">
                <label for="ftp">
                  FTP / DB
                  <small>(Jika ingin mengelola aplikasi secara mandiri)</small>
                </label>
                <input type="text" class="form-control" id="ftp" name="ftp" placeholder="Masukan FTP"
                  value="{{ old('ftp') }}">
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-footer">
              <button type="submit" class="btn btn-primary btn-block">Buat Permohonan</button>
            </div>
          </div>
        </form>
      </div>
    </section>
  </div>
@endsection
