@extends('layouts.app')

@section('title', 'Anggota Unit')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Anggota Unit</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ url('admin/anggota') }}">Anggota Unit</a>
                            </li>
                            <li class="breadcrumb-item active">Ubah</li>
                        </ol>
                    </div>
                    <!-- /.col -->
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
                    <form action="{{ url('admin/anggota/' . $anggota->id) }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group mb-2">
                                <label for="nama">Nama Anggota</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Masukan nama anggota" value="{{ old('nama', $anggota->nama) }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="telp">
                                    No. Telepon
                                    <small>(08xxxxxxxx)</small>
                                </label>
                                <input type="text" id="telp" name="telp" class="form-control"
                                    placeholder="Masukan nomor telepon" value="{{ old('telp', $anggota->telp) }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="foto">Foto
                                    <small>
                                        @if ($anggota->foto != null)
                                            (kosongkan jika tidak diubah)
                                        @else
                                            (opsional)
                                        @endif
                                    </small>
                                </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="foto" name="foto"
                                        accept="image/*">
                                    <label class="custom-file-label" for="foto">Pilih Foto</label>
                                </div>
                            </div>
                            @if ($anggota->foto != null)
                                <a href="#" data-toggle="modal" data-target="#modal-foto">
                                    <img src="{{ asset('storage/uploads/' . $anggota->foto) }}" alt=""
                                        class="rounded" width="120px">
                                </a>
                            @endif
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
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
                    <img src="{{ asset('storage/uploads/' . $anggota->foto) }}" alt="" class="rounded w-100">
                </div>
                <div class="modal-footer text-end">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@endsection
