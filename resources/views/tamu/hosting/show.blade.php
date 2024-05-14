@extends('layouts.app')

@section('title', 'Detail Web Hosting')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Detail Web Hosting</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Detail Web Hosting</li>
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
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Detail Permohonan</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>Kategori</strong>
                  </div>
                  <div class="col-lg-8">
                    {{ ucfirst($hosting->kategori) }}
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>Nama Instansi</strong>
                  </div>
                  <div class="col-lg-8">
                    {{ $hosting->nama_instansi }}
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>Deskripsi</strong>
                  </div>
                  <div class="col-lg-8">
                    {{ $hosting->deskripsi }}
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>Sub Domain</strong>
                  </div>
                  <div class="col-lg-8">
                    {{ $hosting->sub_domain }}
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>IP Address</strong>
                  </div>
                  <div class="col-lg-8">
                    {{ $hosting->ip_address }}
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>FTP / DB</strong>
                  </div>
                  <div class="col-lg-8">
                    {{ $hosting->ftp }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Kepala / Direktur Lembaga / Organisasi</h3>
          </div>
          <div class="card-body">
            <div class="row mb-2">
              <div class="col-lg-4">
                <strong>Nama</strong>
              </div>
              <div class="col-lg-8">
                {{ $hosting->nama_kepala }}
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-lg-4">
                <strong>NIPY</strong>
              </div>
              <div class="col-lg-8">
                {{ $hosting->nipy_kepala }}
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-lg-4">
                <strong>Jabatan</strong>
              </div>
              <div class="col-lg-8">
                {{ $hosting->jabatan_kepala }}
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Administrator / Desainer / Developer Website (1)</h3>
              </div>
              <div class="card-body">
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>Nama</strong>
                  </div>
                  <div class="col-lg-8">
                    {{ $hosting->nama_admin_1 }}
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>NIPY</strong>
                  </div>
                  <div class="col-lg-8">
                    {{ $hosting->nipy_admin_1 }}
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>Jabatan</strong>
                  </div>
                  <div class="col-lg-8">
                    {{ $hosting->jabatan_admin_1 }}
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>Email</strong>
                  </div>
                  <div class="col-lg-8">
                    {{ $hosting->email_admin_1 }}
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>No. Telepon</strong>
                  </div>
                  <div class="col-lg-8">
                    0{{ $hosting->telp_admin_1 }}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Administrator / Desainer / Developer Website (2)</h3>
              </div>
              <div class="card-body">
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>Nama</strong>
                  </div>
                  <div class="col-lg-8">
                    {{ $hosting->nama_admin_2 }}
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>NIPY</strong>
                  </div>
                  <div class="col-lg-8">
                    {{ $hosting->nipy_admin_2 }}
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>Jabatan</strong>
                  </div>
                  <div class="col-lg-8">
                    {{ $hosting->jabatan_admin_2 }}
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>Email</strong>
                  </div>
                  <div class="col-lg-8">
                    {{ $hosting->email_admin_2 }}
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>No. Telepon</strong>
                  </div>
                  <div class="col-lg-8">
                    0{{ $hosting->telp_admin_2 }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-footer">
            <a href="{{ url('tamu/hosting/download/' . $hosting->id) }}" class="btn btn-primary btn-block"
              target="_blank">
              Unduh Dokumen
            </a>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
