@extends('layouts.app')

@section('title', 'Anggota Unit')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Anggota Unit</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ url('admin/anggota') }}">Anggota Unit</a>
                            </li>
                            <li class="breadcrumb-item active">Tambah</li>
                        </ol>
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
                        <h3 class="card-title">Tambah User</h3>
                    </div>
                    <!-- /.card-header -->
                    <form action="{{ url('admin/anggota') }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        <div class="card-body">
                            <div class="form-group mb-2">
                                <label for="nama">Nama Anggota</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="{{ old('nama') }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="telp">
                                    No. Telepon
                                    <small>(08xxxxxxxx)</small>
                                </label>
                                <input type="text" id="telp" name="telp" class="form-control"
                                    value="{{ old('telp') }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="foto">Foto
                                    <small>(opsional)</small>
                                </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="foto" name="foto"
                                        accept="image/*">
                                    <label class="custom-file-label" for="foto">Pilih Foto</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
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
