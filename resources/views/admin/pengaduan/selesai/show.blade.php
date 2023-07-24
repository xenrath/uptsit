@extends('layouts.app')

@section('title', 'Lihat Pengaduan')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pengaduan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/user') }}">Pengaduan</a></li>
              <li class="breadcrumb-item active">Lihat</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Detail Pengaduan</h3>
            <div class="card-tools">
              <span class="badge badge-success p-2">{{ ucfirst($pengaduan->status) }}</span>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="row mb-3">
                  <div class="col-md-4">
                    <strong>Nama</strong>
                  </div>
                  <div class="col-md-8">
                    {{ $pengaduan->nama }}
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-4">
                    <strong>Unit / Bagian</strong>
                  </div>
                  <div class="col-md-8">
                    {{ $pengaduan->unit }}
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-4">
                    <strong>Nomor Telepon</strong>
                  </div>
                  <div class="col-md-8">
                    <a href="{{ url('admin/pengaduan-masuk/hubungi/' . $pengaduan->id) }}" class="btn btn-success btn-sm"
                      target="_blank">
                      Hubungi <i class="fab fa-whatsapp ml-1"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row mb-3">
                  <div class="col-md-4">
                    <strong>Tanggal Dibuat</strong>
                  </div>
                  <div class="col-md-8">
                    {{ date('d M Y', strtotime($pengaduan->created_at)) }}
                  </div>
                </div>
                <strong>Deskripsi</strong>
                <br>
                {{ $pengaduan->deskripsi }}
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Catatan Pengaduan</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            @forelse ($catatans as $key => $catatan)
              @if ($key > 0)
                <hr>
              @endif
              @if ($catatan->update)
                <p class="lead">{{ date('d M Y', strtotime($catatan->created_at)) }}</p>
                <p>
                  @if ($catatan->update == 'proses')
                    <strong>Pengaduan mulai dikerjakan.</strong>
                  @else
                    <strong>Pengaduan telah selesai dikerjaan.</strong>
                  @endif
                </p>
              @else
                <p class="lead">{{ date('d M Y', strtotime($catatan->created_at)) }}</p>
                <p>
                  <strong>Isi Catatan</strong>
                  <br>
                  {{ $catatan->isi }}
                </p>
                </p>
                @if ($catatan->gambar)
                  <p>
                    <strong>Gambar</strong>
                  </p>
                  <div class="row">
                    @foreach ($catatan->gambar as $gambar)
                      <div class="col-md-4 mb-3">
                        <img src="{{ asset('storage/uploads/' . $gambar) }}" class="w-100 border rounded">
                      </div>
                    @endforeach
                  </div>
                @endif
              @endif
            @empty
              <p class="p-4 text-center">- Belum ada catatan yang ditambahkan -</p>
            @endforelse
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
