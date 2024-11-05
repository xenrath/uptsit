@extends('peminjaman-cbt.app')

@section('title', 'Buat Peminjaman CBT')

@section('css')
    <!-- Jquery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <a href="{{ url('peminjaman-cbt/create') }}" class="btn btn-secondary btn-flat float-left mr-2">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1>Peminjaman CBT</h1>
                    </div>
                    <div class="col-sm-6 mb-2">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item">
                                <a href="{{ url('peminjaman-cbt') }}" style="text-decoration: underline;">List
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
                            @foreach (session('error') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card rounded-0">
                    <div class="card-header">
                        <h3 class="card-title">Form Peminjaman</h3>
                    </div>
                    <form action="{{ url('peminjaman-cbt/lainnya') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="card-body">
                            <div class="form-group mb-2">
                                <label for="keperluan">Keperluan Peminjaman</label>
                                <input type="text" class="form-control rounded-0" id="keperluan" name="keperluan"
                                    value="Peminjaman Lainnya" readonly>
                            </div>
                            <div class="form-group mb-2">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" class="form-control rounded-0" id="nama" name="nama"
                                    value="{{ old('nama') }}">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="tanggal_awal">Tanggal Pinjam</label>
                                        <input type="date" class="form-control rounded-0" id="tanggal_awal"
                                            name="tanggal_awal" min="{{ date('Y-m-d') }}"
                                            value="{{ old('tanggal_awal') }}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="lama">
                                            Lama
                                            <small>(hari)</small>
                                        </label>
                                        <input type="number" class="form-control rounded-0" id="lama" name="lama"
                                            value="{{ old('lama', '1') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="jam_awal">Jam Mulai</label>
                                        <input type="time" class="form-control rounded-0" id="jam_awal" name="jam_awal"
                                            value="{{ old('jam_awal') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="jam_akhir">Jam Akhir</label>
                                        <input type="time" class="form-control rounded-0" id="jam_akhir" name="jam_akhir"
                                            value="{{ old('jam_akhir') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label>
                                            Item Yang Dipinjam
                                            <small>(kosongkan jika hanya pinjam ruang)</small>
                                        </label>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="item-komputer"
                                                name="items[komputer]" value="Perangkat Komputer" onclick="showKomputer()">
                                            <label for="item-komputer" class="custom-control-label"
                                                style="font-weight: normal">Perangkat
                                                Komputer</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="item-internet"
                                                name="items[internet]" value="Penggunaan Internet" disabled>
                                            <label for="item-internet" class="custom-control-label"
                                                style="font-weight: normal">Penggunaan
                                                Internet</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="layout_komputer" style="display: none;">
                                        <div class="form-group mb-2">
                                            <label for="komputer">Jumlah Komputer</label>
                                            <input type="number" class="form-control rounded-0" id="komputer"
                                                name="jumlahs[komputer]" value="{{ old('jumlahs')['komputer'] ?? null }}"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="item-meja"
                                            name="items[meja]" value="Meja" onclick="showMeja()">
                                        <label for="item-meja" class="custom-control-label"
                                            style="font-weight: normal">Meja</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="layout_meja" style="display: none;">
                                        <div class="form-group mb-2">
                                            <label for="meja">Jumlah Meja</label>
                                            <input type="number" class="form-control rounded-0" id="meja"
                                                name="jumlahs[meja]" value="{{ old('jumlahs')['meja'] ?? null }}"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="item-kursi"
                                            name="items[kursi]" value="Kursi" onclick="showKursi()">
                                        <label for="item-kursi" class="custom-control-label"
                                            style="font-weight: normal">Kursi</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="layout_kursi" style="display: none">
                                        <div class="form-group mb-2">
                                            <label for="kursi">Jumlah Kursi</label>
                                            <input type="number" class="form-control rounded-0" id="kursi"
                                                name="jumlahs[kursi]" value="{{ old('jumlahs')['kursi'] ?? null }}"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group my-2">
                                <label for="keterangan">Uraian Kegiatan</label>
                                <textarea class="form-control rounded-0" id="keterangan" name="keterangan" rows="3"
                                    placeholder="Tulis Kegiatan">{{ old('keterangan') }}</textarea>
                            </div>
                            <div class="form-group mb-2">
                                <label for="pj">Penanggung Jawab</label>
                                <input type="text" class="form-control rounded-0" id="pj" name="pj"
                                    placeholder="Nama PJ Acara" value="{{ old('pj') }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="telp">
                                    Nomor telepon Peminjam
                                    <small class="text-muted">(08xxxxxxxxxx)</small>
                                </label>
                                <input type="text" class="form-control rounded-0" id="telp" name="telp"
                                    placeholder="Nomor " value="{{ old('telp') }}">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="button" class="btn btn-info btn-flat" id="btn-cek" data-toggle="modal"
                                data-target="#modal-cek" hidden>Cek
                            </button>
                            <button type="submit" class="btn btn-primary btn-flat">Buat Peminjaman</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (session('cek'))
        <div class="modal fade show" id="modal-cek">
            <div class="modal-dialog">
                <div class="modal-content rounded-0">
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
        function showKomputer() {
            if ($('#item-komputer').is(':checked')) {
                $('.layout_komputer').show();
                $('#komputer').removeAttr('disabled');
                $('#item-internet').removeAttr('disabled');
            } else {
                $('.layout_komputer').hide();
                $('#komputer').val(null);
                $('#komputer').attr('disabled', 'disabled');
                $('#item-internet').prop('checked', false);
                $('#item-internet').attr('disabled', 'disabled');
            }
        }

        function showMeja() {
            if ($('#item-meja').is(':checked')) {
                $('.layout_meja').show();
                $('#meja').removeAttr('disabled');
            } else {
                $('.layout_meja').hide();
                $('#meja').val(null);
                $('#meja').attr('disabled', 'disabled');
            }
        }

        function showKursi() {
            if ($('#item-kursi').is(':checked')) {
                $('.layout_kursi').show();
                $('#kursi').removeAttr('disabled');
            } else {
                $('.layout_kursi').hide();
                $('#kursi').val(null);
                $('#kursi').attr('disabled', 'disabled');
            }
        }

        var items = @json(old('items'));
        if (items) {
            $.each(items, function(key, value) {
                $('#item-' + key).prop('checked', true);
            })
            showKomputer();
            showMeja();
            showKursi();
        }

        var cek = @json(session('cek'));

        if (cek != null) {
            $('#btn-cek').click();
        }
    </script>
@endsection
