@extends('layouts.app')

@section('title', 'Detail Perangkat')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a href="{{ url('user/perangkat') }}" class="btn btn-secondary btn-flat float-left mr-2">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1 class="m-0">Detail Perangkat</h1>
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
                        <h3 class="card-title">Detail Perangkat</h3>
                        <div class="text-right">
                            <button type="button" class="btn btn-secondary btn-sm btn-flat" data-card-widget="collapse"
                                title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            @if ($perangkat->karyawan_id)
                                <div class="col-md-4">
                                    <strong>Karyawan</strong>
                                    <br>
                                    {{ $perangkat->karyawan->nama }}
                                </div>
                            @endif
                            <div class="col-md-4">
                                <strong>Unit</strong>
                                <br>
                                {{ $perangkat->unit->nama }}
                            </div>
                        </div>
                        <hr class="mb-2">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <strong>Jenis Barang</strong>
                                <br>
                                {{ $perangkat->jenis == 'pc' ? 'PC' : 'Laptop' }}
                            </div>
                            <div class="col-md-4">
                                <strong>Merek</strong>
                                <br>
                                {{ $perangkat->merek }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <strong>Model</strong>
                                <br>
                                {{ $perangkat->model }}
                            </div>
                            <div class="col-md-4">
                                <strong>No Seri</strong>
                                <br>
                                {{ $perangkat->no_seri }}
                            </div>
                        </div>
                        <hr class="mb-2">
                        <strong>Tipe RAM</strong>
                        <br>
                        {{ $perangkat->ram_tipe }}
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <strong>Kapasitas RAM</strong>
                                <br>
                                {{ $perangkat->ram_kapasitas }} GB
                            </div>
                            <div class="col-md-4">
                                <strong>Merek RAM</strong>
                                <br>
                                {{ $perangkat->ram_merek }}
                            </div>
                        </div>
                        @if ($perangkat->is_ram_tambahan)
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <strong>Kapasitas RAM Tambahan</strong>
                                    <br>
                                    {{ $perangkat->ram_tambahan_kapasitas }} GB
                                </div>
                                <div class="col-md-4">
                                    <strong>Merek RAM Tambahan</strong>
                                    <br>
                                    {{ $perangkat->ram_tambahan_merek }}
                                </div>
                            </div>
                        @endif
                        <hr class="mb-2">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <strong>Tipe Storage</strong>
                                <br>
                                {{ $perangkat->storage_tipe }}
                            </div>
                            <div class="col-md-4">
                                <strong>Kapasitas Storage</strong>
                                <br>
                                {{ $perangkat->storage_kapasitas }} GB
                            </div>
                            <div class="col-md-4">
                                <strong>Merek Storage</strong>
                                <br>
                                {{ $perangkat->storage_merek }}
                            </div>
                        </div>
                        @if ($perangkat->is_storage_tambahan)
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <strong>Tipe Storage Tambahan</strong>
                                    <br>
                                    {{ $perangkat->storage_tambahan_tipe }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Kapasitas Storage Tambahan</strong>
                                    <br>
                                    {{ $perangkat->storage_tambahan_kapasitas }} GB
                                </div>
                                <div class="col-md-4">
                                    <strong>Merek Storage Tambahan</strong>
                                    <br>
                                    {{ $perangkat->storage_tambahan_merek }}
                                </div>
                            </div>
                        @endif
                        <hr class="mb-2">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <strong>Kapasitas PSU</strong>
                                <br>
                                {{ $perangkat->psu_kapasitas }} Watt
                            </div>
                            <div class="col-md-4">
                                <strong>Merek PSU</strong>
                                <br>
                                {{ $perangkat->psu_merek }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <strong>Model Heatsink</strong>
                                <br>
                                {{ $perangkat->heatsink_model }}
                            </div>
                            <div class="col-md-4">
                                <strong>Model Heatsink</strong>
                                <br>
                                {{ $perangkat->heatsink_model }}
                            </div>
                        </div>
                        <hr class="mb-2">
                        @if ($perangkat->jenis == 'pc')
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <strong>Ukuran Monitor</strong>
                                    <br>
                                    {{ $perangkat->monitor_ukuran }} Inch
                                </div>
                                <div class="col-md-4">
                                    <strong>Merek Monitor</strong>
                                    <br>
                                    {{ $perangkat->monitor_merek }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <strong>Merek Keyboard</strong>
                                    <br>
                                    {{ $perangkat->keyboard_merek }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Merek Mouse</strong>
                                    <br>
                                    {{ $perangkat->mouse_merek }}
                                </div>
                            </div>
                        @endif
                        <hr class="mb-2">
                        <strong>Keterangan</strong>
                        <br>
                        {{ $perangkat->keterangan ?? '-' }}
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Perbaikan</h3>
                        <div class="text-right">
                            <button type="button" class="btn btn-secondary btn-sm btn-flat" data-card-widget="collapse"
                                title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach ($perbaikans as $key => $perbaikan)
                            @if ($key)
                                <hr class="mb-2">
                            @endif
                            {{ $perbaikan->keterangan }}
                            <br>
                            @if ($perbaikan->detail_perbaikans)
                                <ul class="px-4">
                                    @foreach ($perbaikan->detail_perbaikans as $detail_perbaikan)
                                        <li>
                                            @if ($detail_perbaikan->sparepart->kategori == 'motherboard')
                                                {{ ucfirst($detail_perbaikan->sparepart->kategori) }}
                                                <span class="text-muted">({{ $detail_perbaikan->sparepart->merek }})</span>
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
                                                <span class="text-muted">({{ $detail_perbaikan->sparepart->merek }})</span>
                                                <span class="d-none d-lg-inline">|</span>
                                                {{ $detail_perbaikan->sparepart->tipe }}
                                                <span class="d-none d-lg-inline">|</span>
                                                {{ $detail_perbaikan->sparepart->kapasitas }} GB
                                            @elseif ($detail_perbaikan->sparepart->kategori == 'storage')
                                                {{ ucfirst($detail_perbaikan->sparepart->kategori) }}
                                                <span class="text-muted">({{ $detail_perbaikan->sparepart->merek }})</span>
                                                <span class="d-none d-lg-inline">|</span>
                                                {{ $detail_perbaikan->sparepart->tipe }}
                                                <span class="d-none d-lg-inline">|</span>
                                                {{ $detail_perbaikan->sparepart->kapasitas }} GB
                                            @elseif ($detail_perbaikan->sparepart->kategori == 'psu')
                                                PSU
                                                <span class="text-muted">({{ $detail_perbaikan->sparepart->merek }})</span>
                                                <span class="d-none d-lg-inline">|</span>
                                                {{ $detail_perbaikan->sparepart->kapasitas }} Watt
                                            @elseif ($detail_perbaikan->sparepart->kategori == 'heatsink')
                                                {{ ucfirst($detail_perbaikan->sparepart->kategori) }}
                                                <span class="text-muted">({{ $detail_perbaikan->sparepart->merek }})</span>
                                                <span class="d-none d-lg-inline">|</span>
                                                {{ $detail_perbaikan->sparepart->model }}
                                            @elseif ($detail_perbaikan->sparepart->kategori == 'monitor')
                                                {{ ucfirst($detail_perbaikan->sparepart->kategori) }}
                                                <span class="text-muted">({{ $detail_perbaikan->sparepart->merek }})</span>
                                                <span class="d-none d-lg-inline">|</span>
                                                {{ $detail_perbaikan->sparepart->kapasitas }} Inch
                                            @elseif ($detail_perbaikan->sparepart->kategori == 'keyboard' || $detail_perbaikan->sparepart->kategori == 'mouse')
                                                {{ ucfirst($detail_perbaikan->sparepart->kategori) }}
                                                <span class="text-muted">({{ $detail_perbaikan->sparepart->merek }})</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            <small
                                class="text-muted">{{ Carbon\Carbon::parse($perbaikan->tanggal)->translatedFormat('l, d F Y') }}</small>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
