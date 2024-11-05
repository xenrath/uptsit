@extends('layouts.app')

@section('title', 'Data Perangkat')

@section('loader')
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('storage/uploads/unit/logo.png') }}" alt="Admin SIT" height="80"
            width="80" style="border-radius: 50%">
    </div>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Data Perangkat</h1>
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
                        <h3 class="card-title">Data Perangkat</h3>
                        <div class="float-right">
                            <a href="{{ url('admin/perangkat/scan') }}" class="btn btn-outline-info btn-sm btn-flat">
                                Scan
                            </a>
                            <a href="{{ url('admin/perangkat/create') }}" class="btn btn-primary btn-sm btn-flat">
                                Tambah
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 20px">No</th>
                                    <th>Karyawan / Unit</th>
                                    <th class="text-center" style="width: 140px">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($perangkats as $perangkat)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($perangkat->karyawan_id)
                                                {{ $perangkat->karyawan->nama }}
                                                <br>
                                            @endif
                                            {{ $perangkat->unit->nama }}
                                        </td>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('admin/perangkat/' . $perangkat->id) }}"
                                                class="btn btn-info btn-sm btn-flat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ url('admin/perangkat/' . $perangkat->id . '/edit') }}"
                                                class="btn btn-warning btn-sm btn-flat">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm btn-flat"
                                                data-toggle="modal" data-target="#modal-hapus-{{ $perangkat->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-lihat-{{ $perangkat->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Detail Perangkat</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    @if ($perangkat->karyawan_id)
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <strong>Karyawan</strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $perangkat->karyawan->nama }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <strong>Unit</strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ $perangkat->unit->nama }}
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <strong>Barang</strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ $perangkat->jenis == 'pc' ? 'PC' : 'Laptop' }} |
                                                            {{ $perangkat->merek }} |
                                                            {{ $perangkat->model }}
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <strong>No Seri</strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ $perangkat->no_seri }}
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <strong>RAM</strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ $perangkat->ram_tipe }} |
                                                            {{ $perangkat->ram_merek }} |
                                                            {{ $perangkat->ram_kapasitas }}GB
                                                        </div>
                                                    </div>
                                                    @if ($perangkat->is_ram_tambahan)
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <strong>RAM Tambahan</strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $perangkat->ram_tipe }} |
                                                                {{ $perangkat->ram_tambahan_merek }} |
                                                                {{ $perangkat->ram_tambahan_kapasitas }}GB
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <strong>Storage</strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ $perangkat->storage_tipe }} |
                                                            {{ $perangkat->storage_merek }} |
                                                            {{ $perangkat->storage_kapasitas }}GB
                                                        </div>
                                                    </div>
                                                    @if ($perangkat->is_storage_tambahan)
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <strong>Storage Tambahan</strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $perangkat->storage_tambahan_tipe }} |
                                                                {{ $perangkat->storage_tambahan_merek }} |
                                                                {{ $perangkat->storage_tambahan_kapasitas }}GB
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <strong>PSU</strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ $perangkat->psu_merek }} |
                                                            {{ $perangkat->psu_kapasitas }} Watt
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <strong>Heatsink</strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ $perangkat->heatsink_model }} |
                                                            {{ $perangkat->heatsink_merek }}
                                                        </div>
                                                    </div>
                                                    @if ($perangkat->jenis == 'pc')
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <strong>Monitor</strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $perangkat->monitor_merek }} |
                                                                {{ $perangkat->monitor_ukuran }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <strong>Keyboard</strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $perangkat->keyboard_merek }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <strong>Mouse</strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $perangkat->mouse_merek }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <strong>Keterangan</strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ $perangkat->keterangan ?? '-' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default btn-sm btn-flat"
                                                        data-dismiss="modal">Batal</button>
                                                    <form action="{{ url('admin/perangkat/print/' . $perangkat->id) }}"
                                                        method="post">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-primary btn-sm btn-flat">Print</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="modal-hapus-{{ $perangkat->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Perangkat</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin hapus perangkat dari
                                                        <strong>{{ $perangkat->karyawan->nama ?? '' }}
                                                            {{ $perangkat->unit->nama ?? '' }}</strong>?
                                                    </p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default btn-sm btn-flat"
                                                        data-dismiss="modal">Batal</button>
                                                    <form action="{{ url('admin/perangkat/' . $perangkat->id) }}"
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
                                        <td colspan="3" class="text-center">- Data tidak ditemukan -</td>
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
