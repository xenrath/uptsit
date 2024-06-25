@extends('layouts.app')

@section('title', '500 Error Page')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>500 Error Page</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-danger">500</h2>
                <div class="error-content">
                    <h3>
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                        Oops! Terdapat kesalahan.
                    </h3>
                    <p>
                        Kami akan segera memperbaikinya.
                        Sementara itu, Anda dapat kembali ke <a href="{{ url(auth()->user()->role) }}">Dashboard</a>.
                    </p>
                </div>
            </div>
        </section>
    </div>
@endsection
