@extends('layouts.app')

@section('title', 'Edit Kegiatan')

@section('css')
    <!-- Jquery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a href="{{ url('user/kegiatan') }}" class="btn btn-secondary btn-flat float-left mr-2">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1 class="m-0">Edit Kegiatan</h1>
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
                        <h3 class="card-title">Edit Kegiatan</h3>
                    </div>
                    <!-- /.card-header -->
                    <form action="{{ url('user/kegiatan/' . $kegiatan->id) }}" method="POST" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="form-group mb-2">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control rounded-0 @error('tanggal') is-invalid @enderror"
                                    id="tanggal" name="tanggal" value="{{ old('tanggal', $kegiatan->tanggal) }}">
                                @error('tanggal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="deskripsi">Deskripsi Kegiatan</label>
                                <textarea class="form-control rounded-0 @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi"
                                    rows="4" placeholder="tulis apa yang dilakukan">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="bukti">
                                    Tambah Bukti Foto
                                    <small class="text-muted">(opsional)</small>
                                </label>
                                <input type="file" class="form-control rounded-0 @error('bukti') is-invalid @enderror"
                                    id="bukti" name="bukti[]" accept="image/*" multiple>
                                @foreach (old('old_bukti') ?? $kegiatan->buktis as $key => $bukti)
                                    <input type="text" class="form-control rounded-0" id="old_bukti-{{ $key }}"
                                        name="old_bukti[]" value="{{ $bukti }}" hidden>
                                @endforeach
                                @error('bukti')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="row">
                                @foreach (old('old_bukti') ?? $kegiatan->buktis as $key => $bukti)
                                    <div id="bukti-{{ $key }}" class="col-md-3 text-center mb-2">
                                        <img src="{{ asset('storage/uploads/' . $bukti) }}"
                                            alt="Bukti {{ $key + 1 }}" class="w-100 border mb-1">
                                        <button type="button" class="btn btn-danger btn-xs btn-flat"
                                            onclick="hapus_bukti({{ $key }})">
                                            <i class="fas fa-times mx-1"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary btn-sm btn-flat">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        function hapus_bukti(key) {
            $('#bukti-' + key).remove();
            $('#old_bukti-' + key).remove();
        }
    </script>
@endsection
