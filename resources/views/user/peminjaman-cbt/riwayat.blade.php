@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('loader')
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('storage/uploads/unit/logo.png') }}" alt="Admin SIT" height="80"
            width="80" style="border-radius: 50%">
    </div>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a href="{{ url('user/peminjaman-cbt') }}" class="btn btn-secondary btn-flat float-left mr-2">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1>Riwayat Peminjaman</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card rounded-0">
                    <div class="card-header">
                        <h3 class="card-title">Data Peminjaman</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 20px">No</th>
                                        <th>Nama Peminjam</th>
                                        <th>Waktu</th>
                                        <th>Keperluan</th>
                                        <th style="width: 320px">Keterangan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($peminjaman_cbts as $key => $peminjaman_cbt)
                                        <tr>
                                            <td class="text-center">{{ $peminjaman_cbts->firstItem() + $key }}</td>
                                            <td>
                                                {{ $peminjaman_cbt->nama }}
                                                @if ($peminjaman_cbt->keperluan == 'pembelajaran')
                                                    <br>
                                                    <small class="text-muted">({{ $peminjaman_cbt->prodi->nama }})</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($peminjaman_cbt->tanggal_awal == $peminjaman_cbt->tanggal_akhir)
                                                    {{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_awal)->translatedFormat('d F') }}
                                                @else
                                                    {{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_awal)->translatedFormat('d F') }}-{{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_akhir)->translatedFormat('d F') }}
                                                @endif
                                                <br>
                                                {{ $peminjaman_cbt->jam_awal }}-{{ $peminjaman_cbt->jam_akhir }} WIB
                                            </td>
                                            <td>
                                                @if ($peminjaman_cbt->keperluan == 'pembelajaran')
                                                    Pembelajaran Kuliah
                                                @elseif ($peminjaman_cbt->keperluan == 'lainnya')
                                                    Peminjaman Lainnya
                                                @endif
                                                <br>
                                                <span class="text-muted">({{ $peminjaman_cbt->pj }})</span>
                                                @if ($peminjaman_cbt->items)
                                                    <hr class="my-2">
                                                    <ul class="pl-4 mb-0">
                                                        @foreach ($peminjaman_cbt->items as $key => $item)
                                                            <li>
                                                                {{ $item }}
                                                                @if (!empty($peminjaman_cbt->jumlahs[$key]))
                                                                    ({{ $peminjaman_cbt->jumlahs[$key] }})
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $peminjaman_cbt->keterangan }}
                                                @if ($peminjaman_cbt->status == 'batal')
                                                    <hr class="my-2">
                                                    <strong>Pembatalan:</strong><br>
                                                    <span></span>{{ $peminjaman_cbt->pembatalan }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($peminjaman_cbt->status == 'disetujui' || $peminjaman_cbt->status == 'selesai')
                                                    <span class="badge badge-primary rounded-0">Selesai</span>
                                                @else
                                                    <span class="badge badge-danger rounded-0">Batal</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <span class="text-muted">
                                                    - Data peminjaman tidak ditemukan -
                                                </span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pagination float-right">
                                {{ $peminjaman_cbts->appends(Request::all())->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
