@extends('layouts.app')

@section('title', 'Anggota Unit')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a href="{{ url('admin/user') }}" class="btn btn-secondary btn-flat float-left mr-2">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1 class="m-0">Anggota Unit</h1>
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
                        <h3 class="card-title">Tambah User</h3>
                    </div>
                    <!-- /.card-header -->
                    <form action="{{ url('admin/user') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="card-body">
                            <div class="form-group mb-2">
                                <label for="nama">Nama Anggota</label>
                                <input type="text" class="form-control rounded-0 @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" value="{{ old('nama') }}">
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="telp">
                                    No. Telepon
                                    <small>(08xxxxxxxxxx)</small>
                                </label>
                                <input type="tel" id="telp" name="telp"
                                    class="form-control rounded-0 @error('telp') is-invalid @enderror"
                                    value="{{ old('telp') }}">
                                @error('telp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="bagian">Bagian</label>
                                <select class="custom-select rounded-0 @error('bagian') is-invalid @enderror" id="bagian"
                                    name="bagian">
                                    <option value="">- Pilih -</option>
                                    <option value="programmer" {{ old('bagian') == 'programmer' ? 'selected' : '' }}>
                                        Staf Programmer</option>
                                    <option value="jaringan" {{ old('bagian') == 'jaringan' ? 'selected' : '' }}>
                                        Staf Jaringan Komputer dan Umum</option>
                                    <option value="support" {{ old('bagian') == 'support' ? 'selected' : '' }}>
                                        Staf IT Support</option>
                                </select>
                                @error('bagian')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="foto">Foto
                                    <small>(opsional | rekomendasi ukuran 400x550)</small>
                                </label>
                                <input type="file" class="form-control rounded-0 @error('foto') is-invalid @enderror"
                                    id="foto" name="foto" accept="image/*">
                                @error('foto')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <br>
                            <small class="text-muted">Password default anggota baru : <strong>bhamada</strong></small>
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
