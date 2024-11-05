@extends('layouts.app')

@section('title', 'Tambah Sparepart')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a href="{{ url('user/sparepart') }}" class="btn btn-secondary btn-flat float-left mr-2">
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
                    <form action="{{ url('user/sparepart') }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="kategori">Kategori</label>
                                        <select class="custom-select rounded-0" name="kategori" id="kategori">
                                            <option value="">- Pilih -</option>
                                            <option value="motherboard">Motherboard</option>
                                            <option value="prosesor">Prosesor</option>
                                            <option value="ram">RAM</option>
                                            <option value="storage">Storage</option>
                                            <option value="psu">PSU</option>
                                            <option value="heatsink">Heatsink</option>
                                            <option value="monitor">Monitor</option>
                                            <option value="keyboard">Keyboard</option>
                                            <option value="mouse">Mouse</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control rounded-0" id="nama" name="nama"
                                            value="{{ old('nama') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="tipe">Tipe</label>
                                        <input type="text" class="form-control rounded-0" id="tipe" name="tipe"
                                            value="{{ old('tipe') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="kapasitas">Kapasitas</label>
                                        <input type="text" class="form-control rounded-0" id="kapasitas" name="kapasitas"
                                            value="{{ old('kapasitas') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="merek">Merek</label>
                                        <input type="text" class="form-control rounded-0" id="merek" name="merek"
                                            value="{{ old('merek') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="model">Model</label>
                                        <input type="text" class="form-control rounded-0" id="model" name="model"
                                            value="{{ old('model') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="tanggal">Tanggal</label>
                                <input type="text" class="form-control rounded-0" id="tanggal" name="tanggal"
                                    value="{{ old('tanggal') }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="garansi">Garansi</label>
                                <input type="text" class="form-control rounded-0" id="garansi" name="garansi"
                                    value="{{ old('garansi') }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="file">File</label>
                                <input type="file" class="form-control rounded-0" id="file" name="file"
                                    accept="application/pdf">
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
