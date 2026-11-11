<!-- 
NAME: Rian Firmansyah
NIM: 3202416045
DATE: 10/11/2026 
-->

@extends('layouts.app')

@section('title', 'Tambah Mata Kuliah')

@section('content')
<x-page-header judul="Tambah Mata Kuliah"
    deskripsi="Isi data Mata Kuliah baru. Kode Mata Kuliah dan Nama Mata Kuliah harus unik." />

<div class="card border-0 shadow-sm">
    <div class="card-header bg-body fw-semibold">Form Tambah Mata Kuliah</div>
    <div class="card-body">
        <form method="POST" action="{{ route('matakuliah.store') }}" novalidate>
            @csrf
            @include('matakuliah._form')

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="{{ route('matakuliah.index') }}"
                class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection