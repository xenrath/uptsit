@extends('layouts.app')

@section('title', 'Sparepart')

@section('loader')
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('storage/uploads/unit/logo.png') }}" alt="Admin SIT" height="80"
            width="80" style="border-radius: 50%">
    </div>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Sparepart</h1>
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
                        <h3 class="card-title">Data Sparepart</h3>
                        <div class="float-right">
                            <button type="button" class="btn btn-primary btn-sm btn-flat" data-toggle="modal"
                                data-target="#modal-tambah">Tambah</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 20px">No</th>
                                    <th>Nama</th>
                                    <th class="text-center" style="width: 140px">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($spareparts as $sparepart)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($sparepart->kategori == 'motherboard')
                                                {{ ucfirst($sparepart->kategori) }}
                                                <span class="text-muted">({{ $sparepart->merek }})</span>
                                                <span class="d-none d-lg-inline">|</span>
                                                <br class="d-block d-lg-none">
                                                {{ $sparepart->model }}
                                                <span class="d-none d-lg-inline">|</span>
                                                <br class="d-block d-lg-none">
                                                {{ $sparepart->tipe }}
                                            @elseif ($sparepart->kategori == 'prosesor')
                                                {{ ucfirst($sparepart->kategori) }}
                                                <span class="d-none d-lg-inline">|</span>
                                                <br class="d-block d-lg-none">
                                                {{ $sparepart->model }}
                                            @elseif ($sparepart->kategori == 'ram')
                                                RAM
                                                <span class="text-muted">({{ $sparepart->merek }})</span>
                                                <span class="d-none d-lg-inline">|</span>
                                                <br class="d-block d-lg-none">
                                                {{ $sparepart->tipe }}
                                                <span class="d-none d-lg-inline">|</span>
                                                <br class="d-block d-lg-none">
                                                {{ $sparepart->kapasitas }} GB
                                            @elseif ($sparepart->kategori == 'storage')
                                                {{ ucfirst($sparepart->kategori) }}
                                                <span class="text-muted">({{ $sparepart->merek }})</span>
                                                <span class="d-none d-lg-inline">|</span>
                                                <br class="d-block d-lg-none">
                                                {{ $sparepart->tipe }}
                                                <span class="d-none d-lg-inline">|</span>
                                                <br class="d-block d-lg-none">
                                                {{ $sparepart->kapasitas }} GB
                                            @elseif ($sparepart->kategori == 'psu')
                                                PSU
                                                <span class="text-muted">({{ $sparepart->merek }})</span>
                                                <span class="d-none d-lg-inline">|</span>
                                                <br class="d-block d-lg-none">
                                                {{ $sparepart->kapasitas }} Watt
                                            @elseif ($sparepart->kategori == 'heatsink')
                                                {{ ucfirst($sparepart->kategori) }}
                                                <span class="text-muted">({{ $sparepart->merek }})</span>
                                                <span class="d-none d-lg-inline">|</span>
                                                <br class="d-block d-lg-none">
                                                {{ $sparepart->model }}
                                            @elseif ($sparepart->kategori == 'monitor')
                                                {{ ucfirst($sparepart->kategori) }}
                                                <span class="text-muted">({{ $sparepart->merek }})</span>
                                                <span class="d-none d-lg-inline">|</span>
                                                <br class="d-block d-lg-none">
                                                {{ $sparepart->kapasitas }} Inch
                                            @elseif ($sparepart->kategori == 'keyboard' || $sparepart->kategori == 'mouse')
                                                {{ ucfirst($sparepart->kategori) }}
                                                <span class="text-muted">({{ $sparepart->merek }})</span>
                                            @endif
                                            <br class="d-block d-lg-none">
                                            @if ($sparepart->is_baru)
                                                @if (Carbon\Carbon::now()->format('Y-m-d') <
                                                        Carbon\Carbon::parse($sparepart->tanggal)->addMonth($sparepart->garansi))
                                                    <span class="badge bg-primary">Baru</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-info btn-sm btn-flat" data-toggle="modal"
                                                data-target="#modal-lihat-{{ $sparepart->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <a href="{{ url('user/sparepart/' . $sparepart->id . '/edit') }}"
                                                class="btn btn-warning btn-sm btn-flat">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm btn-flat"
                                                data-toggle="modal" data-target="#modal-hapus-{{ $sparepart->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-lihat-{{ $sparepart->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Detail Sparepart</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <strong>Kategori</strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ $sparepart->kategori == 'ram' || $sparepart->kategori == 'psu' ? strtoupper($sparepart->kategori) : ucfirst($sparepart->kategori) }}
                                                        </div>
                                                    </div>
                                                    @if ($sparepart->kategori != 'prosesor')
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <strong>Merek</strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $sparepart->merek }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($sparepart->kategori == 'motherboard' || $sparepart->kategori == 'prosesor' || $sparepart->kategori == 'heatsink')
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <strong>
                                                                    Model
                                                                    @if ($sparepart->kategori == 'motherboard')
                                                                        Prosesor
                                                                    @endif
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $sparepart->model }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($sparepart->kategori == 'motherboard' || $sparepart->kategori == 'ram' || $sparepart->kategori == 'storage')
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <strong>
                                                                    Tipe
                                                                    @if ($sparepart->kategori == 'motherboard')
                                                                        RAM
                                                                    @endif
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $sparepart->tipe }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (
                                                        $sparepart->kategori == 'ram' ||
                                                            $sparepart->kategori == 'storage' ||
                                                            $sparepart->kategori == 'psu' ||
                                                            $sparepart->kategori == 'monitor')
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <strong>
                                                                    {{ $sparepart->kategori == 'monitor' ? 'Ukuran' : 'Kapasitas' }}
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $sparepart->kapasitas }}
                                                                @if ($sparepart->kategori == 'ram' || $sparepart->kategori == 'storage')
                                                                    GB
                                                                @elseif ($sparepart->kategori == 'psu')
                                                                    Watt
                                                                @elseif ($sparepart->kategori == 'monitor')
                                                                    Inch
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <strong>Jumlah Barang</strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ $sparepart->jumlah }}
                                                        </div>
                                                    </div>
                                                    @if ($sparepart->is_baru)
                                                        <hr class="mb-2">
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <strong>Tanggal Pembelian</strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ Carbon\Carbon::parse($sparepart->tanggal)->translatedFormat('l, d F Y') }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <strong>Garansi</strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $sparepart->garansi }} Bulan
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <strong>Bukti Garansi</strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <img src="{{ asset('storage/uploads/' . $sparepart->bukti) }}"
                                                                    alt="Bukti Garansi" class="w-100 mt-2 rounded">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <strong>Foto Barang</strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <img src="{{ asset('storage/uploads/' . $sparepart->foto) }}"
                                                                    alt="Foto Barang" class="w-100 mt-2 rounded">
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <strong>Keterangan</strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ $sparepart->keterangan ?? '-' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default btn-sm btn-flat"
                                                        data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="modal-hapus-{{ $sparepart->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Sparepart</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        Yakin hapus sparepart
                                                        <strong>
                                                            @if ($sparepart->kategori == 'motherboard')
                                                                {{ ucfirst($sparepart->kategori) }}
                                                                <span class="text-muted">({{ $sparepart->merek }})</span>
                                                                <span class="d-none d-lg-inline">|</span>
                                                                {{ $sparepart->model }}
                                                                <span class="d-none d-lg-inline">|</span>
                                                                {{ $sparepart->tipe }}
                                                            @elseif ($sparepart->kategori == 'prosesor')
                                                                {{ ucfirst($sparepart->kategori) }}
                                                                <span class="d-none d-lg-inline">|</span>
                                                                {{ $sparepart->model }}
                                                            @elseif ($sparepart->kategori == 'ram')
                                                                RAM
                                                                <span class="text-muted">({{ $sparepart->merek }})</span>
                                                                <span class="d-none d-lg-inline">|</span>
                                                                {{ $sparepart->tipe }}
                                                                <span class="d-none d-lg-inline">|</span>
                                                                {{ $sparepart->kapasitas }} GB
                                                            @elseif ($sparepart->kategori == 'storage')
                                                                {{ ucfirst($sparepart->kategori) }}
                                                                <span class="text-muted">({{ $sparepart->merek }})</span>
                                                                <span class="d-none d-lg-inline">|</span>
                                                                {{ $sparepart->tipe }}
                                                                <span class="d-none d-lg-inline">|</span>
                                                                {{ $sparepart->kapasitas }} GB
                                                            @elseif ($sparepart->kategori == 'psu')
                                                                PSU
                                                                <span class="text-muted">({{ $sparepart->merek }})</span>
                                                                <span class="d-none d-lg-inline">|</span>
                                                                {{ $sparepart->kapasitas }} Watt
                                                            @elseif ($sparepart->kategori == 'heatsink')
                                                                {{ ucfirst($sparepart->kategori) }}
                                                                <span class="text-muted">({{ $sparepart->merek }})</span>
                                                                <span class="d-none d-lg-inline">|</span>
                                                                {{ $sparepart->model }}
                                                            @elseif ($sparepart->kategori == 'monitor')
                                                                {{ ucfirst($sparepart->kategori) }}
                                                                <span class="text-muted">({{ $sparepart->merek }})</span>
                                                                <span class="d-none d-lg-inline">|</span>
                                                                {{ $sparepart->kapasitas }} Inch
                                                            @elseif ($sparepart->kategori == 'keyboard' || $sparepart->kategori == 'mouse')
                                                                {{ ucfirst($sparepart->kategori) }}
                                                                <span class="text-muted">({{ $sparepart->merek }})</span>
                                                            @endif
                                                        </strong>?
                                                    </p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default btn-sm btn-flat"
                                                        data-dismiss="modal">Batal</button>
                                                    <form action="{{ url('user/sparepart/' . $sparepart->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm btn-flat">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="3">- Data tidak ditemukan -</td>
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
    <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kategori Sparepart</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('user/sparepart/create') }}" method="GET" autocomplete="off">
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="kategori">Kategori</label>
                            <select class="custom-select rounded-0" name="kategori" id="kategori">
                                <option value="">- Pilih -</option>
                                <option value="motherboard">Motherboard</option>
                                <option value="prosesor">Prosesor</option>
                                <option value="ram">RAM</option>
                                <option value="storage">Storage</option>
                                <option value="psu">PSU</option>
                                <option value="heatsink">Heatsink</option>
                                <option value="monitor">Monitor</option>
                                <option value="keyboard">Keyboard</option>
                                <option value="mouse">Mouse</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm btn-flat"
                            data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-flat">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
