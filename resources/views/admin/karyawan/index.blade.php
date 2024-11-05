@extends('layouts.app')

@section('title', 'Data Karyawan')

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
                        <h1 class="m-0">Data Karyawan</h1>
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
                        <h3 class="card-title">Data Karyawan</h3>
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
                                @forelse ($karyawans as $key => $karyawan)
                                    <tr>
                                        <td class="text-center">{{ $karyawans->firstItem() + $key }}</td>
                                        <td>
                                            @if ($karyawan->telp)
                                                <a href="{{ url('admin/hubungi/' . $karyawan->telp) }}" target="_blank">
                                                    {{ $karyawan->nama }}
                                                </a>
                                            @else
                                                {{ $karyawan->nama }}
                                            @endif
                                            <hr class="my-2">
                                            {{ $karyawan->bagian->sebagai ?? '' }} {{ $karyawan->bagian->unit->nama ?? '' }}
                                        </td>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning btn-sm btn-flat"
                                                data-toggle="modal" data-target="#modal-edit-{{ $karyawan->id }}">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm btn-flat"
                                                data-toggle="modal" data-target="#modal-hapus-{{ $karyawan->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-edit-{{ $karyawan->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Karyawan</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ url('admin/karyawan/' . $karyawan->id) }}" method="POST"
                                                    autocomplete="off">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group mb-2">
                                                            <label for="nama">Nama Karyawan</label>
                                                            <input type="text"
                                                                class="form-control rounded-0 @if (session('id') == $karyawan->id) @error('nama') is-invalid @enderror @endif"
                                                                id="nama" name="nama"
                                                                value="{{ $karyawan->nama }}">
                                                            @if (session('id') == $karyawan->id)
                                                                @error('nama')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            @endif
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label for="telp">
                                                                No. Telepon
                                                                <small>(08xxxxxxxxxx)</small>
                                                            </label>
                                                            <input type="tel" id="telp" name="telp"
                                                                class="form-control rounded-0 @if (session('id') == $karyawan->id) @error('telp') is-invalid @enderror @endif"
                                                                value="{{ $karyawan->telp }}">
                                                            @if (session('id') == $karyawan->id)
                                                                @error('telp')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            @endif
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label for="bagian_id">Bagian</label>
                                                            <select
                                                                class="form-control custom-select rounded-0 @if (session('id') == $karyawan->id) @error('bagian_id') is-invalid @enderror @endif"
                                                                name="bagian_id" id="bagian_id">
                                                                <option value="">- Pilih -</option>
                                                                @foreach ($bagians as $bagian)
                                                                    <option value="{{ $bagian->id }}"
                                                                        {{ $karyawan->bagian_id == $bagian->id ? 'selected' : '' }}>
                                                                        {{ $bagian->sebagai }}
                                                                        {{ $bagian->unit->nama ?? '' }}</option>
                                                                @endforeach
                                                            </select>
                                                            @if (session('id') == $karyawan->id)
                                                                @error('bagian_id')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            @endif
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
                                    <div class="modal fade" id="modal-hapus-{{ $karyawan->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Karyawan</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin hapus karyawan <strong>{{ $karyawan->nama }}</strong>?</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default btn-sm btn-flat"
                                                        data-dismiss="modal">Batal</button>
                                                    <form action="{{ url('admin/karyawan/' . $karyawan->id) }}"
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
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="3">- Data tidak ditemukan -</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if ($karyawans->total() > 10)
                            <div class="mt-4">
                                <div class="pagination float-right">
                                    {{ $karyawans->appends(Request::all())->onEachSide(1)->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @endif
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
                    <h4 class="modal-title">Tambah Karyawan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/karyawan') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="nama">Nama Karyawan</label>
                            <input type="text"
                                class="form-control rounded-0 @if (!session('id')) @error('nama') is-invalid @enderror @endif"
                                id="nama" name="nama" value="{{ old('nama') }}">
                            @if (!session('id'))
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif
                        </div>
                        <div class="form-group mb-2">
                            <label for="telp">
                                No. Telepon
                                <small>(08xxxxxxxxxx)</small>
                            </label>
                            <input type="tel" id="telp" name="telp"
                                class="form-control rounded-0 @if (!session('id')) @error('telp') is-invalid @enderror @endif"
                                value="{{ old('telp') }}">
                            @if (!session('id'))
                                @error('telp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif
                        </div>
                        <div class="form-group mb-2">
                            <label for="bagian_id">Bagian</label>
                            <select
                                class="form-control custom-select rounded-0 @if (!session('id')) @error('bagian_id') is-invalid @enderror @endif"
                                name="bagian_id" id="bagian_id">
                                <option value="">- Pilih -</option>
                                @foreach ($bagians as $bagian)
                                    <option value="{{ $bagian->id }}"
                                        {{ old('bagian_id') == $bagian->id ? 'selected' : '' }}>{{ $bagian->sebagai }}
                                        {{ $bagian->unit->nama ?? '' }}</option>
                                @endforeach
                            </select>
                            @if (!session('id'))
                                @error('bagian_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif
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
