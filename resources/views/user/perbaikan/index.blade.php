@extends('layouts.app')

@section('title', 'Data Perbaikan')

@section('loader')
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('storage/uploads/unit/logo.png') }}" alt="Logo IT" height="80"
            width="80" style="border-radius: 50%">
    </div>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Data Perbaikan</h1>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perbaikan</h3>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary btn-sm btn-flat" data-toggle="modal"
                                data-target="#modal-perangkat">Buat</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 20px">No</th>
                                    <th style="width: 220px">Tanggal</th>
                                    <th>Perangkat</th>
                                    <th class="text-center" style="width: 40px">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($perbaikans as $perbaikan)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            {{ Carbon\Carbon::parse($perbaikan->tanggal)->translatedFormat('l, d F Y') }}
                                        </td>
                                        <td>
                                            @if ($perbaikan->perangkat->karyawan_id)
                                                {{ $perbaikan->perangkat->karyawan->nama }}
                                            @endif
                                            <br>
                                            {{ $perbaikan->perangkat->unit->nama }}
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-info btn-sm btn-flat mb-2"
                                                data-toggle="modal" data-target="#modal-lihat-{{ $perbaikan->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-lihat-{{ $perbaikan->id }}">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Detail Perbaikan</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <strong>Tanggal Perbaikan</strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ Carbon\Carbon::parse($perbaikan->tanggal)->translatedFormat('l, d F Y') }}
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <strong>Perangkat</strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            @if ($perbaikan->perangkat->karyawan_id)
                                                                {{ $perbaikan->perangkat->karyawan->nama }}
                                                            @endif
                                                            <br>
                                                            {{ $perbaikan->perangkat->unit->nama }}
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <strong>Tindakan</strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ $perbaikan->keterangan }}
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <strong>Foto Kondisi Sebelum</strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <img src="{{ asset('storage/uploads/' . $perbaikan->foto_sebelum) }}"
                                                                alt="Foto Kondisi Sebelum" class="w-100 mt-2 rounded">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <strong>Foto Kondisi Sesudah</strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <img src="{{ asset('storage/uploads/' . $perbaikan->foto_sesudah) }}"
                                                                alt="Foto Kondisi Sesudah" class="w-100 mt-2 rounded">
                                                        </div>
                                                    </div>
                                                    @if ($perbaikan->detail_perbaikans)
                                                        <hr class="mb-2">
                                                        <strong>Sparepart</strong>
                                                        <ul class="px-4">
                                                            @foreach ($perbaikan->detail_perbaikans as $detail_perbaikan)
                                                                <li>
                                                                    @if ($detail_perbaikan->sparepart->kategori == 'motherboard')
                                                                        {{ ucfirst($detail_perbaikan->sparepart->kategori) }}
                                                                        <span
                                                                            class="text-muted">({{ $detail_perbaikan->sparepart->merek }})</span>
                                                                        <span class="d-none d-lg-inline">|</span>
                                                                        {{ $detail_perbaikan->sparepart->model }}
                                                                        <span class="d-none d-lg-inline">|</span>
                                                                        {{ $detail_perbaikan->sparepart->tipe }}
                                                                    @elseif ($detail_perbaikan->sparepart->kategori == 'prosesor')
                                                                        {{ ucfirst($detail_perbaikan->sparepart->kategori) }}
                                                                        <span class="d-none d-lg-inline">|</span>
                                                                        {{ $detail_perbaikan->sparepart->model }}
                                                                    @elseif ($detail_perbaikan->sparepart->kategori == 'ram')
                                                                        RAM
                                                                        <span
                                                                            class="text-muted">({{ $detail_perbaikan->sparepart->merek }})</span>
                                                                        <span class="d-none d-lg-inline">|</span>
                                                                        {{ $detail_perbaikan->sparepart->tipe }}
                                                                        <span class="d-none d-lg-inline">|</span>
                                                                        {{ $detail_perbaikan->sparepart->kapasitas }} GB
                                                                    @elseif ($detail_perbaikan->sparepart->kategori == 'storage')
                                                                        {{ ucfirst($detail_perbaikan->sparepart->kategori) }}
                                                                        <span
                                                                            class="text-muted">({{ $detail_perbaikan->sparepart->merek }})</span>
                                                                        <span class="d-none d-lg-inline">|</span>
                                                                        {{ $detail_perbaikan->sparepart->tipe }}
                                                                        <span class="d-none d-lg-inline">|</span>
                                                                        {{ $detail_perbaikan->sparepart->kapasitas }} GB
                                                                    @elseif ($detail_perbaikan->sparepart->kategori == 'psu')
                                                                        PSU
                                                                        <span
                                                                            class="text-muted">({{ $detail_perbaikan->sparepart->merek }})</span>
                                                                        <span class="d-none d-lg-inline">|</span>
                                                                        {{ $detail_perbaikan->sparepart->kapasitas }} Watt
                                                                    @elseif ($detail_perbaikan->sparepart->kategori == 'heatsink')
                                                                        {{ ucfirst($detail_perbaikan->sparepart->kategori) }}
                                                                        <span
                                                                            class="text-muted">({{ $detail_perbaikan->sparepart->merek }})</span>
                                                                        <span class="d-none d-lg-inline">|</span>
                                                                        {{ $detail_perbaikan->sparepart->model }}
                                                                    @elseif ($detail_perbaikan->sparepart->kategori == 'monitor')
                                                                        {{ ucfirst($detail_perbaikan->sparepart->kategori) }}
                                                                        <span
                                                                            class="text-muted">({{ $detail_perbaikan->sparepart->merek }})</span>
                                                                        <span class="d-none d-lg-inline">|</span>
                                                                        {{ $detail_perbaikan->sparepart->kapasitas }} Inch
                                                                    @elseif ($detail_perbaikan->sparepart->kategori == 'keyboard' || $detail_perbaikan->sparepart->kategori == 'mouse')
                                                                        {{ ucfirst($detail_perbaikan->sparepart->kategori) }}
                                                                        <span
                                                                            class="text-muted">({{ $detail_perbaikan->sparepart->merek }})</span>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default btn-sm btn-flat"
                                                        data-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">- Data tidak ditemukan -</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </section>
        <!-- /.card -->
    </div>
    <div class="modal fade" id="modal-perangkat">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Perangkat</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-header">
                    <div class="input-group">
                        <input type="search" class="form-control rounded-0" id="keyword" name="keyword"
                            placeholder="cari perangkat dari karyawan / unit" autocomplete="off">
                        <div class="input-group-append rounded-0">
                            <button type="button" class="btn btn-default btn-flat" onclick="search_perangkat()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <table id="table-perangkat" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 20px">No</th>
                                <th>Karyawan / Unit</th>
                                <th class="text-center" style="width: 40px">Pilih</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-perangkat">
                            @forelse ($perangkats as $key => $perangkat)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($perangkat->karyawan_id)
                                            {{ $perangkat->karyawan->nama }}
                                            <br>
                                        @endif
                                        {{ $perangkat->unit->nama }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ url('user/perbaikan/' . $perangkat->id) }}"
                                            class="btn btn-outline-primary btn-sm btn-flat">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">- Data tidak ditemukan -</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if (count($perangkats) == 10)
                        <small class="text-muted">Cari dengan <strong>kata kunci</strong> lebih detail</small>
                    @endif
                    <div id="modal-batas" class="text-center" style="display: none">
                        <small class="text-muted">Cari dengan <strong>kata kunci</strong> lebih detail</small>
                    </div>
                    <div id="modal-loading" class="text-center p-4" style="display: none">
                        <span>Loading...</span>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#keyword').on('search', function() {
            search_perangkat();
        });

        function search_perangkat() {
            $('#table-perangkat').hide();
            $('#tbody-perangkat').empty();
            $('#modal-batas').hide();
            $('#modal-loading').show();
            $.ajax({
                url: "{{ url('user/perbaikan/perangkat-search') }}",
                type: "GET",
                data: {
                    "keyword": $('#keyword').val(),
                },
                dataType: "json",
                success: function(data) {
                    if (data.length > 0) {
                        $.each(data, function(key, value) {
                            tbody_perangkat(value, (key + 1));
                        });
                        if (data.length == 10) {
                            $('#modal-batas').show();
                        }
                    } else {
                        var tbody = '<tr>';
                        tbody += '<td class="text-center" colspan="3">- Data tidak ditemukan -</td>';
                        tbody += '</tr>';
                        $('#tbody-perangkat').append(tbody);
                    }
                    $('#modal-loading').hide();
                    $('#table-perangkat').show();
                },
            });
        }

        function tbody_perangkat(data, no) {
            var url = "{{ url('user/perbaikan') }}" + "/" + data.id;
            var tbody = '<tr>';
            tbody += '<td class="text-center">' + no + '</td>';
            tbody += '<td>';
            if (data.karyawan_id) {
                tbody += data.karyawan.nama;
                tbody += '<br>';
            }
            tbody += data.unit.nama;
            tbody += '</td>';
            tbody += '<td class="text-center">';
            tbody +=
                '<a href="' + url + '" class="btn btn-outline-primary btn-sm btn-flat">';
            tbody += '<i class="fas fa-check"></i>';
            tbody += '</a>';
            tbody += '</td>';
            tbody += '</tr>';
            $('#tbody-perangkat').append(tbody);
        }
    </script>
@endsection
