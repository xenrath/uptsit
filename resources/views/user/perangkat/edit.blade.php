@extends('layouts.app')

@section('title', 'Edit Perangkat')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a href="{{ url('user/perangkat') }}" class="btn btn-secondary btn-flat float-left mr-2">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1 class="m-0">Edit Perangkat</h1>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
                <form action="{{ url('user/perangkat/' . $perangkat->id) }}" method="post" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Perangkat</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="karyawan_id">
                                            Karyawan
                                            <small>(opsional)</small>
                                        </label>
                                        <div class="input-group">
                                            <select class="custom-select rounded-0" id="karyawan_id" name="karyawan_id">
                                                <option value="">- Pilih -</option>
                                            </select>
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary btn-flat" data-toggle="modal"
                                                    data-target="#modal-karyawan">Pilih</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="unit_id">Unit / Bagian</label>
                                        <select class="custom-select rounded-0 @error('unit_id') is-invalid @enderror"
                                            id="unit_id" name="unit_id">
                                            <option value="">- Pilih -</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}"
                                                    {{ old('unit_id', $perangkat->unit_id) == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('unit_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="jenis">Jenis Barang</label>
                                        <select class="custom-select rounded-0 @error('jenis') is-invalid @enderror"
                                            id="jenis" name="jenis" onchange="set_jenis()">
                                            <option value="">- Pilih -</option>
                                            <option value="pc"
                                                {{ old('jenis', $perangkat->jenis) == 'pc' ? 'selected' : '' }}>PC</option>
                                            <option value="laptop"
                                                {{ old('jenis', $perangkat->jenis) == 'laptop' ? 'selected' : '' }}>Laptop
                                            </option>
                                        </select>
                                        @error('jenis')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="merek">Merek</label>
                                        <select class="custom-select rounded-0 @error('merek') is-invalid @enderror"
                                            id="merek" name="merek" onchange="set_merek()">
                                            <option value="">- Pilih -</option>
                                            @foreach ($mereks as $merek)
                                                <option value="{{ $merek->keterangan }}"
                                                    {{ old('merek', $perangkat->merek) == $merek->keterangan ? 'selected' : '' }}>
                                                    {{ $merek->keterangan }}</option>
                                            @endforeach
                                            <option value="lainnya" {{ old('merek') == 'lainnya' ? 'selected' : '' }}>
                                                Lainnya</option>
                                        </select>
                                        @error('merek')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2" id="layout-merek-lainnya" style="display: none;">
                                        <input type="text"
                                            class="form-control rounded-0 @error('merek_nama') is-invalid @enderror"
                                            id="merek_nama" name="merek_nama" value="{{ old('merek_nama') }}"
                                            placeholder="nama merek">
                                        @error('merek_nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="model">Model</label>
                                        <select class="custom-select rounded-0 @error('model') is-invalid @enderror"
                                            id="model" name="model" onchange="set_model()">
                                            <option value="">- Pilih -</option>
                                            @foreach ($models as $model)
                                                <option value="{{ $model->keterangan }}"
                                                    {{ old('model', $perangkat->model) == $model->keterangan ? 'selected' : '' }}>
                                                    {{ $model->keterangan }}
                                                </option>
                                            @endforeach
                                            <option value="lainnya" {{ old('model') == 'lainnya' ? 'selected' : '' }}>
                                                Lainnya</option>
                                        </select>
                                        @error('model')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2" id="layout-model-lainnya" style="display: none;">
                                        <input type="text"
                                            class="form-control rounded-0 @error('model_nama') is-invalid @enderror"
                                            id="model_nama" name="model_nama" value="{{ old('model_nama') }}"
                                            placeholder="nama model">
                                        @error('model_nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="no_seri">No Seri</label>
                                        <input type="text"
                                            class="form-control rounded-0 @error('no_seri') is-invalid @enderror"
                                            id="no_seri" name="no_seri"
                                            value="{{ old('no_seri', $perangkat->no_seri) }}">
                                        @error('no_seri')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-2">
                            <div class="form-group mb-2">
                                <label for="ram_tipe">Tipe RAM</label>
                                <select class="custom-select rounded-0 @error('ram_tipe') is-invalid @enderror"
                                    id="ram_tipe" name="ram_tipe" onchange="set_ram_tipe()">
                                    <option value="">- Pilih -</option>
                                    @foreach ($ram_tipes as $ram_tipe)
                                        <option value="{{ $ram_tipe->keterangan }}"
                                            {{ old('ram_tipe', $perangkat->ram_tipe) == $ram_tipe->keterangan ? 'selected' : '' }}>
                                            {{ $ram_tipe->keterangan }}
                                        </option>
                                    @endforeach
                                    <option value="lainnya" {{ old('ram_tipe') == 'lainnya' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>
                                @error('ram_tipe')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2" id="layout-ram-tipe-lainnya" style="display: none;">
                                <input type="text"
                                    class="form-control rounded-0 @error('ram_tipe_nama') is-invalid @enderror"
                                    id="ram_tipe_nama" name="ram_tipe_nama" value="{{ old('ram_tipe_nama') }}"
                                    placeholder="tipe ram">
                                @error('ram_tipe_nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="ram_kapasitas">
                                            Kapasitas RAM
                                            <small class="text-muted">(satuan: GigaBytes)</small>
                                        </label>
                                        <select
                                            class="custom-select rounded-0 @error('ram_kapasitas') is-invalid @enderror"
                                            id="ram_kapasitas" name="ram_kapasitas" onchange="set_ram_kapasitas()">
                                            <option value="">- Pilih -</option>
                                            @foreach ($ram_kapasitases as $ram_kapasitas)
                                                <option value="{{ $ram_kapasitas->keterangan }}"
                                                    {{ old('ram_kapasitas', $perangkat->ram_kapasitas) == $ram_kapasitas->keterangan ? 'selected' : '' }}>
                                                    {{ $ram_kapasitas->keterangan }} GB
                                                </option>
                                            @endforeach
                                            <option value="lainnya"
                                                {{ old('ram_kapasitas') == 'lainnya' ? 'selected' : '' }}>
                                                Lainnya</option>
                                        </select>
                                        @error('ram_kapasitas')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2" id="layout-ram-kapasitas-lainnya"
                                        style="display: none;">
                                        <input type="number"
                                            class="form-control rounded-0 @error('ram_kapasitas_nama') is-invalid @enderror"
                                            id="ram_kapasitas_nama" name="ram_kapasitas_nama"
                                            value="{{ old('ram_kapasitas_nama') }}" placeholder="kapasitas ram">
                                        @error('ram_kapasitas_nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="ram_merek">Merek RAM</label>
                                        <select class="custom-select rounded-0 @error('ram_merek') is-invalid @enderror"
                                            id="ram_merek" name="ram_merek" onchange="set_ram_merek()">
                                            <option value="">- Pilih -</option>
                                            @foreach ($ram_mereks as $ram_merek)
                                                <option value="{{ $ram_merek->keterangan }}"
                                                    {{ old('ram_merek', $perangkat->ram_merek) == $ram_merek->keterangan ? 'selected' : '' }}>
                                                    {{ $ram_merek->keterangan }}
                                                </option>
                                            @endforeach
                                            <option value="lainnya" {{ old('ram_merek') == 'lainnya' ? 'selected' : '' }}>
                                                Lainnya</option>
                                        </select>
                                        @error('ram_merek')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2" id="layout-ram-merek-lainnya" style="display: none;">
                                        <input type="text"
                                            class="form-control rounded-0 @error('ram_merek_nama') is-invalid @enderror"
                                            id="ram_merek_nama" name="ram_merek_nama"
                                            value="{{ old('ram_merek_nama') }}" placeholder="merek ram">
                                        @error('ram_merek_nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_ram_tambahan"
                                        name="is_ram_tambahan" onchange="ram_tambahan()"
                                        {{ old('is_ram_tambahan', $perangkat->is_ram_tambahan) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_ram_tambahan">
                                        RAM Tambahan
                                        <small class="text-muted">(opsional)</small>
                                    </label>
                                </div>
                            </div>
                            <div id="layout-ram-tambahan" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="ram_tambahan_kapasitas">
                                                Kapasitas RAM
                                                <small class="text-muted">(satuan: GigaBytes)</small>
                                            </label>
                                            <select
                                                class="custom-select rounded-0 @error('ram_tambahan_kapasitas') is-invalid @enderror"
                                                id="ram_tambahan_kapasitas" name="ram_tambahan_kapasitas"
                                                onchange="set_ram_tambahan_kapasitas()">
                                                <option value="">- Pilih -</option>
                                                @foreach ($ram_kapasitases as $ram_kapasitas)
                                                    <option value="{{ $ram_kapasitas->keterangan }}"
                                                        {{ old('ram_tambahan_kapasitas', $perangkat->ram_tambahan_kapasitas) == $ram_kapasitas->keterangan ? 'selected' : '' }}>
                                                        {{ $ram_kapasitas->keterangan }} GB
                                                    </option>
                                                @endforeach
                                                <option value="lainnya"
                                                    {{ old('ram_tambahan_kapasitas') == 'lainnya' ? 'selected' : '' }}>
                                                    Lainnya</option>
                                            </select>
                                            @error('ram_tambahan_kapasitas')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-2" id="layout-ram-tambahan-kapasitas-lainnya"
                                            style="display: none;">
                                            <input type="number"
                                                class="form-control rounded-0 @error('ram_tambahan_kapasitas_nama') is-invalid @enderror"
                                                id="ram_tambahan_kapasitas_nama" name="ram_tambahan_kapasitas_nama"
                                                value="{{ old('ram_tambahan_kapasitas_nama') }}"
                                                placeholder="kapasitas ram">
                                            @error('ram_tambahan_kapasitas_nama')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="ram_tambahan_merek">Merek RAM</label>
                                            <select
                                                class="custom-select rounded-0 @error('ram_tambahan_merek') is-invalid @enderror"
                                                id="ram_tambahan_merek" name="ram_tambahan_merek"
                                                onchange="set_ram_tambahan_merek()">
                                                <option value="">- Pilih -</option>
                                                @foreach ($ram_mereks as $ram_merek)
                                                    <option value="{{ $ram_merek->keterangan }}"
                                                        {{ old('ram_tambahan_merek', $perangkat->ram_tambahan_merek) == $ram_merek->keterangan ? 'selected' : '' }}>
                                                        {{ $ram_merek->keterangan }}
                                                    </option>
                                                @endforeach
                                                <option value="lainnya"
                                                    {{ old('ram_tambahan_merek') == 'lainnya' ? 'selected' : '' }}>
                                                    Lainnya</option>
                                            </select>
                                            @error('ram_tambahan_merek')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-2" id="layout-ram-tambahan-merek-lainnya"
                                            style="display: none;">
                                            <input type="text"
                                                class="form-control rounded-0 @error('ram_tambahan_merek_nama') is-invalid @enderror"
                                                id="ram_tambahan_merek_nama" name="ram_tambahan_merek_nama"
                                                value="{{ old('ram_tambahan_merek_nama') }}" placeholder="merek ram">
                                            @error('ram_tambahan_merek_nama')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label for="storage_tipe">Tipe Storage</label>
                                        <select
                                            class="custom-select rounded-0 @error('storage_tipe') is-invalid @enderror"
                                            id="storage_tipe" name="storage_tipe">
                                            <option value="">- Pilih -</option>
                                            <option value="HDD"
                                                {{ old('storage_tipe', $perangkat->storage_tipe) == 'HDD' ? 'selected' : '' }}>
                                                HDD</option>
                                            <option value="SSD"
                                                {{ old('storage_tipe', $perangkat->storage_tipe) == 'SSD' ? 'selected' : '' }}>
                                                SSD</option>
                                        </select>
                                        @error('storage_tipe')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label for="storage_kapasitas">
                                            Kapasitas Storage
                                            <small class="text-muted">(satuan: GigaBytes)</small>
                                        </label>
                                        <select
                                            class="custom-select rounded-0 @error('storage_kapasitas') is-invalid @enderror"
                                            id="storage_kapasitas" name="storage_kapasitas"
                                            onchange="set_storage_kapasitas()">
                                            <option value="">- Pilih -</option>
                                            @foreach ($storage_kapasitases as $storage_kapasitas)
                                                <option value="{{ $storage_kapasitas->keterangan }}"
                                                    {{ old('storage_kapasitas', $perangkat->storage_kapasitas) == $storage_kapasitas->keterangan ? 'selected' : '' }}>
                                                    {{ $storage_kapasitas->keterangan }} GB
                                                </option>
                                            @endforeach
                                            <option value="lainnya"
                                                {{ old('storage_kapasitas') == 'lainnya' ? 'selected' : '' }}>Lainnya
                                            </option>
                                        </select>
                                        @error('storage_kapasitas')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2" id="layout-storage-kapasitas-lainnya"
                                        style="display: none;">
                                        <input type="number"
                                            class="form-control rounded-0 @error('storage_kapasitas_nama') is-invalid @enderror"
                                            id="storage_kapasitas_nama" name="storage_kapasitas_nama"
                                            value="{{ old('storage_kapasitas_nama') }}" placeholder="kapasitas storage">
                                        @error('storage_kapasitas_nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label for="storage_merek">Merek Storage</label>
                                        <select
                                            class="custom-select rounded-0 @error('storage_merek') is-invalid @enderror"
                                            id="storage_merek" name="storage_merek" onchange="set_storage_merek()">
                                            <option value="">- Pilih -</option>
                                            @foreach ($storage_mereks as $storage_merek)
                                                <option value="{{ $storage_merek->keterangan }}"
                                                    {{ old('storage_merek', $perangkat->storage_merek) == $storage_merek->keterangan ? 'selected' : '' }}>
                                                    {{ $storage_merek->keterangan }}
                                                </option>
                                            @endforeach
                                            <option value="lainnya"
                                                {{ old('storage_merek') == 'lainnya' ? 'selected' : '' }}>Lainnya
                                            </option>
                                        </select>
                                        @error('storage_merek')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2" id="layout-storage-merek-lainnya"
                                        style="display: none;">
                                        <input type="text"
                                            class="form-control rounded-0 @error('storage_merek_nama') is-invalid @enderror"
                                            id="storage_merek_nama" name="storage_merek_nama"
                                            value="{{ old('storage_merek_nama') }}" placeholder="merek storage">
                                        @error('storage_merek_nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_storage_tambahan"
                                        name="is_storage_tambahan" onchange="storage_tambahan()"
                                        {{ old('is_storage_tambahan', $perangkat->is_storage_tambahan) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_storage_tambahan">
                                        Storage Tambahan
                                        <small class="text-muted">(opsional)</small>
                                    </label>
                                </div>
                            </div>
                            <div id="layout-storage-tambahan" style="display: none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-2">
                                            <label for="storage_tambahan_tipe">Tipe Storage</label>
                                            <select
                                                class="custom-select rounded-0 @error('storage_tambahan_tipe') is-invalid @enderror"
                                                id="storage_tambahan_tipe" name="storage_tambahan_tipe">
                                                <option value="">- Pilih -</option>
                                                <option value="HDD"
                                                    {{ old('storage_tambahan_tipe', $perangkat->storage_tambahan_tipe) == 'HDD' ? 'selected' : '' }}>
                                                    HDD
                                                </option>
                                                <option value="SSD"
                                                    {{ old('storage_tambahan_tipe', $perangkat->storage_tambahan_tipe) == 'SSD' ? 'selected' : '' }}>
                                                    SSD
                                                </option>
                                            </select>
                                            @error('storage_tambahan_tipe')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-2">
                                            <label for="storage_tambahan_kapasitas">
                                                Kapasitas Storage
                                                <small class="text-muted">(satuan: GigaBytes)</small>
                                            </label>
                                            <select
                                                class="custom-select rounded-0 @error('storage_tambahan_kapasitas') is-invalid @enderror"
                                                id="storage_tambahan_kapasitas" name="storage_tambahan_kapasitas"
                                                onchange="set_storage_tambahan_kapasitas()">
                                                <option value="">- Pilih -</option>
                                                @foreach ($storage_kapasitases as $storage_kapasitas)
                                                    <option value="{{ $storage_kapasitas->keterangan }}"
                                                        {{ old('storage_tambahan_kapasitas', $perangkat->storage_tambahan_kapasitas) == $storage_kapasitas->keterangan ? 'selected' : '' }}>
                                                        {{ $storage_kapasitas->keterangan }} GB
                                                    </option>
                                                @endforeach
                                                <option value="lainnya"
                                                    {{ old('storage_tambahan_kapasitas') == 'lainnya' ? 'selected' : '' }}>
                                                    Lainnya
                                                </option>
                                            </select>
                                            @error('storage_tambahan_kapasitas')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-2" id="layout-storage-tambahan-kapasitas-lainnya"
                                            style="display: none;">
                                            <input type="number"
                                                class="form-control rounded-0 @error('storage_tambahan_kapasitas_nama') is-invalid @enderror"
                                                id="storage_tambahan_kapasitas_nama"
                                                name="storage_tambahan_kapasitas_nama"
                                                value="{{ old('storage_tambahan_kapasitas_nama') }}"
                                                placeholder="kapasitas storage">
                                            @error('storage_tambahan_kapasitas_nama')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-2">
                                            <label for="storage_tambahan_merek">Merek Storage</label>
                                            <select
                                                class="custom-select rounded-0 @error('storage_tambahan_merek') is-invalid @enderror"
                                                id="storage_tambahan_merek" name="storage_tambahan_merek"
                                                onchange="set_storage_tambahan_merek()">
                                                <option value="">- Pilih -</option>
                                                @foreach ($storage_mereks as $storage_merek)
                                                    <option value="{{ $storage_merek->keterangan }}"
                                                        {{ old('storage_tambahan_merek', $perangkat->storage_tambahan_merek) == $storage_merek->keterangan ? 'selected' : '' }}>
                                                        {{ $storage_merek->keterangan }}
                                                    </option>
                                                @endforeach
                                                <option value="lainnya"
                                                    {{ old('storage_tambahan_merek') == 'lainnya' ? 'selected' : '' }}>
                                                    Lainnya</option>
                                            </select>
                                            @error('storage_tambahan_merek')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-2" id="layout-storage-tambahan-merek-lainnya"
                                            style="display: none;">
                                            <input type="text"
                                                class="form-control rounded-0 @error('storage_tambahan_merek_nama') is-invalid @enderror"
                                                id="storage_tambahan_merek_nama" name="storage_tambahan_merek_nama"
                                                value="{{ old('storage_tambahan_merek_nama') }}"
                                                placeholder="merek storage">
                                            @error('storage_tambahan_merek_nama')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-2">
                            <div id="layout-jenis-pc" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="psu_kapasitas">
                                                Kapasitas PSU
                                                <small>(satuan: Watt)</small>
                                            </label>
                                            <input type="number"
                                                class="form-control rounded-0 @error('psu_kapasitas') is-invalid @enderror"
                                                id="psu_kapasitas" name="psu_kapasitas"
                                                value="{{ old('psu_kapasitas', $perangkat->psu_kapasitas) }}">
                                            @error('psu_kapasitas')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="psu_merek">Merek PSU</label>
                                            <input type="text"
                                                class="form-control rounded-0 @error('psu_merek') is-invalid @enderror"
                                                id="psu_merek" name="psu_merek"
                                                value="{{ old('psu_merek', $perangkat->psu_merek) }}">
                                            @error('psu_merek')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="heatsink_model">Model Heatsink</label>
                                            <input type="text"
                                                class="form-control rounded-0 @error('heatsink_model') is-invalid @enderror"
                                                id="heatsink_model" name="heatsink_model"
                                                value="{{ old('heatsink_model', $perangkat->heatsink_model) }}">
                                            @error('heatsink_model')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="heatsink_merek">Merek Heatsink</label>
                                            <input type="text"
                                                class="form-control rounded-0 @error('heatsink_merek') is-invalid @enderror"
                                                id="heatsink_merek" name="heatsink_merek"
                                                value="{{ old('heatsink_merek', $perangkat->heatsink_merek) }}">
                                            @error('heatsink_merek')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr class="mb-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="monitor_ukuran">
                                                Ukuran Monitor
                                                <small class="text-muted">(satuan: Inch)</small>
                                            </label>
                                            <input type="number"
                                                class="form-control rounded-0 @error('monitor_ukuran') is-invalid @enderror"
                                                id="monitor_ukuran" name="monitor_ukuran"
                                                value="{{ old('monitor_ukuran', $perangkat->monitor_ukuran) }}">
                                            @error('monitor_ukuran')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="monitor_merek">Merek Monitor</label>
                                            <input type="text"
                                                class="form-control rounded-0 @error('monitor_merek') is-invalid @enderror"
                                                id="monitor_merek" name="monitor_merek"
                                                value="{{ old('monitor_merek', $perangkat->monitor_merek) }}">
                                            @error('monitor_merek')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="keyboard_merek">Merek Keyboard</label>
                                            <input type="text"
                                                class="form-control rounded-0 @error('keyboard_merek') is-invalid @enderror"
                                                id="keyboard_merek" name="keyboard_merek"
                                                value="{{ old('keyboard_merek', $perangkat->keyboard_merek) }}">
                                            @error('keyboard_merek')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="mouse_merek">Merek Mouse</label>
                                            <input type="text"
                                                class="form-control rounded-0 @error('mouse_merek') is-invalid @enderror"
                                                id="mouse_merek" name="mouse_merek"
                                                value="{{ old('mouse_merek', $perangkat->mouse_merek) }}">
                                            @error('mouse_merek')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="keterangan">
                                    Keterangan
                                    <small class="text-muted">(opsional)</small>
                                </label>
                                <textarea class="form-control rounded-0" name="keterangan" id="keterangan" cols="30" rows="4">{{ old('keterangan', $perangkat->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="pb-4 text-right">
                        <button type="submit" class="btn btn-primary btn-sm btn-flat">Simpan Perangkat</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <div class="modal fade" id="modal-karyawan">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Karyawan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-header">
                    <div class="input-group">
                        <input type="search" class="form-control rounded-0" id="keyword" name="keyword"
                            placeholder="cari karyawan">
                        <div class="input-group-append rounded-0">
                            <button type="button" class="btn btn-default btn-flat" onclick="search_karyawan()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <table id="table-karyawan" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 20px">No</th>
                                <th>Nama</th>
                                <th class="text-center" style="width: 40px">Pilih</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-karyawan">
                            @foreach ($karyawans as $key => $karyawan)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $karyawan->nama }}
                                        <hr class="my-2">
                                        {{ $karyawan->bagian->sebagai ?? '' }} {{ $karyawan->bagian->unit->nama ?? '' }}
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-flat"
                                            data-dismiss="modal" onclick="set_karyawan({{ $karyawan->id }})">
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
@endsection

@section('script')
    <script>
        $('#keyword').on('search', function() {
            search_karyawan();
        });

        function search_karyawan() {
            $('#table-karyawan').hide();
            $('#tbody-karyawan').empty();
            $('#modal-batas').hide();
            $('#modal-loading').show();
            $.ajax({
                url: "{{ url('user/perangkat/karyawan-search') }}",
                type: "GET",
                data: {
                    "keyword": $('#keyword').val(),
                },
                dataType: "json",
                success: function(data) {
                    $('#modal-loading').hide();
                    $('#table-karyawan').show();
                    if (data.length > 0) {
                        $.each(data, function(key, value) {
                            tbody_karyawan(value, (key + 1));
                        });
                        if (data.length == 10) {
                            $('#modal-batas').show();
                        }
                    } else {
                        var tbody = '<tr>';
                        tbody += '<td class="text-center" colspan="3">- Data tidak ditemukan -</td>';
                        tbody += '</tr>';
                        $('#tbody-karyawan').append(tbody);
                    }
                },
            });
        }

        function tbody_karyawan(data, no) {
            var tbody = '<tr>';
            tbody += '<td class="text-center">' + no + '</td>';
            tbody += '<td>';
            tbody += data.nama;
            tbody += '<hr class="my-2">';
            tbody += (data.bagian.sebagai ?? '') + ' ' + (data.bagian.unit.nama ?? '');
            tbody += '</td>';
            tbody += '<td class="text-center">';
            tbody +=
                '<button type="button" class="btn btn-outline-primary btn-sm btn-flat" data-dismiss="modal" onclick="set_karyawan(' +
                data.id + ')">';
            tbody += '<i class="fas fa-check"></i>';
            tbody += '</button>';
            tbody += '</td>';
            tbody += '</tr>';
            $('#tbody-karyawan').append(tbody);
        }

        function set_karyawan(id, is_old = false) {
            $.ajax({
                url: "{{ url('user/perangkat/karyawan-set') }}" + "/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#karyawan_id').empty();
                    var option = '<option value="' + data.id + '">' + data.nama + '</option>';
                    $('#karyawan_id').append(option);
                    if (!is_old) {
                        $('#unit_id').val(data.bagian.unit_id);
                    }
                },
            });
        }

        function uncheck_karyawan() {
            $('#karyawan_id').empty();
            var option = '<option value="">- Pilih -</option>';
            $('#karyawan_id').append(option);
            $('#unit_id').val("");
        }

        var karyawan_id = "{{ old('karyawan_id', $perangkat->karyawan_id) }}";
        if (karyawan_id) {
            set_karyawan(karyawan_id, true);
        }

        function set_jenis() {
            if ($('#jenis').val() == 'pc') {
                $('#layout-jenis-pc').show();
            } else {
                $('#layout-jenis-pc').hide();
                $('#psu_kapasitas').val(null);
                $('#psu_merek').val(null);
                $('#heatsink_merek').val(null);
                $('#heatsink_model').val(null);
                $('#monitor_ukuran').val(null);
                $('#monitor_merek').val(null);
                $('#keyboard_merek').val(null);
                $('#mouse_merek').val(null);
            }
        }

        var jenis = "{{ old('jenis', $perangkat->jenis) }}";
        if (jenis == 'pc') {
            set_jenis();
        }

        function set_merek() {
            if ($('#merek').val() == 'lainnya') {
                $('#layout-merek-lainnya').show();
            } else {
                $('#layout-merek-lainnya').hide();
                $('#merek_nama').val(null);
            }
        }

        var merek = "{{ old('merek') }}";
        if (merek == 'lainnya') {
            set_merek();
        }

        function set_model() {
            if ($('#model').val() == 'lainnya') {
                $('#layout-model-lainnya').show();
            } else {
                $('#layout-model-lainnya').hide();
                $('#model_nama').val(null);
            }
        }

        var model = "{{ old('model') }}";
        if (model == 'lainnya') {
            set_model();
        }

        function set_ram_tipe() {
            if ($('#ram_tipe').val() == 'lainnya') {
                $('#layout-ram-tipe-lainnya').show();
            } else {
                $('#layout-ram-tipe-lainnya').hide();
                $('#ram_tipe_nama').val(null);
            }
        }

        var ram_tipe = "{{ old('ram_tipe') }}";
        if (ram_tipe == 'lainnya') {
            set_ram_tipe();
        }

        function set_ram_kapasitas() {
            if ($('#ram_kapasitas').val() == 'lainnya') {
                $('#layout-ram-kapasitas-lainnya').show();
            } else {
                $('#layout-ram-kapasitas-lainnya').hide();
                $('#ram_kapasitas_nama').val(null);
            }
        }

        var ram_kapasitas = "{{ old('ram_kapasitas') }}";
        if (ram_kapasitas == 'lainnya') {
            set_ram_kapasitas();
        }

        function set_ram_merek() {
            if ($('#ram_merek').val() == 'lainnya') {
                $('#layout-ram-merek-lainnya').show();
            } else {
                $('#layout-ram-merek-lainnya').hide();
                $('#ram_merek_nama').val(null);
            }
        }

        var ram_merek = "{{ old('ram_merek') }}";
        if (ram_merek == 'lainnya') {
            set_ram_merek();
        }

        function ram_tambahan() {
            if ($('#is_ram_tambahan').prop('checked')) {
                $('#layout-ram-tambahan').show();
            } else {
                $('#layout-ram-tambahan').hide();
                $('#ram_tambahan_kapasitas').val(null);
                $('#ram_tambahan_merek').val(null);
            }
        }

        var is_ram_tambahan = "{{ old('is_ram_tambahan', $perangkat->is_ram_tambahan) }}";
        if (is_ram_tambahan) {
            ram_tambahan();
        }

        function set_ram_tambahan_kapasitas() {
            if ($('#ram_tambahan_kapasitas').val() == 'lainnya') {
                $('#layout-ram-tambahan-kapasitas-lainnya').show();
            } else {
                $('#layout-ram-tambahan-kapasitas-lainnya').hide();
                $('#ram_tambahan_kapasitas_nama').val(null);
            }
        }

        var ram_tambahan_kapasitas = "{{ old('ram_tambahan_kapasitas') }}";
        if (ram_tambahan_kapasitas == 'lainnya') {
            set_ram_tambahan_kapasitas();
        }

        function set_ram_tambahan_merek() {
            if ($('#ram_tambahan_merek').val() == 'lainnya') {
                $('#layout-ram-tambahan-merek-lainnya').show();
            } else {
                $('#layout-ram-tambahan-merek-lainnya').hide();
                $('#ram_tambahan_merek_nama').val(null);
            }
        }

        var ram_tambahan_merek = "{{ old('ram_tambahan_merek') }}";
        if (ram_tambahan_merek == 'lainnya') {
            set_ram_tambahan_merek();
        }

        function set_storage_kapasitas() {
            if ($('#storage_kapasitas').val() == 'lainnya') {
                $('#layout-storage-kapasitas-lainnya').show();
            } else {
                $('#layout-storage-kapasitas-lainnya').hide();
                $('#storage_kapasitas_nama').val(null);
            }
        }

        var storage_kapasitas = "{{ old('storage_kapasitas') }}";
        if (storage_kapasitas == 'lainnya') {
            set_storage_kapasitas();
        }

        function set_storage_merek() {
            if ($('#storage_merek').val() == 'lainnya') {
                $('#layout-storage-merek-lainnya').show();
            } else {
                $('#layout-storage-merek-lainnya').hide();
                $('#storage_merek_nama').val(null);
            }
        }

        var storage_merek = "{{ old('storage_merek') }}";
        if (storage_merek == 'lainnya') {
            set_storage_merek();
        }

        function storage_tambahan() {
            if ($('#is_storage_tambahan').prop('checked')) {
                $('#layout-storage-tambahan').show();
            } else {
                $('#layout-storage-tambahan').hide();
                $('#storage_tambahan_tipe').val(null);
                $('#storage_tambahan_kapasitas').val(null);
                $('#storage_tambahan_merek').val(null);
            }
        }

        var is_storage_tambahan = "{{ old('is_storage_tambahan', $perangkat->is_storage_tambahan) }}";
        if (is_storage_tambahan) {
            storage_tambahan();
        }

        function set_storage_tambahan_kapasitas() {
            if ($('#storage_tambahan_kapasitas').val() == 'lainnya') {
                $('#layout-storage-tambahan-kapasitas-lainnya').show();
            } else {
                $('#layout-storage-tambahan-kapasitas-lainnya').hide();
                $('#storage_tambahan_kapasitas_nama').val(null);
            }
        }

        var storage_tambahan_kapasitas = "{{ old('storage_tambahan_kapasitas') }}";
        if (storage_tambahan_kapasitas == 'lainnya') {
            set_storage_tambahan_kapasitas();
        }

        function set_storage_tambahan_merek() {
            if ($('#storage_tambahan_merek').val() == 'lainnya') {
                $('#layout-storage-tambahan-merek-lainnya').show();
            } else {
                $('#layout-storage-tambahan-merek-lainnya').hide();
                $('#storage_tambahan_merek_nama').val(null);
            }
        }

        var storage_tambahan_merek = "{{ old('storage_tambahan_merek') }}";
        if (storage_tambahan_merek == 'lainnya') {
            set_storage_tambahan_merek();
        }
    </script>
@endsection
