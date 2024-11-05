@extends('layouts.app')

@section('title', 'Perbaikan Perbaikan')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a href="{{ url('admin/perbaikan') }}" class="btn btn-secondary btn-flat float-left mr-2">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1>Perbaikan Perangkat</h1>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action="{{ url('admin/perbaikan') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title mb-2">Detail Perbaikan</h3>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-primary btn-sm btn-flat" data-toggle="modal"
                                            data-target="#modal-perangkat">Pilih
                                            Perangkat</button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div id="layout-kosong" class="border text-center p-5">
                                        <span class="text-muted">- perangkat belum dipilih -</span>
                                    </div>
                                    <div id="layout-perangkat" style="display: none;">
                                        <div class="row mb-2">
                                            <div class="col-md-4" id="layout-perangkat-karyawan">
                                                <strong>Karyawan</strong>
                                                <br>
                                                <span id="perangkat-karyawan">Karyawan</span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Unit / Bagian</strong>
                                                <br>
                                                <span id="perangkat-unit">Unit / Bagian</span>
                                            </div>
                                        </div>
                                        <hr class="mb-2">
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <strong>Jenis Barang</strong>
                                                <br>
                                                <span id="perangkat-jenis">Jenis Barang</span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Merek</strong>
                                                <br>
                                                <span id="perangkat-merek">-</span>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-secondary btn-xs btn-flat" data-toggle="modal"
                                            data-target="#modal-motherboard">Ganti
                                            Motherboard</button>
                                        <hr class="mb-2">
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <strong>Model</strong>
                                                <br>
                                                <span id="perangkat-model">-</span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>No Seri</strong>
                                                <br>
                                                <span id="perangkat-no_seri">-</span>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-secondary btn-xs btn-flat" data-toggle="modal"
                                            data-target="#modal-prosesor">Ganti
                                            Prosesor</button>
                                        <hr class="mb-2">
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <strong>Tipe RAM</strong>
                                                <br>
                                                <span id="perangkat-ram_tipe">-</span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Kapasitas RAM</strong>
                                                <br>
                                                <span id="perangkat-ram_kapasitas">-</span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Merek RAM</strong>
                                                <br>
                                                <span id="perangkat-ram_merek">-</span>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-secondary btn-xs btn-flat" data-toggle="modal"
                                            data-target="#modal-ram">Ganti RAM</button>
                                        <hr class="mb-2">
                                        <div class="form-group mb-2">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="perangkat-is_ram_tambahan" name="is_ram_tambahan"
                                                    onchange="ram_tambahan()">
                                                <label class="custom-control-label" for="perangkat-is_ram_tambahan">
                                                    RAM Tambahan
                                                    <small class="text-muted" id="ram_tambahan-label-ada">(uncheck jika
                                                        tidak
                                                        diperlukan)</small>
                                                    <small class="text-muted" id="ram_tambahan-label-kosong"
                                                        style="display: none;">(checklist
                                                        untuk menambahkan)</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div id="layout-perangkat-is_ram_tambahan">
                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                    <strong>Tipe RAM</strong>
                                                    <br>
                                                    <span id="perangkat-ram_tambahan_tipe">-</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong>Kapasitas RAM</strong>
                                                    <br>
                                                    <span id="perangkat-ram_tambahan_kapasitas">-</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong>Merek RAM</strong>
                                                    <br>
                                                    <span id="perangkat-ram_tambahan_merek">-</span>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-secondary btn-xs btn-flat"
                                                data-toggle="modal" data-target="#modal-ram_tambahan">Ganti
                                                RAM</button>
                                        </div>
                                        <div id="layout-perangkat-is_ram_tambahan-kosong" style="display: none;">
                                            <div class="border text-center p-2 mb-1">
                                                <small class="text-muted">- RAM belum ditambahkan -</small>
                                            </div>
                                            <button type="button" id="ram_tambahan-kosong-button"
                                                class="btn btn-secondary btn-xs btn-flat" style="display: none;"
                                                data-toggle="modal" data-target="#modal-ram_tambahan">Tambah
                                                RAM</button>
                                        </div>
                                        <hr class="mb-2">
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <strong>Tipe Storage</strong>
                                                <br>
                                                <span id="perangkat-storage_tipe">-</span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Kapasitas Storage</strong>
                                                <br>
                                                <span id="perangkat-storage_kapasitas">-</span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Merek Storage</strong>
                                                <br>
                                                <span id="perangkat-storage_merek">-</span>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-secondary btn-xs btn-flat"
                                            data-toggle="modal" data-target="#modal-storage">Ganti
                                            Storage</button>
                                        <hr class="mb-2">
                                        <div class="form-group mb-2">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="perangkat-is_storage_tambahan" name="is_storage_tambahan"
                                                    onchange="storage_tambahan()">
                                                <label class="custom-control-label" for="perangkat-is_storage_tambahan">
                                                    Storage Tambahan
                                                    <small class="text-muted" id="storage_tambahan-label-ada">(uncheck
                                                        jika tidak diperlukan)</small>
                                                    <small class="text-muted" id="storage_tambahan-label-kosong"
                                                        style="display: none;">(checklist
                                                        untuk menambahkan)</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div id="layout-perangkat-is_storage_tambahan">
                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                    <strong>Tipe Storage</strong>
                                                    <br>
                                                    <span id="perangkat-storage_tambahan_tipe">-</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong>Kapasitas Storage</strong>
                                                    <br>
                                                    <span id="perangkat-storage_tambahan_kapasitas">-</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong>Merek Storage</strong>
                                                    <br>
                                                    <span id="perangkat-storage_tambahan_merek">-</span>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-secondary btn-xs btn-flat"
                                                data-toggle="modal" data-target="#modal-storage_tambahan">Ganti
                                                Storage</button>
                                        </div>
                                        <div id="layout-perangkat-is_storage_tambahan-kosong" style="display: none;">
                                            <div class="border text-center p-2 mb-1">
                                                <small class="text-muted">- Storage belum ditambahkan -</small>
                                            </div>
                                            <button type="button" id="storage_tambahan-kosong-button"
                                                class="btn btn-secondary btn-xs btn-flat" style="display: none;"
                                                data-toggle="modal" data-target="#modal-storage_tambahan">Tambah
                                                Storage</button>
                                        </div>
                                        <hr class="mb-2">
                                        <div id="layout-perangkat-pc">
                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                    <strong>Kapasitas PSU</strong>
                                                    <br>
                                                    <span id="perangkat-psu_kapasitas">-</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong>Merek PSU</strong>
                                                    <br>
                                                    <span id="perangkat-psu_merek">Merek PSU</span>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-secondary btn-xs btn-flat">Ganti
                                                PSU</button>
                                            <hr class="mb-2">
                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                    <strong>Model Heatsink</strong>
                                                    <br>
                                                    <span id="perangkat-heatsink_model">Model Heatsink</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong>Merek Heatsink</strong>
                                                    <br>
                                                    <span id="perangkat-heatsink_merek">Merek Heatsink</span>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-secondary btn-xs btn-flat">Ganti
                                                Heatsink</button>
                                            <hr class="mb-2">
                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                    <strong>Merek Monitor</strong>
                                                    <br>
                                                    <span id="perangkat-monitor_merek">Merek Monitor</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong>Ukuran Monitor</strong>
                                                    <br>
                                                    <span id="perangkat-monitor_ukuran">Ukuran Monitor</span>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-secondary btn-xs btn-flat">Ganti
                                                Monitor</button>
                                            <hr class="mb-2">
                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                    <strong>Merek Keyboard</strong>
                                                    <br>
                                                    <span id="perangkat-keyboard_merek">Merek Keyboard</span>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-secondary btn-xs btn-flat">Ganti
                                                Keyboard</button>
                                            <hr class="mb-2">
                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                    <strong>Merek Mouse</strong>
                                                    <br>
                                                    <span id="perangkat-mouse_merek">Merek Mouse</span>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-secondary btn-xs btn-flat">Ganti
                                                Mouse</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title mb-2">Detail Perbaikan</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-2">
                                        <label for="keterangan">Tindakan</label>
                                        <textarea class="form-control rounded-0" name="keterangan" id="keterangan" cols="30" rows="4">{{ old('keterangan') }}</textarea>
                                        @error('storage_tambahan_tipe')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="foto_sebelum">Foto Kondisi Sebelum</label>
                                        <input type="file" class="form-control rounded-0" id="foto_sebelum"
                                            name="foto_sebelum">
                                        @error('foto_sebelum')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="foto_sesudah">Foto Kondisi Sesudah</label>
                                        <input type="file" class="form-control rounded-0" id="foto_sesudah"
                                            name="foto_sesudah">
                                        @error('foto_sesudah')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="paraf">Paraf</label>
                                        <div class="row">
                                            <div class="col-12">
                                                <canvas id="signaturePad" class="mb-2" height="300"
                                                    style="border-style: dashed"></canvas>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control rounded-0" id="ttd"
                                            name="ttd">
                                        <button type="button" class="btn btn-danger btn-sm btn-flat float-start"
                                            onclick="resetPad()">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                        @error('paraf')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right pb-4">
                        <button type="submit" class="btn btn-primary btn-sm btn-flat">Buat Perbaikan</button>
                    </div>
                </form>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <div class="modal fade" id="modal-perangkat">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Perangkat</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-header">
                    <div class="input-group">
                        <input type="search" class="form-control rounded-0" id="keyword" name="keyword"
                            placeholder="cari perangkat dari karyawan / unit">
                        <div class="input-group-append rounded-0">
                            <button type="button" class="btn btn-default btn-flat" onclick="search_perangkat()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <table id="table-perangkat" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 20px">No</th>
                                <th>Karyawan / Unit</th>
                                <th class="text-center" style="width: 40px">Pilih</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-perangkat">
                            @foreach ($perangkats as $key => $perangkat)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($perangkat->karyawan_id)
                                            {{ $perangkat->karyawan->nama }}
                                            <br>
                                        @endif
                                        {{ $perangkat->unit->nama }}
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-flat"
                                            data-dismiss="modal" onclick="set_perangkat({{ $perangkat->id }})">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div id="modal-batas" class="text-center">
                        <small class="text-muted">Cari dengan <strong>kata kunci</strong> lebih detail</small>
                    </div>
                    <div id="modal-loading" class="text-center p-4" style="display: none">
                        <span>Loading...</span>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal"
                        onclick="uncheck_karyawan()">Hapus Terpilih</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-motherboard">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Motherboard</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 20px">No</th>
                                <th>Spesifikasi</th>
                                <th class="text-center" style="width: 40px">Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($motherboards as $key => $motherboard)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        Motherboard
                                        <span class="text-muted">({{ $motherboard->merek }})</span>
                                        <br>
                                        {{ $motherboard->model }} | {{ $motherboard->tipe }}
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-flat"
                                            data-dismiss="modal" onclick="set_motherboard({{ $motherboard->id }})">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal"
                        onclick="uncheck_karyawan()">Hapus Terpilih</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-prosesor">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Prosesor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 20px">No</th>
                                <th>Spesifikasi</th>
                                <th class="text-center" style="width: 40px">Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prosesors as $key => $prosesor)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        Prosesor | {{ $prosesor->model }}
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-flat"
                                            data-dismiss="modal" onclick="set_prosesor({{ $prosesor->id }})">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal"
                        onclick="uncheck_karyawan()">Hapus Terpilih</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-ram">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih RAM</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 20px">No</th>
                                <th>Spesifikasi</th>
                                <th class="text-center" style="width: 40px">Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rams as $key => $ram)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        RAM
                                        <span class="text-muted">({{ $ram->merek }})</span>
                                        <br>
                                        {{ $ram->tipe }} | {{ $ram->kapasitas }} GB
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-flat"
                                            data-dismiss="modal" onclick="set_ram({{ $ram->id }})">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal"
                        onclick="uncheck_karyawan()">Hapus Terpilih</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-ram_tambahan">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih RAM</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 20px">No</th>
                                <th>Spesifikasi</th>
                                <th class="text-center" style="width: 40px">Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rams as $key => $ram)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        RAM
                                        <span class="text-muted">({{ $ram->merek }})</span>
                                        <br>
                                        {{ $ram->tipe }} | {{ $ram->kapasitas }} GB
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-flat"
                                            data-dismiss="modal" onclick="set_ram_tambahan({{ $ram->id }})">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal"
                        onclick="uncheck_karyawan()">Hapus Terpilih</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-storage">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Storage</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 20px">No</th>
                                <th>Spesifikasi</th>
                                <th class="text-center" style="width: 40px">Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($storages as $storage)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        Storage
                                        <span class="text-muted">({{ $storage->merek }})</span>
                                        <br>
                                        {{ $storage->tipe }} | {{ $storage->kapasitas }} GB
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-flat"
                                            data-dismiss="modal" onclick="set_storage({{ $storage->id }})">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal"
                        onclick="uncheck_karyawan()">Hapus Terpilih</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-storage_tambahan">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Storage</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 20px">No</th>
                                <th>Spesifikasi</th>
                                <th class="text-center" style="width: 40px">Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($storages as $storage)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        Storage
                                        <span class="text-muted">({{ $storage->merek }})</span>
                                        <br>
                                        {{ $storage->tipe }} | {{ $storage->kapasitas }} GB
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-flat"
                                            data-dismiss="modal" onclick="set_storage({{ $storage->id }})">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal"
                        onclick="uncheck_karyawan()">Hapus Terpilih</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        $('#keyword').on('search', function() {
            search_perangkat();
        });

        function search_perangkat() {
            $('#table-perangkat').hide();
            $('#tbody-perangkat').empty();
            $('#modal-batas').hide();
            $('#modal-loading').show();
            $.ajax({
                url: "{{ url('admin/perbaikan/perangkat-search') }}",
                type: "GET",
                data: {
                    "keyword": $('#keyword').val(),
                },
                dataType: "json",
                success: function(data) {
                    if (data.length > 0) {
                        $.each(data, function(key, value) {
                            tbody_perangkat(value, (key + 1));
                        });
                        if (data.length == 10) {
                            $('#modal-batas').show();
                        }
                    } else {
                        var tbody = '<tr>';
                        tbody += '<td class="text-center" colspan="3">- Data tidak ditemukan -</td>';
                        tbody += '</tr>';
                        $('#tbody-perangkat').append(tbody);
                    }
                    $('#modal-loading').hide();
                    $('#table-perangkat').show();
                },
            });
        }

        function tbody_perangkat(data, no) {
            var tbody = '<tr>';
            tbody += '<td class="text-center">' + no + '</td>';
            tbody += '<td>';
            if (data.karyawan_id) {
                tbody += data.karyawan.nama;
                tbody += '<br>';
            }
            tbody += data.unit.nama;
            tbody += '</td>';
            tbody += '<td class="text-center">';
            tbody +=
                '<button type="button" class="btn btn-outline-primary btn-sm btn-flat" data-dismiss="modal" onclick="set_perangkat(' +
                data.id + ')">';
            tbody += '<i class="fas fa-check"></i>';
            tbody += '</button>';
            tbody += '</td>';
            tbody += '</tr>';
            $('#tbody-perangkat').append(tbody);
        }

        function set_perangkat(id, is_old = false) {
            $.ajax({
                url: "{{ url('admin/perbaikan/perangkat-set') }}" + "/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        set_karyawan(data);
                        // 
                        $('#perangkat-unit').text(data.unit.nama);
                        $('#perangkat-jenis').text(data.jenis.toUpperCase());
                        $('#perangkat-merek').text(data.merek);
                        $('#perangkat-model').text(data.model);
                        $('#perangkat-no_seri').text(data.no_seri);
                        // 
                        $('#perangkat-ram_tipe').text(data.ram_tipe);
                        $('#perangkat-ram_kapasitas').text(data.ram_kapasitas + ' GB');
                        $('#perangkat-ram_merek').text(data.ram_merek);
                        // 
                        set_ram_tambahan(data);
                        // 
                        $('#perangkat-storage_tipe').text(data.storage_tipe);
                        $('#perangkat-storage_kapasitas').text(data.storage_kapasitas + ' GB');
                        $('#perangkat-storage_merek').text(data.storage_merek);
                        // 
                        set_storage_tambahan(data);
                        // 
                        set_jenis_pc(data);
                        // 
                        $('#layout-kosong').hide();
                        $('#layout-perangkat').show();
                    } else {
                        $('#perangkat-karyawan').text('-');
                        $('#perangkat-unit').text('-');
                        $('#perangkat-jenis').text('-');
                        $('#perangkat-merek').text('-');
                        $('#perangkat-model').text('-');
                        $('#perangkat-no_seri').text('-');
                        $('#perangkat-ram_tipe').text('-');
                        $('#perangkat-ram_kapasitas').text('-');
                        $('#perangkat-ram_merek').text('-');
                        // 
                        $('#layout-perangkat').hide();
                        $('#layout-kosong').show();
                    }
                },
            });
        }

        function set_karyawan(data) {
            if (data.karyawan_id) {
                $('#perangkat-karyawan').text(data.karyawan.nama);
                // 
                $('#layout-perangkat-karyawan').show();
            } else {
                $('#perangkat-karyawan').text('-');
                // 
                $('#layout-perangkat-karyawan').hide();
            }
        }

        function set_ram_tambahan(data) {
            if (data.is_ram_tambahan) {
                $('#perangkat-is_ram_tambahan').prop('checked', true);
                $('#perangkat-ram_tambahan_tipe').text(data.ram_tipe);
                $('#perangkat-ram_tambahan_kapasitas').text(data.ram_tambahan_kapasitas + ' GB');
                $('#perangkat-ram_tambahan_merek').text(data.ram_tambahan_merek);
                // 
                $('#ram_tambahan-kosong-button').hide();
                $('#layout-perangkat-is_ram_tambahan-kosong').hide();
                $('#ram_tambahan-label-kosong').hide();
                $('#ram_tambahan-label-ada').show();
                $('#layout-perangkat-is_ram_tambahan').show();
            } else {
                $('#perangkat-is_ram_tambahan').prop('checked', false);
                $('#perangkat-ram_tambahan_tipe').text('-');
                $('#perangkat-ram_tambahan_kapasitas').text('-');
                $('#perangkat-ram_tambahan_merek').text('-');
                // 
                $('#layout-perangkat-is_ram_tambahan').hide();
                $('#ram_tambahan-label-ada').hide();
                $('#ram_tambahan-label-kosong').show();
                $('#layout-perangkat-is_ram_tambahan-kosong').show();
                $('#ram_tambahan-kosong-button').hide();
            }
        }

        function set_storage_tambahan(data) {
            if (data.is_storage_tambahan) {
                $('#perangkat-is_storage_tambahan').prop('checked', true);
                $('#perangkat-storage_tambahan_tipe').text(data.storage_tambahan_tipe);
                $('#perangkat-storage_tambahan_kapasitas').text(data.storage_tambahan_kapasitas +
                    ' GB');
                $('#perangkat-storage_tambahan_merek').text(data.storage_tambahan_merek);
                // 
                $('#storage_tambahan-kosong-button').hide();
                $('#layout-perangkat-is_storage_tambahan-kosong').hide();
                $('#storage_tambahan-label-kosong').hide();
                $('#storage_tambahan-label-ada').show();
                $('#layout-perangkat-is_storage_tambahan').show();
            } else {
                $('#perangkat-is_storage_tambahan').prop('checked', false);
                $('#perangkat-storage_tambahan_tipe').text('-');
                $('#perangkat-storage_tambahan_kapasitas').text('-');
                $('#perangkat-storage_tambahan_merek').text('-');
                // 
                $('#layout-perangkat-is_storage_tambahan').hide();
                $('#storage_tambahan-label-ada').hide();
                $('#storage_tambahan-label-kosong').show();
                $('#layout-perangkat-is_storage_tambahan-kosong').show();
                $('#storage_tambahan-kosong-button').hide();
            }
        }

        function set_jenis_pc(data) {
            if (data.jenis === 'pc') {
                $('#perangkat-psu_kapasitas').text(data.psu_kapasitas + ' Watt');
                $('#perangkat-psu_merek').text(data.psu_merek);
                $('#perangkat-heatsink_model').text(data.heatsink_model);
                $('#perangkat-heatsink_merek').text(data.heatsink_merek);
                $('#perangkat-monitor_merek').text(data.monitor_merek);
                $('#perangkat-monitor_ukuran').text(data.monitor_ukuran + ' Inch');
                $('#perangkat-keyboard_merek').text(data.keyboard_merek);
                $('#perangkat-mouse_merek').text(data.mouse_merek);
                //
                $('#layout-perangkat-pc').show();
            } else {
                $('#perangkat-psu_kapasitas').text('-');
                $('#perangkat-psu_merek').text('-');
                $('#perangkat-heatsink_model').text('-');
                $('#perangkat-heatsink_merek').text('-');
                $('#perangkat-monitor_merek').text('-');
                $('#perangkat-monitor_ukuran').text('-');
                $('#perangkat-keyboard_merek').text('-');
                $('#perangkat-mouse_merek').text('-');
                //
                $('#layout-perangkat-pc').hide();
            }
        }

        function ram_tambahan() {
            if ($('#perangkat-is_ram_tambahan').prop('checked')) {
                $('#ram_tambahan-kosong-button').show();
            } else {
                $('#ram_tambahan-kosong-button').hide();
            }
        }

        function storage_tambahan() {
            if ($('#perangkat-is_storage_tambahan').prop('checked')) {
                $('#storage_tambahan-kosong-button').show();
            } else {
                $('#storage_tambahan-kosong-button').hide();
            }
        }

        var canvas;
        var signaturePadCanvas;
        $(document).ready(() => {
            signaturePadCanvas = document.querySelector("#signaturePad");
            var parentWidth = jQuery(signaturePadCanvas).parent().outerWidth(300);
            signaturePadCanvas.setAttribute("width", parentWidth);
            canvas = new SignaturePad(signaturePadCanvas);
        })

        function resetPad() {
            canvas.clear();
            $('#ttd').val(null);
        }

        function konfirmasi() {
            if (!canvas.isEmpty()) {
                var dataURL = canvas.toDataURL();
                $('#ttd').val(dataURL);
            }
            $('#form-konfirmasi').submit();
        }

        var cek = @json(session('cek'));

        if (cek != null) {
            $('#btn-cek').click();
        }
    </script>
@endsection
