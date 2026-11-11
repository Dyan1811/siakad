<!-- 
NAME: Rian Firmansyah
NIM: 3202416045
DATE: 3/11/2026
-->

@extends('layouts.app')

@section('title', '403 Akses Ditolak')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center text-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm p-4">
                <div class="card-body">
                    <div class="mb-3 text-danger">
                        <i class="bi bi-shield-lock-fill display-1"></i>
                    </div>
                    <h1 class="h3 fw-bold text-danger mb-2">403 - Akses Ditolak</h1>
                    <p class="text-body-secondary mb-4">
                        {{ $exception->getMessage() ?: 'Anda tidak berhak mengakses halaman ini.' }}
                    </p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i class="bi bi-house-door-fill me-1"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection