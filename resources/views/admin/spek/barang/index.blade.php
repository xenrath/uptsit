@extends('layouts.app')

@section('title', 'Spesifikasi Barang')

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
                        <h1 class="m-0">Spesifikasi Barang</h1>
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
                        <h3 class="card-title">Spesifikasi Barang</h3>
                        <div class="float-right">
                            <button type="button" class="btn btn-primary btn-sm btn-flat" data-toggle="modal"
                                data-target="#modal-tambah">Tambah</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 20px">No</th>
                                    <th>Nama</th>
                                    <th class="text-center" style="width: 100px">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($spek_barangs as $spek_barang)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $spek_barang->nama }}
                                            <br class="d-block d-lg-none">
                                            <span class="text-muted">({{ ucfirst($spek_barang->kategori) }})</span>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning btn-sm btn-flat mb-2"
                                                data-toggle="modal" data-target="#modal-edit-{{ $spek_barang->id }}">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm btn-flat mb-2"
                                                data-toggle="modal"
                                                data-target="#modal-hapus-{{ $spek_barang->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-edit-{{ $spek_barang->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Spesifikasi</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form
                                                    action="{{ url('admin/spek-barang/' . $spek_barang->id) }}"
                                                    method="POST" autocomplete="off">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group mb-2">
                                                            <label for="kategori">Kategori</label>
                                                            <select
                                                                class="form-control rounded-0
                                                                @if (session('id') == $spek_barang->id) @error('kategori') is-invalid @enderror @endif"
                                                                id="kategori" name="kategori">
                                                                <option value="">- Pilih -</option>
                                                                <option value="jenis"
                                                                    {{ $spek_barang->kategori == 'jenis' ? 'selected' : '' }}>
                                                                    Jenis</option>
                                                                <option value="merek"
                                                                    {{ $spek_barang->kategori == 'merek' ? 'selected' : '' }}>
                                                                    Merek</option>
                                                                <option value="model"
                                                                    {{ $spek_barang->kategori == 'model' ? 'selected' : '' }}>
                                                                    Model</option>
                                                            </select>
                                                            @if (session('id') == $spek_barang->id)
                                                                @error('kategori')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            @endif
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label for="nama">Nama Spesifikasi</label>
                                                            <input type="text"
                                                                class="form-control rounded-0  @if (session('id') == $spek_barang->id) @error('nama') is-invalid @enderror @endif"
                                                                id="nama" name="nama"
                                                                value="{{ $spek_barang->nama }}">
                                                            @error('nama')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default btn-sm btn-flat"
                                                            data-dismiss="modal">Batal</button>
                                                        <button type="submit"
                                                            class="btn btn-primary btn-sm btn-flat">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="modal-hapus-{{ $spek_barang->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Spesifikasi</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin hapus spesifikasi barang
                                                        <strong>{{ $spek_barang->nama }}</strong>?
                                                    </p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default btn-sm btn-flat"
                                                        data-dismiss="modal">Batal</button>
                                                    <form
                                                        action="{{ url('admin/spek-barang/' . $spek_barang->id) }}"
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </section>
        <!-- /.card -->
    </div>
    <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Spesifikasi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/spek-barang') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="kategori">Kategori</label>
                            <select class="form-control rounded-0 @error('kategori') is-invalid @enderror" id="kategori"
                                name="kategori">
                                <option value="">- Pilih -</option>
                                <option value="jenis" {{ old('kategori') == 'jenis' ? 'selected' : '' }}>Jenis</option>
                                <option value="merek" {{ old('kategori') == 'merek' ? 'selected' : '' }}>Merek</option>
                                <option value="model" {{ old('kategori') == 'model' ? 'selected' : '' }}>Model</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="nama">Nama Spesifikasi</label>
                            <input type="text" class="form-control rounded-0 @error('nama') is-invalid @enderror"
                                id="nama" name="nama" value="{{ old('nama') }}">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm btn-flat"
                            data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-flat">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
