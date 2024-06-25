@extends('layouts.web')

@section('content')
    <section class="page-title bg-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">Tupoksi</span>
                        <h1 class="text-capitalize mb-4 text-lg">Unit SIT</h1>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="index.html" class="text-white">Home</a>
                            </li>
                            <li class="list-inline-item">
                                <span class="text-white">/</span>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="text-white-50">Tupoksi</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  Section Services Start -->
    <section class="section service border-top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <div class="section-title">
                        <span class="h6 text-color">Tupoksi</span>
                        <h2 class="mt-3 content-title">Unit Sistem Informasi dan Teknologi</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach ($tupoksis as $tupoksi)
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="service-item mb-5">
                            <i class="{{ $tupoksi->icon }}"></i>
                            <h4 class="mb-3">{{ $tupoksi->nama }}</h4>
                            <p>{!! $tupoksi->deskripsi !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--  Section Services End -->

    <section class="cta-2">
        <div class="container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td style="width: 60px; text-align: center; font-weight: 600;">No.</td>
                        <td style="font-weight: 600;">Tupoksi</td>
                        <td style="width: 120px; text-align: center; font-weight: 600;">Opsi</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tupoksis as $tupoksi)
                        <tr>
                            <td style="text-align: center; vertical-align: middle">{{ $loop->iteration }}.</td>
                            <td style="vertical-align: middle">{{ $tupoksi->nama }}</td>
                            <td>
                                <a href="{{ asset('storage/uploads/' . $tupoksi->file) }}" class="btn btn-info"
                                    target="_blank">Download</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
