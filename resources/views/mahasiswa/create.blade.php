<!-- 
NAME: Rian Firmansyah
NIM: 3202416045
DATE: 9/11/2026 
-->

@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@section('content')
<x-page-header judul="Tambah Mahasiswa"
    deskripsi="Isi data Mahasiswa baru. NIM dan email harus unik." />

<div class="card border-0 shadow-sm">
    <div class="card-header bg-body fw-semibold">Form Tambah Mahasiswa</div>
    <div class="card-body">
        <form method="POST" action="{{ route('mahasiswa.store') }}" novalidate>
            @csrf
            @include('mahasiswa._form')

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="{{ route('mahasiswa.index') }}"
                class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection