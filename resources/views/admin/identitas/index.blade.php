@extends('layouts.app')

@section('title', 'Identitas Unit')

@section('loader')
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('storage/uploads/unit/logo.png') }}" alt="Admin SIT" height="80"
            width="80" style="border-radius: 50%">
    </div>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Identitas Unit</h1>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <section class="content">
            <div class="container-fluid">
                <form action="{{ url('admin/identitas/update') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Identitas Unit</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-group mb-2">
                                        <label for="nama">Nama Unit</label>
                                        <input type="text"
                                            class="form-control rounded-0 @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" placeholder="Masukan nama unit"
                                            value="{{ old('nama', $identitas->nama) }}">
                                        @error('nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="deskripsi">Deskripsi</label>
                                        <textarea class="form-control rounded-0" name="deskripsi" rows="4">{{ old('deskripsi', $identitas->deskripsi) }}</textarea>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="sistem">Jumlah Sistem</label>
                                        <input type="number" class="form-control rounded-0" id="sistem" name="sistem"
                                            placeholder="Masukan jumlah sistem"
                                            value="{{ old('sistem', $identitas->sistem) }}">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="website">Jumlah Website</label>
                                        <input type="number" class="form-control rounded-0" id="website" name="website"
                                            placeholder="Masukan jumlah website"
                                            value="{{ old('website', $identitas->website) }}">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="ap">Jumlah Akses Point</label>
                                        <input type="number" class="form-control rounded-0" id="ap" name="ap"
                                            placeholder="Masukan jumlah akses point"
                                            value="{{ old('ap', $identitas->ap) }}">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control rounded-0" id="email" name="email"
                                            placeholder="Masukan email unit" value="{{ old('email', $identitas->email) }}">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="telp">Telepon Unit</label>
                                        <input type="text" class="form-control rounded-0" id="telp" name="telp"
                                            placeholder="Masukan nomor telepon unit"
                                            value="{{ old('telp', $identitas->telp) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Visi Misi Unit</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-group mb-2">
                                        <label for="visi">Visi</label>
                                        <textarea class="form-control rounded-0" id="visi" name="visi" rows="3">{{ old('visi', $identitas->visi) }}</textarea>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="misi">Misi</label>
                                        @foreach ($identitas->misi as $misi)
                                            <textarea class="form-control rounded-0 mb-2" id="visi" name="visi" rows="2">{{ $misi }}</textarea>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right pb-4">
                        <button type="submit" class="btn btn-primary btn-sm btn-flat">Simpan Identitas</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
