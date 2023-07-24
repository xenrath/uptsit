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
            <h3 class="card-title">Data Web Hosting</h3>
            <div class="float-right">
              <a href="{{ url('tamu/hosting/create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-2"></i>Buat Permohonan
              </a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th class="text-center" style="width: 20px">No</th>
                  <th>Kategori</th>
                  <th>Nama Instansi</th>
                  <th>Sub Domain</th>
                  <th>Status</th>
                  <th style="width: 120px">Opsi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($hostings as $hosting)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ ucfirst($hosting->kategori) }}</td>
                    <td>{{ $hosting->nama_instansi }}</td>
                    <td>{{ $hosting->sub_domain }}</td>
                    <td>
                      @php
                        $status = $hosting->status;
                        if ($status == 'menunggu') {
                            $badge = 'badge-warning';
                        } elseif ($status == 'proses') {
                            $badge = 'badge-primary';
                        } else {
                            $badge = 'badge-success';
                        }
                      @endphp
                      <small class="badge {{ $badge }}">{{ $hosting->status }}</small>
                    </td>
                    <td>
                      <a href="{{ url('tamu/hosting/' . $hosting->id) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i>
                      </a>
                      <a href="{{ url('tamu/hosting/' . $hosting->id . '/edit') }}" class="btn btn-warning">
                        <i class="fas fa-pencil-alt"></i>
                      </a>
                      <button type="submit" class="btn btn-danger" data-toggle="modal"
                        data-target="#modal-hapus-{{ $hosting->id }}">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                  <div class="modal fade" id="modal-hapus-{{ $hosting->id }}">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Hapus Anggota</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>Yakin hapus hosting <strong>{{ $hosting->nama }}</strong>?</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                          <form action="{{ url('tamu/hosting/' . $hosting->id) }}" method="POST">
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
