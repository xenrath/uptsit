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
              <li class="breadcrumb-item active">Pengaduan Menunggu</li>
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
                  <th>Nama</th>
                  <th>Unit</th>
                  <th>Deskripsi</th>
                  <th style="width: 120px;" class="text-center">Opsi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($pengaduans as $pengaduan)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}.</td>
                    <td>{{ $pengaduan->nama }}</td>
                    <td>{{ $pengaduan->unit }}</td>
                    <td>{{ $pengaduan->deskripsi }}</td>
                    <td class="text-center">
                      <a href="{{ url('admin/anggota/' . $pengaduan->id . '/edit') }}" class="btn btn-primary">
                        Konfirmasi
                      </a>
                    </td>
                  </tr>
                  <div class="modal fade" id="modal-hapus-{{ $pengaduan->id }}">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Hapus Pengaduan</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>Yakin hapus anggota <strong>{{ $pengaduan->nama }}</strong>?</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                          <form action="{{ url('admin/anggota/' . $pengaduan->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
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
