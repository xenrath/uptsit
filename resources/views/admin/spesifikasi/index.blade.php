@extends('layouts.app')

@section('title', 'Spesifikasi')

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
                        <h1 class="m-0">Spesifikasi</h1>
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
                        <h3 class="card-title">Spesifikasi</h3>
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
                                    <th>Spesifikasi</th>
                                    <th class="text-center" style="width: 100px">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($spesifikasis as $spesifikasi)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $spesifikasi->kategori == 'ram' ? strtoupper($spesifikasi->kategori) : ucfirst($spesifikasi->kategori) }}
                                            <br>
                                            {{ ucfirst($spesifikasi->grup) }} :
                                            {{ $spesifikasi->keterangan }}
                                            @if ($spesifikasi->grup == 'kapasitas')
                                                GB
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning btn-sm btn-flat mb-2"
                                                data-toggle="modal" data-target="#modal-edit-{{ $spesifikasi->id }}">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm btn-flat mb-2"
                                                data-toggle="modal" data-target="#modal-hapus-{{ $spesifikasi->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-edit-{{ $spesifikasi->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Spesifikasi</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ url('admin/spesifikasi/' . $spesifikasi->id) }}"
                                                    method="POST" autocomplete="off">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group mb-2">
                                                            <label for="edit_kategori">Kategori</label>
                                                            <select class="custom-select rounded-0" id="edit_kategori"
                                                                name="edit_kategori" disabled>
                                                                <option value="{{ $spesifikasi->kategori }}">
                                                                    {{ $spesifikasi->kategori == 'ram' ? strtoupper($spesifikasi->kategori) : ucfirst($spesifikasi->kategori) }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label for="edit_grup">Grup</label>
                                                            <select class="custom-select rounded-0" id="edit_grup"
                                                                name="edit_grup" disabled>
                                                                <option value="{{ $spesifikasi->grup }}">
                                                                    {{ ucfirst($spesifikasi->grup) }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label for="edit_keterangan">Keterangan</label>
                                                            <input type="text"
                                                                class="form-control rounded-0  @if (session('id') == $spesifikasi->id) @error('edit_keterangan') is-invalid @enderror @endif"
                                                                id="edit_keterangan" name="edit_keterangan"
                                                                value="{{ $spesifikasi->keterangan }}">
                                                            @if (session('id') == $spesifikasi->id)
                                                                @error('edit_keterangan')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            @endif
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
                                    <div class="modal fade" id="modal-hapus-{{ $spesifikasi->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Spesifikasi</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        Yakin hapus spesifikasi
                                                        <strong>
                                                            {{ $spesifikasi->kategori == 'ram' ? strtoupper($spesifikasi->kategori) : ucfirst($spesifikasi->kategori) }}
                                                        </strong>
                                                        ?
                                                    </p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default btn-sm btn-flat"
                                                        data-dismiss="modal">Batal</button>
                                                    <form action="{{ url('admin/spesifikasi/' . $spesifikasi->id) }}"
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
    <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Spesifikasi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/spesifikasi') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="kategori">Kategori</label>
                            <select
                                class="custom-select rounded-0 @if (!session('id')) @error('kategori') is-invalid @enderror @endif"
                                id="kategori" name="kategori" onchange="set_grup()">
                                <option value="">- Pilih -</option>
                                <option value="motherboard" {{ old('kategori') == 'motherboard' ? 'selected' : '' }}>
                                    Motherboard</option>
                                <option value="prosesor" {{ old('kategori') == 'prosesor' ? 'selected' : '' }}>Prosesor
                                </option>
                                <option value="ram" {{ old('kategori') == 'ram' ? 'selected' : '' }}>RAM</option>
                                <option value="storage" {{ old('kategori') == 'storage' ? 'selected' : '' }}>Storage
                                </option>
                            </select>
                            @if (!session('id'))
                                @error('kategori')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif
                        </div>
                        <div class="form-group mb-2">
                            <label for="grup">Grup</label>
                            <select
                                class="custom-select rounded-0 @if (!session('id')) @error('grup') is-invalid @enderror @endif"
                                id="grup" name="grup" onchange="set_keterangan()">
                                <option value="" disabled>- pilih kategori terlebih dahulu -</option>
                            </select>
                            @error('grup')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="keterangan">
                                Keterangan
                                <small class="text-muted" id="keterangan-small"></small>
                            </label>
                            <input type="text"
                                class="form-control rounded-0 @if (!session('id')) @error('keterangan') is-invalid @enderror @endif"
                                id="keterangan" name="keterangan" value="{{ old('keterangan') }}">
                            @if (!session('id'))
                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif
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

@section('script')
    <script>
        function set_grup(grup = null) {
            var kategori = $('#kategori').val();
            if (kategori === 'motherboard') {
                $('#grup').empty();
                var option = '<option value="merek">Merek</option>';
                $('#grup').append(option);
            } else if (kategori === 'prosesor') {
                $('#grup').empty();
                var option = '<option value="model">Model</option>';
                $('#grup').append(option);
            } else if (kategori === 'ram') {
                $('#grup').empty();
                var option = '<option value="">- Pilih -</option>';
                option += '<option value="tipe">Tipe</option>';
                option += '<option value="merek">Merek</option>';
                option += '<option value="kapasitas">Kapasitas</option>';
                $('#grup').append(option);
            } else if (kategori === 'storage') {
                $('#grup').empty();
                var option = '<option value="">- Pilih -</option>';
                option += '<option value="merek">Merek</option>';
                option += '<option value="kapasitas">Kapasitas</option>';
                $('#grup').append(option);
            } else {
                $('#grup').empty();
                var option = '<option value="" disabled>- pilih kategori terlebih dahulu -</option>';
                $('#grup').append(option);
            }
            $('#keterangan-small').text('');
            $('#keterangan').prop('type', 'text');
            if (grup != null) {
                $('#grup').val(grup);
            }
        }

        var kategori = "{{ old('kategori') }}";
        if (kategori) {
            set_grup();
        }

        function set_keterangan() {
            var grup = $('#grup').val();
            if (grup === 'kapasitas') {
                $('#keterangan-small').text('(satuan: GB)');
                $('#keterangan').prop('type', 'number');
            } else {
                $('#keterangan-small').text('');
                $('#keterangan').prop('type', 'text');
            }
        }

        var grup = "{{ old('grup') }}";
        if (grup) {
            set_grup(grup);
            set_keterangan();
        }
    </script>
@endsection
