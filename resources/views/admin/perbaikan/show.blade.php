@extends('layouts.app')

@section('title', 'Perbaikan Perangkat')

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
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action="{{ url('admin/perbaikan') }}" method="post" enctype="multipart/form-data" id="form-submit"
                    autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title mb-2">Detail Perbaikan</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row mb-2">
                                        @if ($perangkat->karyawan_id)
                                            <div class="col-md-4">
                                                <strong>Karyawan</strong>
                                                <br>
                                                {{ $perangkat->karyawan->nama }}
                                            </div>
                                        @endif
                                        <div class="col-md-4">
                                            <strong>Unit / Bagian</strong>
                                            <br>
                                            {{ $perangkat->unit->nama }}
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control rounded-0" id="perangkat_id"
                                        name="perangkat_id" value="{{ $perangkat->id }}">
                                    @error('perangkat_id')
                                        <div class="text-danger">
                                            <small>{{ $message }}</small>
                                        </div>
                                    @enderror
                                    <hr class="mb-2">
                                    <div class="row mb-2">
                                        <div class="col-md-4">
                                            <strong>Jenis Barang</strong>
                                            <br>
                                            {{ strtoupper($perangkat->jenis) }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Merek</strong>
                                            <br>
                                            {{ $perangkat->merek }}
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-secondary btn-xs btn-flat" data-toggle="modal"
                                        data-target="#modal-motherboard">Ganti
                                        Motherboard</button>
                                    <div class="alert alert-info rounded-0 mt-2" id="layout-motherboard"
                                        style="display: none;">
                                        <input type="text" class="form-control rounded-0" id="motherboard_id"
                                            name="motherboard_id" hidden>
                                        <span id="motherboard-detail"></span>
                                    </div>
                                    <hr class="mb-2">
                                    <div class="row mb-2">
                                        <div class="col-md-4">
                                            <strong>Model</strong>
                                            <br>
                                            {{ $perangkat->model }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>No Seri</strong>
                                            <br>
                                            {{ $perangkat->no_seri }}
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-secondary btn-xs btn-flat" data-toggle="modal"
                                        data-target="#modal-prosesor">Ganti
                                        Prosesor</button>
                                    <div class="alert alert-info rounded-0 mt-2" id="layout-prosesor"
                                        style="display: none;">
                                        <input type="text" class="form-control rounded-0" id="prosesor_id"
                                            name="prosesor_id" hidden>
                                        <span id="prosesor-detail"></span>
                                    </div>
                                    <hr class="mb-2">
                                    <div class="row mb-2">
                                        <div class="col-md-4">
                                            <strong>Tipe RAM</strong>
                                            <br>
                                            {{ $perangkat->ram_tipe }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Kapasitas RAM</strong>
                                            <br>
                                            {{ $perangkat->ram_kapasitas }} GB
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Merek RAM</strong>
                                            <br>
                                            {{ $perangkat->ram_merek }}
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-secondary btn-xs btn-flat" data-toggle="modal"
                                        data-target="#modal-ram">Ganti RAM</button>
                                    <div class="alert alert-info rounded-0 mt-2" id="layout-ram" style="display: none;">
                                        <input type="text" class="form-control rounded-0" id="ram_id" name="ram_id"
                                            hidden>
                                        <span id="ram-detail"></span>
                                    </div>
                                    <hr class="mb-2">
                                    <div class="form-group mb-2">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is_ram_tambahan"
                                                name="is_ram_tambahan" onchange="ram_tambahan()"
                                                {{ old('is_ram_tambahan', $perangkat->is_ram_tambahan) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_ram_tambahan">
                                                RAM Tambahan
                                                @if ($perangkat->is_ram_tambahan)
                                                    <small class="text-muted">(uncheck jika tidak diperlukan)</small>
                                                @else
                                                    <small class="text-muted" id="ram_tambahan-label-kosong">(checklist
                                                        untuk menambahkan)</small>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    @if ($perangkat->is_ram_tambahan)
                                        <div id="ram_tambahan">
                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                    <strong>Tipe RAM</strong>
                                                    <br>
                                                    {{ $perangkat->ram_tipe }}
                                                </div>
                                                <div class="col-md-4">
                                                    <strong>Kapasitas RAM</strong>
                                                    <br>
                                                    {{ $perangkat->ram_tambahan_kapasitas }} GB
                                                </div>
                                                <div class="col-md-4">
                                                    <strong>Merek RAM</strong>
                                                    <br>
                                                    {{ $perangkat->ram_tambahan_merek }}
                                                </div>
                                            </div>
                                        </div>
                                        <div id="ram_tambahan-batal" style="display: none;">
                                            <div class="border text-center p-2 mb-1">
                                                <small class="text-muted">- RAM tidak ditambahkan -</small>
                                            </div>
                                        </div>
                                    @else
                                        <div class="border text-center p-2 mb-1">
                                            <small class="text-muted">- RAM belum ditambahkan -</small>
                                        </div>
                                    @endif
                                    <button type="button" class="btn btn-secondary btn-xs btn-flat"
                                        id="ram_tambahan-button" data-toggle="modal" data-target="#modal-ram_tambahan"
                                        style="{{ old('is_ram_tambahan', $perangkat->is_ram_tambahan) ? '' : 'display: none;' }}">
                                        @if ($perangkat->is_ram_tambahan)
                                            Ganti RAM
                                        @else
                                            Tambah RAM
                                        @endif
                                    </button>
                                    <div class="alert alert-info rounded-0 mt-2" id="layout-ram_tambahan"
                                        style="display: none;">
                                        <input type="hidden" class="form-control rounded-0" id="ram_tambahan_id"
                                            name="ram_tambahan_id">
                                        <span id="ram_tambahan-detail"></span>
                                    </div>
                                    @error('ram_tambahan_id')
                                        <div class="text-danger">
                                            <small>{{ $message }}</small>
                                        </div>
                                    @enderror
                                    <hr class="mb-2">
                                    <div class="row mb-2">
                                        <div class="col-md-4">
                                            <strong>Tipe Storage</strong>
                                            <br>
                                            {{ $perangkat->storage_tipe }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Kapasitas Storage</strong>
                                            <br>
                                            {{ $perangkat->storage_kapasitas }} GB
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Merek Storage</strong>
                                            <br>
                                            {{ $perangkat->storage_merek }}
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-secondary btn-xs btn-flat" data-toggle="modal"
                                        data-target="#modal-storage">Ganti Storage</button>
                                    <div class="alert alert-info rounded-0 mt-2" id="layout-storage"
                                        style="display: none;">
                                        <input type="text" class="form-control rounded-0" id="storage_id"
                                            name="storage_id" hidden>
                                        <span id="storage-detail"></span>
                                    </div>
                                    <hr class="mb-2">
                                    <div class="form-group mb-2">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is_storage_tambahan"
                                                name="is_storage_tambahan" onchange="storage_tambahan()"
                                                {{ old('is_storage_tambahan', $perangkat->is_storage_tambahan) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_storage_tambahan">
                                                Storage Tambahan
                                                <small class="text-muted">
                                                    @if ($perangkat->is_storage_tambahan)
                                                        (uncheck jika tidak diperlukan)
                                                    @else
                                                        (checklist untuk menambahkan)
                                                    @endif
                                                </small>
                                            </label>
                                        </div>
                                    </div>
                                    @if ($perangkat->is_storage_tambahan)
                                        <div id="storage_tambahan">
                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                    <strong>Tipe Storage</strong>
                                                    <br>
                                                    {{ $perangkat->storage_tambahan_tipe }}
                                                </div>
                                                <div class="col-md-4">
                                                    <strong>Kapasitas Storage</strong>
                                                    <br>
                                                    {{ $perangkat->storage_tambahan_kapasitas }} GB
                                                </div>
                                                <div class="col-md-4">
                                                    <strong>Merek Storage</strong>
                                                    <br>
                                                    {{ $perangkat->storage_tambahan_merek }}
                                                </div>
                                            </div>
                                        </div>
                                        <div id="storage_tambahan-batal" style="display: none;">
                                            <div class="border text-center p-2 mb-1">
                                                <small class="text-muted">- Storage tidak ditambahkan -</small>
                                            </div>
                                        </div>
                                    @else
                                        <div class="border text-center p-2 mb-1">
                                            <small class="text-muted">- Storage belum ditambahkan -</small>
                                        </div>
                                    @endif
                                    <button type="button" class="btn btn-secondary btn-xs btn-flat"
                                        id="storage_tambahan-button" data-toggle="modal"
                                        data-target="#modal-storage_tambahan"
                                        style="{{ old('is_storage_tambahan', $perangkat->is_storage_tambahan) ? '' : 'display: none;' }}">
                                        @if ($perangkat->is_storage_tambahan)
                                            Ganti Storage
                                        @else
                                            Tambah Storage
                                        @endif
                                    </button>
                                    <div class="alert alert-info rounded-0 mt-2" id="layout-storage_tambahan"
                                        style="display: none;">
                                        <input type="hidden" class="form-control rounded-0" id="storage_tambahan_id"
                                            name="storage_tambahan_id">
                                        <span id="storage_tambahan-detail"></span>
                                    </div>
                                    @error('storage_tambahan_id')
                                        <div class="text-danger">
                                            <small>{{ $message }}</small>
                                        </div>
                                    @enderror
                                    <hr class="mb-2">
                                    @if ($perangkat->jenis == 'pc')
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <strong>Kapasitas PSU</strong>
                                                <br>
                                                {{ $perangkat->psu_kapasitas }} Watt
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Merek PSU</strong>
                                                <br>
                                                {{ $perangkat->psu_merek }}
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-secondary btn-xs btn-flat"
                                            data-toggle="modal" data-target="#modal-psu">Ganti PSU</button>
                                        <div class="alert alert-info rounded-0 mt-2" id="layout-psu"
                                            style="display: none;">
                                            <input type="text" class="form-control rounded-0" id="psu_id"
                                                name="psu_id" hidden>
                                            <span id="psu-detail"></span>
                                        </div>
                                        <hr class="mb-2">
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <strong>Model Heatsink</strong>
                                                <br>
                                                {{ $perangkat->heatsink_model }}
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Merek Heatsink</strong>
                                                <br>
                                                {{ $perangkat->heatsink_merek }}
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-secondary btn-xs btn-flat"
                                            data-toggle="modal" data-target="#modal-heatsink">Ganti
                                            Heatsink</button>
                                        <div class="alert alert-info rounded-0 mt-2" id="layout-heatsink"
                                            style="display: none;">
                                            <input type="text" class="form-control rounded-0" id="heatsink_id"
                                                name="heatsink_id" hidden>
                                            <span id="heatsink-detail"></span>
                                        </div>
                                        <hr class="mb-2">
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <strong>Merek Monitor</strong>
                                                <br>
                                                {{ $perangkat->monitor_merek }}
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Ukuran Monitor</strong>
                                                <br>
                                                {{ $perangkat->monitor_ukuran }} Inch
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-secondary btn-xs btn-flat"
                                            data-toggle="modal" data-target="#modal-monitor">Ganti
                                            Monitor</button>
                                        <div class="alert alert-info rounded-0 mt-2" id="layout-monitor"
                                            style="display: none;">
                                            <input type="text" class="form-control rounded-0" id="monitor_id"
                                                name="monitor_id" hidden>
                                            <span id="monitor-detail"></span>
                                        </div>
                                        <hr class="mb-2">
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <strong>Merek Keyboard</strong>
                                                <br>
                                                {{ $perangkat->keyboard_merek }}
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-secondary btn-xs btn-flat"
                                            data-toggle="modal" data-target="#modal-keyboard">Ganti
                                            Keyboard</button>
                                        <div class="alert alert-info rounded-0 mt-2" id="layout-keyboard"
                                            style="display: none;">
                                            <input type="text" class="form-control rounded-0" id="keyboard_id"
                                                name="keyboard_id" hidden>
                                            <span id="keyboard-detail"></span>
                                        </div>
                                        <hr class="mb-2">
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <strong>Merek Mouse</strong>
                                                <br>
                                                {{ $perangkat->mouse_merek }}
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-secondary btn-xs btn-flat"
                                            data-toggle="modal" data-target="#modal-mouse">Ganti
                                            Mouse</button>
                                        <div class="alert alert-info rounded-0 mt-2" id="layout-mouse"
                                            style="display: none;">
                                            <input type="text" class="form-control rounded-0" id="mouse_id"
                                                name="mouse_id" hidden>
                                            <span id="mouse-detail"></span>
                                        </div>
                                    @endif
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
                                        <label for="tanggal">Tanggal Perbaikan</label>
                                        <input type="date"
                                            class="form-control rounded-0 @error('tanggal') is-invalid @enderror"
                                            id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}">
                                        @error('tanggal')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="keterangan">Tindakan</label>
                                        <textarea class="form-control rounded-0 @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan"
                                            cols="30" rows="4">{{ old('keterangan') }}</textarea>
                                        @error('keterangan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="foto_sebelum">Foto Kondisi Sebelum</label>
                                        <input type="file"
                                            class="form-control rounded-0 @error('foto_sebelum') is-invalid @enderror"
                                            id="foto_sebelum" name="foto_sebelum" accept="image/*">
                                        @error('foto_sebelum')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="foto_sesudah">Foto Kondisi Sesudah</label>
                                        <input type="file"
                                            class="form-control rounded-0 @error('foto_sesudah') is-invalid @enderror"
                                            id="foto_sesudah" name="foto_sesudah" accept="image/*">
                                        @error('foto_sesudah')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="paraf">Paraf</label>
                                        <div class="row mb-2">
                                            <div class="col-12">
                                                <canvas id="signaturePad" height="285" width="285"
                                                    style="border-style: dashed"></canvas>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control rounded-0" id="paraf"
                                            name="paraf">
                                        <button type="button" class="btn btn-danger btn-sm btn-flat float-start"
                                            onclick="resetPad()">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                        @error('paraf')
                                            <div class="text-danger">
                                                <small>{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right pb-4">
                        <button type="button" class="btn btn-primary btn-sm btn-flat" onclick="konfirmasi()">Buat
                            Perbaikan</button>
                    </div>
                </form>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
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
                                        @if ($motherboard->is_baru)
                                            @if (Carbon\Carbon::now()->format('Y-m-d') <
                                                    Carbon\Carbon::parse($motherboard->tanggal)->addMonth($motherboard->garansi))
                                                <span class="badge bg-primary">Baru</span>
                                            @endif
                                        @endif
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
                        onclick="uncheck_motherboard()">Hapus Terpilih</button>
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
                                        @if ($prosesor->is_baru)
                                            @if (Carbon\Carbon::now()->format('Y-m-d') < Carbon\Carbon::parse($prosesor->tanggal)->addMonth($prosesor->garansi))
                                                <span class="badge bg-primary">Baru</span>
                                            @endif
                                        @endif
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
                        onclick="uncheck_prosesor()">Hapus Terpilih</button>
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
                                        @if ($ram->is_baru)
                                            @if (Carbon\Carbon::now()->format('Y-m-d') < Carbon\Carbon::parse($ram->tanggal)->addMonth($ram->garansi))
                                                <span class="badge bg-primary">Baru</span>
                                            @endif
                                        @endif
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
                        onclick="uncheck_ram()">Hapus Terpilih</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-ram_tambahan">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih RAM Tambahan</h4>
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
                                        @if ($ram->is_baru)
                                            @if (Carbon\Carbon::now()->format('Y-m-d') < Carbon\Carbon::parse($ram->tanggal)->addMonth($ram->garansi))
                                                <span class="badge bg-primary">Baru</span>
                                            @endif
                                        @endif
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
                        onclick="uncheck_ram_tambahan()">Hapus Terpilih</button>
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
                                        @if ($storage->is_baru)
                                            @if (Carbon\Carbon::now()->format('Y-m-d') < Carbon\Carbon::parse($storage->tanggal)->addMonth($storage->garansi))
                                                <span class="badge bg-primary">Baru</span>
                                            @endif
                                        @endif
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
                        onclick="uncheck_storage()">Hapus Terpilih</button>
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
                                        @if ($storage->is_baru)
                                            @if (Carbon\Carbon::now()->format('Y-m-d') < Carbon\Carbon::parse($storage->tanggal)->addMonth($storage->garansi))
                                                <span class="badge bg-primary">Baru</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-flat"
                                            data-dismiss="modal" onclick="set_storage_tambahan({{ $storage->id }})">
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
                        onclick="uncheck_storage_tambahan()">Hapus Terpilih</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-psu">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih PSU</h4>
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
                            @foreach ($psus as $psu)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        PSU
                                        <span class="text-muted">({{ $psu->merek }})</span>
                                        <br>
                                        {{ $psu->kapasitas }} Watt
                                        @if ($psu->is_baru)
                                            @if (Carbon\Carbon::now()->format('Y-m-d') < Carbon\Carbon::parse($psu->tanggal)->addMonth($psu->garansi))
                                                <span class="badge bg-primary">Baru</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-flat"
                                            data-dismiss="modal" onclick="set_psu({{ $psu->id }})">
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
                        onclick="uncheck_psu()">Hapus Terpilih</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-heatsink">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Heatsink</h4>
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
                            @foreach ($heatsinks as $heatsink)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        Heatsink
                                        <span class="text-muted">({{ $heatsink->merek }})</span>
                                        <br>
                                        {{ $heatsink->model }}
                                        @if ($heatsink->is_baru)
                                            @if (Carbon\Carbon::now()->format('Y-m-d') < Carbon\Carbon::parse($heatsink->tanggal)->addMonth($heatsink->garansi))
                                                <span class="badge bg-primary">Baru</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-flat"
                                            data-dismiss="modal" onclick="set_heatsink({{ $heatsink->id }})">
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
                        onclick="uncheck_heatsink()">Hapus Terpilih</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-monitor">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Monitor</h4>
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
                            @foreach ($monitors as $monitor)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        Monitor
                                        <span class="text-muted">({{ $monitor->merek }})</span>
                                        <br>
                                        {{ $monitor->kapasitas }} Inch
                                        @if ($monitor->is_baru)
                                            @if (Carbon\Carbon::now()->format('Y-m-d') < Carbon\Carbon::parse($monitor->tanggal)->addMonth($monitor->garansi))
                                                <span class="badge bg-primary">Baru</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-flat"
                                            data-dismiss="modal" onclick="set_monitor({{ $monitor->id }})">
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
                        onclick="uncheck_monitor()">Hapus Terpilih</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-keyboard">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Keyboard</h4>
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
                            @foreach ($keyboards as $keyboard)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        Keyboard
                                        <span class="text-muted">({{ $keyboard->merek }})</span>
                                        @if ($keyboard->is_baru)
                                            @if (Carbon\Carbon::now()->format('Y-m-d') < Carbon\Carbon::parse($keyboard->tanggal)->addMonth($keyboard->garansi))
                                                <span class="badge bg-primary">Baru</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-flat"
                                            data-dismiss="modal" onclick="set_keyboard({{ $keyboard->id }})">
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
                        onclick="uncheck_keyboard()">Hapus Terpilih</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-mouse">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Mouse</h4>
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
                            @foreach ($mouses as $mouse)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        Mouse
                                        <span class="text-muted">({{ $mouse->merek }})</span>
                                        @if ($mouse->is_baru)
                                            @if (Carbon\Carbon::now()->format('Y-m-d') < Carbon\Carbon::parse($mouse->tanggal)->addMonth($mouse->garansi))
                                                <span class="badge bg-primary">Baru</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-flat"
                                            data-dismiss="modal" onclick="set_mouse({{ $mouse->id }})">
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
                        onclick="uncheck_mouse()">Hapus Terpilih</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        function set_motherboard(id) {
            $.ajax({
                url: "{{ url('admin/perbaikan/motherboard-set') }}" + "/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#layout-motherboard').show();
                        $('#motherboard_id').val(data.id);
                        $('#motherboard-detail').text('Motherboard (' + data.merek + ') | ' + data.model +
                            ' | ' + data.tipe);
                    } else {
                        $('#layout-motherboard').hide();
                        $('#motherboard_id').val(null);
                        $('#motherboard-detail').text('-');
                    }
                },
            });
        }

        var motherboard_id = "{{ old('motherboard_id') }}";
        if (motherboard_id) {
            set_motherboard(motherboard_id);
        }

        function set_prosesor(id) {
            $.ajax({
                url: "{{ url('admin/perbaikan/prosesor-set') }}" + "/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#layout-prosesor').show();
                        $('#prosesor_id').val(data.id);
                        $('#prosesor-detail').text('Prosesor | ' + data.model);
                    } else {
                        $('#layout-prosesor').hide();
                        $('#prosesor_id').val(null);
                        $('#prosesor-detail').text('-');
                    }
                },
            });
        }

        var prosesor_id = "{{ old('prosesor_id') }}";
        if (prosesor_id) {
            set_prosesor(prosesor_id);
        }

        function set_ram(id) {
            $.ajax({
                url: "{{ url('admin/perbaikan/ram-set') }}" + "/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#layout-ram').show();
                        $('#ram_id').val(data.id);
                        $('#ram-detail').text('RAM (' + data.merek + ') | ' + data.tipe + ' | ' + data
                            .kapasitas + ' GB');
                    } else {
                        $('#layout-ram').hide();
                        $('#ram_id').val(null);
                        $('#ram-detail').text('-');
                    }
                },
            });
        }

        var ram_id = "{{ old('ram_id') }}";
        if (ram_id) {
            set_ram(ram_id);
        }

        function set_ram_tambahan(id) {
            $.ajax({
                url: "{{ url('admin/perbaikan/ram-set') }}" + "/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#layout-ram_tambahan').show();
                        $('#ram_tambahan_id').val(data.id);
                        $('#ram_tambahan-detail').text('RAM (' + data.merek + ') | ' + data.tipe + ' | ' + data
                            .kapasitas + ' GB');
                    } else {
                        $('#layout-ram_tambahan').hide();
                        $('#ram_tambahan_id').val(null);
                        $('#ram_tambahan-detail').text('-');
                    }
                },
            });
        }

        var ram_tambahan_id = "{{ old('ram_tambahan_id') }}";
        if (ram_tambahan_id) {
            set_ram_tambahan(ram_tambahan_id);
        }

        function set_storage(id) {
            $.ajax({
                url: "{{ url('admin/perbaikan/storage-set') }}" + "/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#layout-storage').show();
                        $('#storage_id').val(data.id);
                        $('#storage-detail').text('Storage (' + data.merek + ') | ' + data.tipe + ' | ' + data
                            .kapasitas + ' GB');
                    } else {
                        $('#layout-storage').hide();
                        $('#storage_id').val(null);
                        $('#storage-detail').text('-');
                    }
                },
            });
        }

        var storage_id = "{{ old('storage_id') }}";
        if (storage_id) {
            set_storage(storage_id);
        }

        function set_storage_tambahan(id) {
            $.ajax({
                url: "{{ url('admin/perbaikan/storage-set') }}" + "/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#layout-storage_tambahan').show();
                        $('#storage_tambahan_id').val(data.id);
                        $('#storage_tambahan-detail').text('Storage (' + data.merek + ') | ' + data.tipe +
                            ' | ' + data
                            .kapasitas + ' GB');
                    } else {
                        $('#layout-storage_tambahan').hide();
                        $('#storage_tambahan_id').val(null);
                        $('#storage_tambahan-detail').text('-');
                    }
                },
            });
        }

        var storage_tambahan_id = "{{ old('storage_tambahan_id') }}";
        if (storage_tambahan_id) {
            set_storage_tambahan(storage_tambahan_id);
        }

        function set_psu(id) {
            $.ajax({
                url: "{{ url('admin/perbaikan/psu-set') }}" + "/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#layout-psu').show();
                        $('#psu_id').val(data.id);
                        $('#psu-detail').text('PSU (' + data.merek + ') | ' + data.kapasitas + ' Watt');
                    } else {
                        $('#layout-psu').hide();
                        $('#psu_id').val(null);
                        $('#psu-detail').text('-');
                    }
                },
            });
        }

        var psu_id = "{{ old('psu_id') }}";
        if (psu_id) {
            set_psu(psu_id);
        }

        function set_heatsink(id) {
            $.ajax({
                url: "{{ url('admin/perbaikan/heatsink-set') }}" + "/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#layout-heatsink').show();
                        $('#heatsink_id').val(data.id);
                        $('#heatsink-detail').text('Heatsink (' + data.merek + ') | ' + data.model);
                    } else {
                        $('#layout-heatsink').hide();
                        $('#heatsink_id').val(null);
                        $('#heatsink-detail').text('-');
                    }
                },
            });
        }

        var heatsink_id = "{{ old('heatsink_id') }}";
        if (heatsink_id) {
            set_heatsink(heatsink_id);
        }

        function set_monitor(id) {
            $.ajax({
                url: "{{ url('admin/perbaikan/monitor-set') }}" + "/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#layout-monitor').show();
                        $('#monitor_id').val(data.id);
                        $('#monitor-detail').text('Monitor (' + data.merek + ') | ' + data.kapasitas +
                            ' Inch');
                    } else {
                        $('#layout-monitor').hide();
                        $('#monitor_id').val(null);
                        $('#monitor-detail').text('-');
                    }
                },
            });
        }

        var monitor_id = "{{ old('monitor_id') }}";
        if (monitor_id) {
            set_monitor(monitor_id);
        }

        function set_keyboard(id) {
            $.ajax({
                url: "{{ url('admin/perbaikan/keyboard-set') }}" + "/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#layout-keyboard').show();
                        $('#keyboard_id').val(data.id);
                        $('#keyboard-detail').text('Keyboard (' + data.merek + ')');
                    } else {
                        $('#layout-keyboard').hide();
                        $('#keyboard_id').val(null);
                        $('#keyboard-detail').text('-');
                    }
                },
            });
        }

        var keyboard_id = "{{ old('keyboard_id') }}";
        if (keyboard_id) {
            set_keyboard(keyboard_id);
        }

        function set_mouse(id) {
            $.ajax({
                url: "{{ url('admin/perbaikan/mouse-set') }}" + "/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#layout-mouse').show();
                        $('#mouse_id').val(data.id);
                        $('#mouse-detail').text('Mouse (' + data.merek + ')');
                    } else {
                        $('#layout-mouse').hide();
                        $('#mouse_id').val(null);
                        $('#mouse-detail').text('-');
                    }
                },
            });
        }

        var mouse_id = "{{ old('mouse_id') }}";
        if (mouse_id) {
            set_mouse(mouse_id);
        }

        function uncheck_motherboard() {
            $('#layout-motherboard').hide();
            $('#motherboard_id').val(null);
            $('#motherboard-detail').text('-');
        }

        function uncheck_prosesor() {
            $('#layout-prosesor').hide();
            $('#prosesor_id').val(null);
            $('#prosesor-detail').text('-');
        }

        function uncheck_ram() {
            $('#layout-ram').hide();
            $('#ram_id').val(null);
            $('#ram-detail').text('-');
        }

        function uncheck_ram_tambahan() {
            $('#layout-ram_tambahan').hide();
            $('#ram_tambahan_id').val(null);
            $('#ram_tambahan-detail').text('-');
        }

        function uncheck_storage() {
            $('#layout-storage').hide();
            $('#storage_id').val(null);
            $('#storage-detail').text('-');
        }

        function uncheck_storage_tambahan() {
            $('#layout-storage_tambahan').hide();
            $('#storage_tambahan_id').val(null);
            $('#storage_tambahan-detail').text('-');
        }

        function uncheck_psu() {
            $('#layout-psu').hide();
            $('#psu_id').val(null);
            $('#psu-detail').text('-');
        }

        function uncheck_heatsink() {
            $('#layout-heatsink').hide();
            $('#heatsink_id').val(null);
            $('#heatsink-detail').text('-');
        }

        function uncheck_monitor() {
            $('#layout-monitor').hide();
            $('#monitor_id').val(null);
            $('#monitor-detail').text('-');
        }

        function uncheck_keyboard() {
            $('#layout-keyboard').hide();
            $('#keyboard_id').val(null);
            $('#keyboard-detail').text('-');
        }

        function uncheck_mouse() {
            $('#layout-mouse').hide();
            $('#mouse_id').val(null);
            $('#mouse-detail').text('-');
        }

        var is_ram_tambahan = "{{ $perangkat->is_ram_tambahan }}";

        function ram_tambahan() {
            if ($('#is_ram_tambahan').prop('checked')) {
                $('#ram_tambahan-button').show();
                // 
                if (is_ram_tambahan) {
                    $('#ram_tambahan').show();
                    $('#ram_tambahan-batal').hide();
                }
            } else {
                $('#ram_tambahan-button').hide();
                // 
                $('#layout-ram_tambahan').hide();
                $('#ram_tambahan_id').val(null);
                $('#ram_tambahan-detail').text('-');
                // 
                if (is_ram_tambahan) {
                    $('#ram_tambahan').hide();
                    $('#ram_tambahan-batal').show();
                }
            }
        }

        var is_storage_tambahan = "{{ $perangkat->is_storage_tambahan }}";

        function storage_tambahan() {
            if ($('#is_storage_tambahan').prop('checked')) {
                $('#storage_tambahan-button').show();
                // 
                if (is_storage_tambahan) {
                    $('#storage_tambahan').show();
                    $('#storage_tambahan-batal').hide();
                }
            } else {
                $('#storage_tambahan-button').hide();
                // 
                $('#layout-storage_tambahan').hide();
                $('#storage_tambahan_id').val(null);
                $('#storage_tambahan-detail').text('-');
                // 
                if (is_storage_tambahan) {
                    $('#storage_tambahan').hide();
                    $('#storage_tambahan-batal').show();
                }
            }
        }

        var canvas;
        var signaturePadCanvas;
        $(document).ready(() => {
            signaturePadCanvas = document.querySelector("#signaturePad");
            canvas = new SignaturePad(signaturePadCanvas);
        })

        function resetPad() {
            canvas.clear();
            $('#paraf').val(null);
        }

        function konfirmasi() {
            if (!canvas.isEmpty()) {
                var dataURL = canvas.toDataURL();
                $('#paraf').val(dataURL);
            }
            $('#form-submit').submit();
        }
    </script>
@endsection
