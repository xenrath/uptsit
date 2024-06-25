@extends('layouts.app')

@section('title', 'Tupoksi Unit')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a href="{{ url('admin/tupoksi') }}" class="btn btn-secondary btn-flat float-left mr-2">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1 class="m-0">Tupoksi Unit</h1>
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
                        <h3 class="card-title">Tambah Tupoksi</h3>
                    </div>
                    <!-- /.card-header -->
                    <form action="{{ url('admin/tupoksi') }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        <div class="card-body">
                            <div class="form-group mb-2">
                                <label for="nama">Nama Tupoksi</label>
                                <input type="text" class="form-control rounded-0" id="nama" name="nama"
                                    value="{{ old('nama') }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control rounded-0" rows="4" name="deskripsi">{{ old('deskripsi') }}</textarea>
                            </div>
                            <div class="form-group mb-2">
                                <label for="icon">
                                    Ikon
                                    <small>
                                        (contoh: ti-user | referensi <a href="https://themify.me/themify-icons"
                                            target="_blank">themify icons</a>)
                                    </small>
                                </label>
                                <input type="text" class="form-control rounded-0" id="icon" name="icon"
                                    value="{{ old('icon') }}">
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
