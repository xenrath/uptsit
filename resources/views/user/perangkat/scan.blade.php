@extends('layouts.app')

@section('title', 'Scan Kode Perangkat')

@section('css')
    <!-- Schmich Instascan -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a href="{{ url('user/perangkat') }}" class="btn btn-secondary btn-flat float-left mr-2">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1 class="m-0">Scan Kode Perangkat</h1>
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
                        <h3 class="card-title">Scan Perangkat</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <video id="preview" class="rounded w-100 h-100"></video>
                        <form action="{{ url('user/perangkat/scan') }}" method="post" id="form-submit">
                            @csrf
                            <input type="hidden" id="kode" name="kode">
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview'),
            mirror: false
        });
        scanner.addListener('scan', function(content) {
            document.getElementById('kode').value = content;
            document.getElementById('form-submit').submit();
        });
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[1]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function(e) {
            console.error(e);
        });
    </script>
@endsection
