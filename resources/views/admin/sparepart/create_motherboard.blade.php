@extends('layouts.app')

@section('title', 'Tambah Sparepart')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a href="{{ url('admin/sparepart') }}" class="btn btn-secondary btn-flat float-left mr-2">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1 class="m-0">Tambah Sparepart</h1>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form Sparepart</h3>
                    </div>
                    <!-- /.card-header -->
                    <form action="{{ url('admin/sparepart/motherboard') }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="kategori">Kategori</label>
                                        <input type="text" class="form-control rounded-0" value="Motherboard" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="merek">Merek</label>
                                        <select class="custom-select rounded-0 @error('merek') is-invalid @enderror"
                                            name="merek" id="merek" onchange="set_merek()">
                                            <option value="">- Pilih -</option>
                                            @foreach ($motherboard_mereks as $motherboard_merek)
                                                <option value="{{ $motherboard_merek->keterangan }}"
                                                    {{ old('merek') == $motherboard_merek->keterangan ? 'selected' : '' }}>
                                                    {{ $motherboard_merek->keterangan }}
                                                </option>
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
                                        <label for="model">Model Prosesor</label>
                                        <select class="custom-select rounded-0 @error('model') is-invalid @enderror"
                                            name="model" id="model" onchange="set_model()">
                                            <option value="">- Pilih -</option>
                                            @foreach ($prosesor_models as $prosesor_model)
                                                <option value="{{ $prosesor_model->keterangan }}"
                                                    {{ old('model') == $prosesor_model->keterangan ? 'selected' : '' }}>
                                                    {{ $prosesor_model->keterangan }}</option>
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
                                            placeholder="nama model prosesor">
                                        @error('model_nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="tipe">Tipe RAM</label>
                                        <select class="custom-select rounded-0 @error('tipe') is-invalid @enderror"
                                            name="tipe" id="tipe" onchange="set_tipe()">
                                            <option value="">- Pilih -</option>
                                            @foreach ($ram_tipes as $ram_tipe)
                                                <option value="{{ $ram_tipe->keterangan }}"
                                                    {{ old('tipe') == $ram_tipe->keterangan ? 'selected' : '' }}>
                                                    {{ $ram_tipe->keterangan }}
                                                </option>
                                            @endforeach
                                            <option value="lainnya" {{ old('tipe') == 'lainnya' ? 'selected' : '' }}>
                                                Lainnya</option>
                                        </select>
                                        @error('tipe')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2" id="layout-tipe-lainnya" style="display: none;">
                                        <input type="text"
                                            class="form-control rounded-0 @error('tipe_nama') is-invalid @enderror"
                                            id="tipe_nama" name="tipe_nama" value="{{ old('tipe_nama') }}"
                                            placeholder="nama tipe ram">
                                        @error('tipe_nama')
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
                                        <label for="jumlah">Jumlah Barang</label>
                                        <input type="number"
                                            class="form-control rounded-0 @error('jumlah') is-invalid @enderror"
                                            id="jumlah" name="jumlah" value="{{ old('jumlah', '1') }}">
                                        @error('jumlah')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_baru" name="is_baru"
                                        onchange="baru()" {{ old('is_baru') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_baru">
                                        Pembelian Baru
                                        <small class="text-muted">(opsional)</small>
                                    </label>
                                </div>
                            </div>
                            <div id="layout-baru" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="tanggal">Tanggal Pembelian</label>
                                            <input type="date"
                                                class="form-control rounded-0 @error('tanggal') is-invalid @enderror"
                                                id="tanggal" name="tanggal" value="{{ old('tanggal') }}">
                                            @error('tanggal')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="garansi">
                                                Garansi
                                                <small class="text-muted">(bulan)</small>
                                            </label>
                                            <input type="number"
                                                class="form-control rounded-0 @error('garansi') is-invalid @enderror"
                                                id="garansi" name="garansi" value="{{ old('garansi') }}">
                                            @error('garansi')
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
                                            <label for="bukti">Bukti Garansi</label>
                                            <input type="file"
                                                class="form-control rounded-0 @error('bukti') is-invalid @enderror"
                                                id="bukti" name="bukti" accept="image/*">
                                            @error('bukti')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="foto">Foto Barang</label>
                                            <input type="file"
                                                class="form-control rounded-0 @error('foto') is-invalid @enderror"
                                                id="foto" name="foto" accept="image/*">
                                            @error('foto')
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
                                <textarea class="form-control rounded-0" rows="4" id="keterangan" name="keterangan">{{ old('keterangan') }}</textarea>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary btn-sm btn-flat">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
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

        function set_tipe() {
            if ($('#tipe').val() == 'lainnya') {
                $('#layout-tipe-lainnya').show();
            } else {
                $('#layout-tipe-lainnya').hide();
                $('#tipe_nama').val(null);
            }
        }

        var tipe = "{{ old('tipe') }}";
        if (tipe == 'lainnya') {
            set_tipe();
        }

        function baru() {
            if ($('#is_baru').prop('checked')) {
                $('#layout-baru').show();
            } else {
                $('#layout-baru').hide();
            }
        }

        var is_baru = "{{ old('is_baru') }}";
        if (is_baru) {
            baru();
        }
    </script>
@endsection
