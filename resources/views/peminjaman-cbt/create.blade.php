@extends('peminjaman-cbt.app')

@section('title', 'Buat Peminjaman CBT')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <a href="{{ url('/') }}" class="btn btn-secondary btn-flat float-left mr-2">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1>Peminjaman CBT</h1>
                    </div>
                    <div class="col-sm-6 mb-2">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item">
                                <a href="{{ url('peminjaman-cbt') }}" style="text-decoration: underline;"
                                    target="_blank">List
                                    Peminjaman</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5>Gagal!</h5>
                        <ul class="pl-4 pr-2 mb-0">
                            <li>{{ session('error') }}</li>
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Form Peminjaman</h3>
                            </div>
                            <form action="{{ url('peminjaman-cbt') }}" method="post" autocomplete="off">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group mb-2">
                                        <label for="keperluan">Keperluan Peminjaman</label>
                                        <select class="custom-select rounded-0" id="keperluan" name="keperluan">
                                            <option value="pembelajaran"
                                                {{ old('keperluan') == 'pembelajaran' ? 'selected' : '' }}>
                                                Pembelajaran Kuliah</option>
                                            <option value="lainnya" {{ old('keperluan') == 'lainnya' ? 'selected' : '' }}>
                                                Peminjaman Lainnya
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary btn-flat">Selanjutnya</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session('cek'))
        <div class="modal fade show" id="modal-cek">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Peminjaman CBT</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="text-danger">
                            <strong>GAGAL!</strong>
                        </h4>
                        <p>
                            Ruang CBT tanggal
                            <strong>{{ Carbon\Carbon::parse(old('tanggal'))->translatedFormat('d F') }}</strong>
                            jam
                            <strong>{{ old('jam_awal') }}-{{ old('jam_akhir') }}</strong>
                            tidak dapat dipinjam.
                        </p>
                        @foreach (session('cek') as $cek)
                            <div class="border rounded mb-2 p-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Nama Peminjam</strong>
                                    </div>
                                    <div class="col-md-6">
                                        {{ $cek->nama }}
                                        <span class="text-muted">({{ $cek->prodi->nama }})</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Waktu</strong>
                                    </div>
                                    <div class="col-md-6">
                                        {{ Carbon\Carbon::parse(old('tanggal'))->translatedFormat('d F') }},
                                        {{ $cek->jam_awal }}-{{ $cek->jam_akhir }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Uraian Kegiatan</strong>
                                    </div>
                                    <div class="col-md-6">
                                        {{ $cek->keterangan }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Penanggung Jawab</strong>
                                    </div>
                                    <div class="col-md-6">
                                        {{ $cek->pj }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <span class="text-muted">Lakukan pergantian jadwal atau konfirmasi pada pihak terkait.</span>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button type="button" class="btn btn-default btn-sm btn-flat"
                            data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
