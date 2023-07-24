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
              <span
                class="badge {{ $pengaduan->status == 'menunggu' ? 'badge-warning' : 'badge-primary' }} p-2">{{ ucfirst($pengaduan->status) }}</span>
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
          <div class="card-footer text-right">
            @if ($pengaduan->status == 'menunggu')
              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-proses">
                Proses Pengaduan
              </button>
            @else
              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-selesai">
                Selesaikan Pengaduan
              </button>
            @endif
          </div>
        </div>
        @if (session('success'))
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Success!</h5>
            {{ session('success') }}
          </div>
        @endif
        @if (session('error'))
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Error!</h5>
            <ul class="px-4">
              @foreach (session('error') as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Catatan Pengaduan</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-catatan">
                <i class="fas fa-plus"></i> Tambah
              </button>
            </div>
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
    <div class="modal fade" id="modal-proses">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Proses Pengaduan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Yakin proses pengaduan dari <strong>{{ $pengaduan->nama }}</strong>?</p>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <a href="{{ url('admin/pengaduan-masuk/konfirmasi_proses/' . $pengaduan->id) }}"
              class="btn btn-primary">Proses</a>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-selesai">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Selesaikan Pengaduan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Yakin selesaikan pengaduan dari <strong>{{ $pengaduan->nama }}</strong>?</p>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <a href="{{ url('admin/pengaduan-masuk/konfirmasi_selesai/' . $pengaduan->id) }}"
              class="btn btn-primary">Selesaikan</a>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-catatan">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Catatan Pengaduan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{ url('admin/pengaduan-masuk/catatan/' . $pengaduan->id) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              <div class="form-group">
                <label for="isi">Isi Catatan *</label>
                <textarea name="isi" id="isi" class="form-control" cols="30" rows="4"
                  placeholder="Isi catatan"></textarea>
              </div>
              <div class="form-group">
                <label for="gambar">Gambar</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="gambar[]" id="gambar" accept="image/*"
                    multiple>
                  <label class="custom-file-label" for="customFile">Pilih</label>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
