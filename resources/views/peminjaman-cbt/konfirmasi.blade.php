@extends('peminjaman-cbt.app')

@section('title', 'Peminjaman CBT')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <h1>Konfirmasi Peminjaman</h1>
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
                                <h3 class="card-title">Detail Peminjaman</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <strong>Nama Peminjam</strong>
                                    </div>
                                    <div class="col-md-6">
                                        {{ $peminjaman_cbt->nama }}
                                        @if ($peminjaman_cbt->keperluan == 'pembelajaran')
                                            <small class="text-muted">({{ $peminjaman_cbt->prodi->nama }})</small>
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
                                            {{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_awal)->translatedFormat('d F') }},
                                        @else
                                            {{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_awal)->translatedFormat('d F') }}-{{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_akhir)->translatedFormat('d F') }},
                                        @endif
                                        {{ $peminjaman_cbt->jam_awal }}-{{ $peminjaman_cbt->jam_akhir }}
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
                            @if ($peminjaman_cbt->status == 'disetujui')
                                <div class="card-footer text-right">
                                    <a href="{{ url('peminjaman-cbt/bukti/' . $peminjaman_cbt->kode) }}"
                                        class="btn btn-info btn-sm btn-flat">
                                        <i class="fas fa-print"></i>
                                        Bukti
                                    </a>
                                </div>
                            @endif
                        </div>
                        @if ($peminjaman_cbt->status == 'menunggu')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">TTD Penanggung Jawab</h3>
                                </div>
                                <form action="{{ url('peminjaman-cbt/' . $peminjaman_cbt->kode) }}" method="post"
                                    autocomplete="off" id="form-konfirmasi">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <canvas id="signaturePad" class="mb-2" height="300"
                                                    style="border-style: dashed"></canvas>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control rounded-0" id="ttd" name="ttd">
                                        <button type="button" class="btn btn-danger btn-sm btn-flat float-start"
                                            onclick="resetPad()">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="button" class="btn btn-info btn-sm btn-flat" id="btn-cek"
                                            data-toggle="modal" data-target="#modal-cek" hidden>Cek
                                        </button>
                                        <button type="button" onclick="konfirmasi()"
                                            class="btn btn-primary btn-flat">Konfirmasi</button>
                                    </div>
                                </form>
                            </div>
                        @endif
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
                            <strong>KONFIRMASI GAGAL!</strong>
                        </h4>
                        <p>
                            Ruang CBT tanggal
                            <strong>
                                @if ($peminjaman_cbt->tanggal_awal == $peminjaman_cbt->tanggal_akhir)
                                    {{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_awal)->translatedFormat('d F') }},
                                @else
                                    {{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_awal)->translatedFormat('d F') }}-{{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_akhir)->translatedFormat('d F') }},
                                @endif
                            </strong>
                            jam
                            <strong>
                                {{ $peminjaman_cbt->jam_awal }}-{{ $peminjaman_cbt->jam_akhir }}
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
                        <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        var canvas;
        var signaturePadCanvas;
        $(document).ready(() => {
            signaturePadCanvas = document.querySelector("#signaturePad");
            var parentWidth = jQuery(signaturePadCanvas).parent().outerWidth(300);
            signaturePadCanvas.setAttribute("width", parentWidth);
            canvas = new SignaturePad(signaturePadCanvas);
        })

        function resetPad() {
            canvas.clear();
            $('#ttd').val(null);
        }

        function konfirmasi() {
            if (!canvas.isEmpty()) {
                var dataURL = canvas.toDataURL();
                $('#ttd').val(dataURL);
            }
            $('#form-konfirmasi').submit();
        }

        var cek = @json(session('cek'));

        if (cek != null) {
            $('#btn-cek').click();
        }
    </script>
@endsection
