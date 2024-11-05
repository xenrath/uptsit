@extends('layouts.app')

@section('title', 'Edit Sparepart')

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
                        <h1 class="m-0">Edit Sparepart</h1>
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
                    <form action="{{ url('admin/sparepart/keyboard/' . $sparepart->id) }}" method="post"
                        enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="kategori">Kategori</label>
                                        <input type="text" class="form-control rounded-0" value="Keyboard" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="merek">Merek</label>
                                        <input type="text"
                                            class="form-control rounded-0 @error('merek') is-invalid @enderror"
                                            id="merek" name="merek" value="{{ old('merek', $sparepart->merek) }}">
                                        @error('merek')
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
                                            id="jumlah" name="jumlah" value="{{ old('jumlah', $sparepart->jumlah) }}">
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
                                        onchange="baru()" {{ old('is_baru', $sparepart->is_baru) ? 'checked' : '' }}>
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
                                                id="tanggal" name="tanggal"
                                                value="{{ old('tanggal', $sparepart->tanggal) }}">
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
                                                id="garansi" name="garansi"
                                                value="{{ old('garansi', $sparepart->garansi) }}">
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
                                            <label for="bukti">
                                                Bukti Garansi
                                                @if ($sparepart->bukti)
                                                    <small class="text-muted">(kosongkan jika tidak ingin diubah)</small>
                                                @endif
                                            </label>
                                            <input type="file"
                                                class="form-control rounded-0 @error('bukti') is-invalid @enderror"
                                                id="bukti" name="bukti" accept="image/*">
                                            @error('bukti')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            @if ($sparepart->bukti)
                                                <button type="button" class="btn btn-info btn-xs btn-flat mt-2 float-right"
                                                    data-toggle="modal" data-target="#modal-bukti">
                                                    Lihat Bukti Garansi
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="foto">
                                                Foto Barang
                                                @if ($sparepart->foto)
                                                    <small class="text-muted">(kosongkan jika tidak ingin diubah)</small>
                                                @endif
                                            </label>
                                            <input type="file"
                                                class="form-control rounded-0 @error('foto') is-invalid @enderror"
                                                id="foto" name="foto" accept="image/*">
                                            @error('foto')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            @if ($sparepart->foto)
                                                <button type="button"
                                                    class="btn btn-info btn-xs btn-flat mt-2 float-right"
                                                    data-toggle="modal" data-target="#modal-foto">
                                                    Lihat Foto Barang
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="keterangan">
                                    Keterangan
                                    <small class="text-muted">(opsional)</small>
                                </label>
                                <textarea class="form-control rounded-0" rows="4" id="keterangan" name="keterangan">{{ old('keterangan', $sparepart->keterangan) }}</textarea>
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
    @if ($sparepart->bukti)
        <div class="modal fade" id="modal-bukti">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Bukti Garansi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ asset('storage/uploads/' . $sparepart->bukti) }}" alt="Bukti Garansi"
                            class="w-100 rounded">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm btn-flat"
                            data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($sparepart->foto)
        <div class="modal fade" id="modal-foto">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Foto Barang</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ asset('storage/uploads/' . $sparepart->foto) }}" alt="Foto Barang"
                            class="w-100 rounded">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm btn-flat"
                            data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    <script>
        function baru() {
            if ($('#is_baru').prop('checked')) {
                $('#layout-baru').show();
            } else {
                $('#layout-baru').hide();
            }
        }

        var is_baru = "{{ old('is_baru', $sparepart->is_baru) }}";
        if (is_baru) {
            baru();
        }
    </script>
@endsection
