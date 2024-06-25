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
                        <h1>Anggota Unit</h1>
                    </div><!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5>Error!</h5>
                        <ul class="px-4">
                            @foreach (session('error') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ubah User</h3>
                    </div>
                    <!-- /.card-header -->
                    <form action="{{ url('admin/user/' . $user->id) }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group mb-2">
                                <label for="nama">Nama Anggota</label>
                                <input type="text" class="form-control rounded-0 @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" placeholder="Masukan nama user"
                                    value="{{ old('nama', $user->nama) }}">
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="telp">
                                    No. Telepon
                                    <small>(08xxxxxxxx)</small>
                                </label>
                                <input type="text" id="telp" name="telp"
                                    class="form-control rounded-0 @error('telp') is-invalid @enderror"
                                    placeholder="Masukan nomor telepon" value="{{ old('telp', $user->telp) }}">
                                @error('telp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="bagian">Bagian</label>
                                <select class="custom-select rounded-0 @error('bagian') is-invalid @enderror"
                                    id="bagian" name="bagian">
                                    <option value="">- Pilih -</option>
                                    <option value="programmer"
                                        {{ old('bagian', $user->bagian) == 'programmer' ? 'selected' : '' }}>
                                        Staf Programmer</option>
                                    <option value="jaringan"
                                        {{ old('bagian', $user->bagian) == 'jaringan' ? 'selected' : '' }}>Staf
                                        Jaringan
                                        Komputer dan Umum</option>
                                    <option value="support"
                                        {{ old('bagian', $user->bagian) == 'support' ? 'selected' : '' }}>Staf IT
                                        Support
                                    </option>
                                </select>
                                @error('bagian')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="foto">Foto
                                    <small>
                                        @if ($user->foto != null)
                                            (kosongkan jika tidak diubah | rekomendasi ukuran 400x550)
                                        @else
                                            (opsional | rekomendasi ukuran 400x550)
                                        @endif
                                    </small>
                                </label>
                                <input type="file" class="form-control rounded-0 @error('foto') is-invalid @enderror"
                                    id="foto" name="foto" accept="image/*">
                                @error('foto')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            @if ($user->foto != null)
                                <div class="mb-2">
                                    <a href="#" data-toggle="modal" data-target="#modal-foto">
                                        <img src="{{ asset('storage/uploads/' . $user->foto) }}" alt=""
                                            class="rounded-0" width="120px">
                                    </a>
                                </div>
                            @endif
                            <div class="form-group mb-2">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_petugas" name="is_petugas"
                                        {{ $user->is_petugas ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_petugas">Jadikan Petugas CBT</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-warning btn-sm btn-flat" data-toggle="modal"
                                data-target="#modal-reset">Reset Password</button>
                            <button type="submit" class="btn btn-primary btn-sm btn-flat float-right">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="modal-foto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Lihat Foto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('storage/uploads/' . $user->foto) }}" alt="" class="rounded-0 w-100">
                </div>
                <div class="modal-footer text-end">
                    <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-reset">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reset Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Yakin reset password <strong>{{ $user->nama }}</strong>?</p>
                    <small class="text-muted">Password akan direset menjadi <strong>bhamada</strong>.</small>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Batal</button>
                    <form action="{{ url('admin/user/reset/' . $user->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm btn-flat">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
