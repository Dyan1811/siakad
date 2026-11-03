@extends('layouts.app')

@section('title', 'Detail Mahasiswa')

@section('content')
    <x-page-header judul="Detail Mahasiswa" deskripsi="Informasi rinci data mahasiswa" />

    <div class="card border-0 shadow-sm col-md-6">
        <div class="card-body">
            <h5 class="card-title mb-3">{{ $mahasiswa['nama'] }}</h5>
            <p class="mb-1"><strong>NIM:</strong> {{ $mahasiswa['nim'] }}</p>
            <p class="mb-1"><strong>Email:</strong> {{ $mahasiswa['email'] }}</p>
            <p class="mb-1"><strong>Angkatan:</strong> {{ $mahasiswa['angkatan'] }}</p>
            <p class="mb-3"><strong>Status:</strong> 
                <span class="badge text-bg-success">{{ $mahasiswa['status'] }}</span>
            </p>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
    </div>
@endsection