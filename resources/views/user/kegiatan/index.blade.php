@extends('layouts.app')

@section('title', 'Aktivitas Harian')

@section('loader')
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('storage/uploads/asset/logo.png') }}" alt="Admin SIT" height="80"
            width="80" style="border-radius: 50%">
    </div>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kegiatan Harian</h1>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Kegiatan</h3>
                        <div class="float-right">
                            <a href="{{ url('user/kegiatan/create') }}" class="btn btn-primary btn-sm btn-flat">Tambah</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 10px">No</th>
                                    <th style="width: 100px">Tanggal</th>
                                    <th>Keterangan</th>
                                    <th class="text-center" style="width: 100px">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kegiatans as $key => $kegiatan)
                                    <tr>
                                        <td class="text-center">{{ $kegiatans->firstItem() + $key }}</td>
                                        <td>{{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('l, d F Y') }}
                                        </td>
                                        <td>{{ $kegiatan->deskripsi }}</td>
                                        <td class="text-center">
                                            <a href="{{ url('user/kegiatan/' . $kegiatan->id . '/edit') }}"
                                                class="btn btn-warning btn-sm btn-flat mb-2">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm btn-flat mb-2"
                                                data-toggle="modal" data-target="#modal-hapus-{{ $kegiatan->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-hapus-{{ $kegiatan->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Kegiatan</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin hapus kegiatan ini?</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default btn-sm btn-flat"
                                                        data-dismiss="modal">Batal</button>
                                                    <form action="{{ url('user/kegiatan/' . $kegiatan->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm btn-flat">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <span class="text-muted">- Data tidak ditemukan -</span>
                                        </td>
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
