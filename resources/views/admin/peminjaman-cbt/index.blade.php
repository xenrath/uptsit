@extends('layouts.app')

@section('title', 'Dashboard')

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
                        <h1 class="m-0">Peminjaman CBT</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Peminjaman CBT</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5>Gagal!</h5>
                        <ul class="pl-4 pr-2 mb-0">
                            @foreach (session('error') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Peminjaman</h3>
                        <div class="float-right">
                            <button type="button" class="btn btn-info btn-sm btn-flat" id="btn-cek" data-toggle="modal"
                                data-target="#modal-cek" hidden>Cek
                            </button>
                            <a href="{{ url('admin/peminjaman-cbt/riwayat') }}" style="text-decoration: underline">
                                Riwayat Peminjaman
                            </a>
                        </div>
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
                                        <th class="text-center" style="width: 80px">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($peminjaman_cbts as $peminjaman_cbt)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($peminjaman_cbt->keperluan == 'pembelajaran')
                                                    <a href="{{ url('admin/peminjaman-cbt/hubungi/' . $peminjaman_cbt->id) }}" target="_blank">
                                                        {{ $peminjaman_cbt->nama }}
                                                        <br>
                                                        <small
                                                            class="text-muted">({{ $peminjaman_cbt->prodi->nama }})</small>
                                                    </a>
                                                @else
                                                    <a
                                                        href="{{ url('admin/peminjaman-cbt/hubungi/' . $peminjaman_cbt->id) }}" target="_blank">{{ $peminjaman_cbt->nama }}</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($peminjaman_cbt->tanggal_awal == $peminjaman_cbt->tanggal_akhir)
                                                    {{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_awal)->translatedFormat('d F') }}
                                                @else
                                                    {{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_awal)->translatedFormat('d F') }}-{{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_akhir)->translatedFormat('d F') }}
                                                @endif
                                                <br>
                                                {{ $peminjaman_cbt->jam_awal }}-{{ $peminjaman_cbt->jam_akhir }}
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
                                                @if (
                                                    $tanggal > $peminjaman_cbt->tanggal_akhir ||
                                                        ($tanggal == $peminjaman_cbt->tanggal_akhir && $jam > $peminjaman_cbt->jam_akhir))
                                                    <i class="fas fa-exclamation-circle text-danger"></i>
                                                @endif
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
                                                        @foreach (array_reverse($peminjaman_cbt->items) as $key => $item)
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
                                            <td>{{ $peminjaman_cbt->keterangan }}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle"
                                                        data-toggle="dropdown">
                                                        <i class="fas fa-bars"></i>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu">
                                                        <a href="#" class="dropdown-item" data-toggle="modal"
                                                            data-target="#modal-edit-{{ $peminjaman_cbt->id }}">Ubah
                                                            Waktu</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="#" class="dropdown-item" data-toggle="modal"
                                                            data-target="#modal-hapus-{{ $peminjaman_cbt->id }}">Hapus</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="#" class="dropdown-item" data-toggle="modal"
                                                            data-target="#modal-selesai-{{ $peminjaman_cbt->id }}">Selesaikan</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="modal-edit-{{ $peminjaman_cbt->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Ubah Waktu</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form
                                                        action="{{ url('admin/peminjaman-cbt/ubah-waktu/' . $peminjaman_cbt->id) }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="form-group mb-2">
                                                                <label for="tanggal_awal">Tanggal Pinjam</label>
                                                                <input type="date" class="form-control rounded-0"
                                                                    id="tanggal_awal" name="tanggal_awal"
                                                                    value="{{ $peminjaman_cbt->tanggal_awal }}" />
                                                            </div>
                                                            @if ($peminjaman_cbt->keperluan == 'lainnya')
                                                                <div class="form-group mb-2">
                                                                    <label for="tanggal_akhir">Tanggal Selesai</label>
                                                                    <input type="date" class="form-control rounded-0"
                                                                        id="tanggal_akhir" name="tanggal_akhir"
                                                                        value="{{ $peminjaman_cbt->tanggal_akhir }}" />
                                                                </div>
                                                            @endif
                                                            <div class="form-group mb-2">
                                                                <label for="jam_awal">Jam Mulai</label>
                                                                <input type="time" class="form-control rounded-0"
                                                                    id="jam_awal" name="jam_awal"
                                                                    value="{{ $peminjaman_cbt->jam_awal }}">
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="jam_akhir">Jam Akhir</label>
                                                                <input type="time" class="form-control rounded-0"
                                                                    id="jam_akhir" name="jam_akhir"
                                                                    value="{{ $peminjaman_cbt->jam_akhir }}">
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
                                        <div class="modal fade" id="modal-hapus-{{ $peminjaman_cbt->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Peminjaman</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Yakin hapus peminjaman dari
                                                        <strong>{{ $peminjaman_cbt->nama }}</strong>?
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default btn-sm btn-flat"
                                                            data-dismiss="modal">Batal</button>
                                                        <form
                                                            action="{{ url('admin/peminjaman-cbt/' . $peminjaman_cbt->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm btn-flat">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="modal-selesai-{{ $peminjaman_cbt->id }}">
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
                                                        Yakin selesaikan peminjaman dari
                                                        <strong>{{ $peminjaman_cbt->nama }}</strong>?
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default btn-sm btn-flat"
                                                            data-dismiss="modal">Batal</button>
                                                        <a href="{{ url('admin/peminjaman-cbt/selesaikan/' . $peminjaman_cbt->id) }}"
                                                            class="btn btn-primary btn-sm btn-flat">Selesaikan</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
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
                            <strong>
                                @if (old('lama') > 1)
                                    {{ Carbon\Carbon::parse(old('tanggal_awal'))->translatedFormat('d F') }}-{{ Carbon\Carbon::parse(old('tanggal_awal'))->addDays(old('lama'))->translatedFormat('d F') }}
                                @else
                                    {{ Carbon\Carbon::parse(old('tanggal_awal'))->translatedFormat('d F') }}
                                @endif
                            </strong>
                            jam
                            <strong>
                                {{ old('jam_awal') }}-{{ old('jam_akhir') }}
                            </strong>
                            sudah dipinjam.
                        </p>
                        @foreach (session('cek') as $cek)
                            <div class="border rounded mb-2 p-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Nama Peminjam</strong>
                                    </div>
                                    <div class="col-md-6">
                                        {{ $cek->nama }}
                                        @if ($cek->keperluan == 'pembelajaran')
                                            <small class="text-muted">({{ $cek->prodi->nama }})</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Waktu</strong>
                                    </div>
                                    <div class="col-md-6">
                                        @if ($cek->tanggal_awal == $cek->tanggal_akhir)
                                            {{ Carbon\Carbon::parse($cek->tanggal_awal)->translatedFormat('d F') }},
                                        @else
                                            {{ Carbon\Carbon::parse($cek->tanggal_awal)->translatedFormat('d F') }}-{{ Carbon\Carbon::parse($cek->tanggal_akhir)->translatedFormat('d F') }},
                                        @endif
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

@section('script')
    <script>
        var cek = @json(session('cek'));

        if (cek != null) {
            $('#btn-cek').click();
        }
    </script>
@endsection
