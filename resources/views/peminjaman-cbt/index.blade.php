@extends('peminjaman-cbt.app')

@section('title', 'Peminjaman CBT')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <a href="{{ url('peminjaman-cbt/create') }}" class="btn btn-secondary btn-flat float-left mr-2">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1>List Peminjaman CBT</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Peminjaman</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row justify-content-end">
                                    <div class="col-md-4">
                                        <form action="{{ url('peminjaman-cbt') }}" method="get">
                                            <div class="input-group mb-3">
                                                <input type="date" class="form-control rounded-0" name="tanggal"
                                                    min="{{ date('Y-m-d') }}"
                                                    value="{{ request()->get('tanggal') ?? date('Y-m-d') }}">
                                                <span class="input-group-append">
                                                    <button type="submit" class="btn btn-primary btn-flat">Cari</button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 20px">No</th>
                                                <th>Nama Peminjam</th>
                                                <th>Waktu</th>
                                                <th class="text-center" style="width: 60px">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($peminjaman_cbts as $peminjaman_cbt)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>
                                                        {{ $peminjaman_cbt->nama }} <br>
                                                        @if ($peminjaman_cbt->keperluan == 'pembelajaran')
                                                            <small
                                                                class="text-muted">({{ $peminjaman_cbt->prodi->nama }})</small>
                                                        @endif
                                                    </td>
                                                    <td style="white-space: nowrap;">
                                                        @if ($peminjaman_cbt->tanggal_awal == $peminjaman_cbt->tanggal_akhir)
                                                            {{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_awal)->translatedFormat('d F') }}
                                                        @else
                                                            {{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_awal)->translatedFormat('d F') }}-{{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_akhir)->translatedFormat('d F') }}
                                                        @endif
                                                        <br>
                                                        {{ $peminjaman_cbt->jam_awal }}-{{ $peminjaman_cbt->jam_akhir }}
                                                        <br class="d-block d-md-none">
                                                        @php
                                                            $tanggal = Carbon\Carbon::now()->format('Y-m-d');
                                                            $jam = Carbon\Carbon::now()->format('H:i');
                                                        @endphp
                                                        @if (
                                                            $tanggal >= $peminjaman_cbt->tanggal_awal &&
                                                                $tanggal <= $peminjaman_cbt->tanggal_akhir &&
                                                                $jam >= $peminjaman_cbt->jam_awal &&
                                                                $jam <= $peminjaman_cbt->jam_akhir)
                                                            <span class="badge badge-primary">Aktif</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-info btn-sm btn-flat"
                                                            data-toggle="modal"
                                                            data-target="#modal-detail-{{ $peminjaman_cbt->id }}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="modal-detail-{{ $peminjaman_cbt->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Detail Peminjaman</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-2">
                                                                    <div class="col-md-6">
                                                                        <strong>Nama Peminjam</strong>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        {{ $peminjaman_cbt->nama }} <br>
                                                                        @if ($peminjaman_cbt->keperluan == 'pembelajaran')
                                                                            <small
                                                                                class="text-muted">({{ $peminjaman_cbt->prodi->nama }})</small>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-md-6">
                                                                        <strong>Keperluan</strong>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        @if ($peminjaman_cbt->keperluan == 'pembelajaran')
                                                                            Pembelajaran Kuliah
                                                                        @elseif ($peminjaman_cbt->keperluan == 'lainnya')
                                                                            Peminjaman Lainnya
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-md-6">
                                                                        <strong>Waktu</strong>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        @if ($peminjaman_cbt->tanggal_awal == $peminjaman_cbt->tanggal_akhir)
                                                                            {{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_awal)->translatedFormat('d F') }}
                                                                        @else
                                                                            {{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_awal)->translatedFormat('d F') }}-{{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_akhir)->translatedFormat('d F') }}
                                                                        @endif
                                                                        <br>
                                                                        {{ $peminjaman_cbt->jam_awal }}-{{ $peminjaman_cbt->jam_akhir }}
                                                                        @if (
                                                                            $tanggal == $peminjaman_cbt->tanggal_awal &&
                                                                                $jam >= $peminjaman_cbt->jam_awal &&
                                                                                $jam <= $peminjaman_cbt->jam_akhir)
                                                                            <span class="badge badge-primary">Aktif</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                @if ($peminjaman_cbt->items)
                                                                    <div class="row mb-2">
                                                                        <div class="col-md-6">
                                                                            <strong>Item</strong>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <ul class="pl-4 mb-0">
                                                                                @foreach (array_reverse($peminjaman_cbt->items) as $key => $item)
                                                                                    <li>
                                                                                        {{ $item }}
                                                                                        @if (!empty($peminjaman_cbt->jumlahs[$key]))
                                                                                            ({{ $peminjaman_cbt->jumlahs[$key] }})
                                                                                        @endif
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                <div class="row mb-2">
                                                                    <div class="col-md-6">
                                                                        <strong>Uraian Kegiatan</strong>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        {{ $peminjaman_cbt->keterangan }}
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-md-6">
                                                                        <strong>Penanggung Jawab</strong>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        {{ $peminjaman_cbt->pj }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-start">
                                                                <button type="button"
                                                                    class="btn btn-default btn-sm btn-flat"
                                                                    data-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        <span class="text-muted">
                                                            - Peminjaman tanggal
                                                            {{ Carbon\Carbon::parse(request()->get('tanggal') ?? date('Y-m-d'))->translatedFormat('d F') }}
                                                            tidak ditemukan -
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
