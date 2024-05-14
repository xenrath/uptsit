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
                        {{-- <div class="float-right">
              <form action="{{ url('admin/hosting') }}" method="get" id="form-status">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <select class="custom-select" id="kategori" name="kategori" onchange="setStatus()">
                      <option value="">- Semua Status -</option>
                      <option value="menunggu" {{ old('kategori') == 'baru' ? 'selected' : '' }}>Baru</option>
                      <option value="perubahan" {{ old('kategori') == 'perubahan' ? 'selected' : '' }}>Perubahan</option>
                      </option>
                    </select>
                  </div>
                </div>
              </form>
            </div> --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;" class="text-center">No</th>
                                        <th>Kategori</th>
                                        <th>Nama Instansi</th>
                                        <th>Sub Domain</th>
                                        <th>Status</th>
                                        <th class="text-center">Opsi</th>
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
                                                    if ($hosting->status == 'menunggu') {
                                                        $badge = 'badge-warning';
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
                                                @if ($hosting->status == 'menunggu')
                                                    <a href="{{ url('admin/hosting/' . $hosting->id) }}"
                                                        class="btn btn-primary" data-toggle="modal"
                                                        data-target="#modal-selesai-{{ $hosting->id }}">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="modal-selesai-{{ $hosting->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Selesaikan Permohonan</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Yakin selesaikan permohonan?</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Batal</button>
                                                        <a href="{{ url('admin/hosting/' . $hosting->id . '/selesai') }}"
                                                            class="btn btn-primary">
                                                            Selesaikan
                                                        </a>
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
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </section>
        <!-- /.card -->
    </div>
    {{-- <script>
    function setStatus() {
      document.getElementById('form-status').submit();
    }
  </script> --}}
@endsection
