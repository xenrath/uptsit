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
                      <span
                        class="badge {{ $pengaduan->status == 'menunggu' ? 'badge-warning' : 'badge-primary' }} p-2">{{ ucfirst($pengaduan->status) }}</span>
                    </td>
                    <td class="text-center">
                      <a href="{{ url('admin/pengaduan-masuk/' . $pengaduan->id) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i>
                      </a>
                    </td>
                  </tr>
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
