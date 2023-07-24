@extends('layouts.app')

@section('title', 'Pengaduan')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pengaduan</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Pengaduan Masuk</li>
            </ol>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @if (session('success'))
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5>
              <i class="icon fas fa-check"></i> Success!
            </h5>
            {{ session('success') }}
          </div>
        @endif
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Pengaduan</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width: 60px;" class="text-center">No</th>
                  <th>Nama / Unit</th>
                  <th>Deskripsi</th>
                  <th>Status</th>
                  <th style="width: 180px;" class="text-center">Opsi</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($pengaduans as $pengaduan)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}.</td>
                    <td>{{ $pengaduan->nama }} <br> ({{ $pengaduan->unit }})</td>
                    <td>{{ $pengaduan->deskripsi }}</td>
                    <td>
                      <span class="badge badge-success p-2">{{ ucfirst($pengaduan->status) }}</span>
                    </td>
                    <td class="text-center">
                      <a href="{{ url('admin/pengaduan-selesai/' . $pengaduan->id) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i>
                      </a>
                    </td>
                  </tr>
                  <div class="modal fade" id="modal-konfirmasi-{{ $pengaduan->id }}">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Konfirmasi Pengaduan</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>Yakin konfirmasi pengaduan dari <strong>{{ $pengaduan->nama }}</strong>?</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                          <a href="{{ url('admin/pengaduan-masuk/selesaisi/' . $pengaduan->id) }}"
                            class="btn btn-primary">Konfirmasi</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal fade" id="modal-catatan-{{ $pengaduan->id }}">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Catatan Pengaduan</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                            <label for="isi">Isi Catatan *</label>
                            <textarea name="isi" id="isi" class="form-control" cols="30" rows="4" placeholder="Isi catatan"></textarea>
                          </div>
                          <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" name="gambar" id="customFile"
                                accept="image/*">
                              <label class="custom-file-label" for="customFile">Pilih</label>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </div>
                    </div>
                  </div>
                @empty
                  <tr>
                    <td class="text-center" colspan="5">- Data tidak ditemukan -</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </section>
    <!-- /.card -->
  </div>
@endsection
