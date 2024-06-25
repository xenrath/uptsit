@extends('layouts.app')

@section('title', 'Tupoksi Unit')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Tupoksi Unit</h1>
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
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5>
                            <i class="icon fas fa-check"></i> Success!
                        </h5>
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Tupoksi</h3>
                        <div class="float-right">
                            <a href="{{ url('admin/tupoksi/create') }}" class="btn btn-primary btn-sm btn-flat">
                                Tambah
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 10px">No</th>
                                    <th>Nama</th>
                                    <th class="text-center" style="width: 40px">File</th>
                                    <th class="text-center" style="width: 100px">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tupoksis as $tupoksi)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $tupoksi->nama }}</td>
                                        <td class="text-center">
                                            <a href="{{ asset('storage/uploads/' . $tupoksi->file) }}"
                                                class="btn btn-info btn-sm btn-flat" target="_blank">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('admin/tupoksi/' . $tupoksi->id . '/edit') }}"
                                                class="btn btn-warning btn-sm btn-flat mb-2">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button type="submit" class="btn btn-danger btn-sm btn-flat mb-2"
                                                data-toggle="modal" data-target="#modal-hapus-{{ $tupoksi->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-hapus-{{ $tupoksi->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Tupoksi</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin hapus tupoksi <strong>{{ $tupoksi->nama }}</strong>?</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default btn-sm btn-flat"
                                                        data-dismiss="modal">Batal</button>
                                                    <form action="{{ url('admin/tupoksi/' . $tupoksi->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger btn-sm btn-flat">Hapus</button>
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
@endsection
