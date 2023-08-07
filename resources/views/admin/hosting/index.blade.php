@extends('layouts.app')

@section('title', 'Permohonan Hosting')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Permohonan Hosting</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Permohonan Hosting</li>
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
            <h3 class="card-title">Data Permohonan Hosting</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width: 60px;" class="text-center">No</th>
                  <th>Kategori</th>
                  <th>Nama Instansi</th>
                  <th>Sub Domain</th>
                  <th>Status</th>
                  <th style="width: 180px;" class="text-center">Opsi</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($hostings as $hosting)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}.</td>
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
                    <td class="text-center">
                      <a href="{{ url('admin/hosting/' . $hosting->id) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i>
                      </a>
                      <a href="{{ url('admin/hosting/' . $hosting->id) }}" class="btn btn-primary">
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
