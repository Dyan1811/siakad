<!-- 
NAME: Rian Firmansyah
NIM: 3202416045
DATE: 10/11/2026
-->

@extends('layouts.app')

@section('title', 'Detail KRS (Kartu Rencana Studi)')

@section('content')
    <x-page-header judul="Detail KRS" deskripsi="Informasi lengkap satu KRS Mahasiswa." />

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-body fw-semibold">{{ $krs->mahasiswa->nama }}</div>
        <div class="card-body">
            <dl class="row mb-3">
                <dt class="col-sm-3">ID Mahasiswa</dt>
                <dd class="col-sm-9">{{ $krs->mahasiswa_id }}</dd>

                <dt class="col-sm-3">NIM Mahasiswa</dt>
                <dd class="col-sm-9">{{ $krs->mahasiswa->nim ?? '-' }}</dd>

                <dt class="col-sm-3">Nama Mahasiswa</dt>
                <dd class="col-sm-9">{{ $krs->mahasiswa->nama ?? '-' }}</dd>

                <dt class="col-sm-3">Tahun Akademik</dt>
                <dd class="col-sm-9">{{ $krs->tahun_akademik }}</dd>

                <dt class="col-sm-3">Semester</dt>
                <dd class="col-sm-9">{{ $krs->semester }}</dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">{{ ucfirst($krs->status) }}</dd>
            </dl>
        </div>
    </div>

    <!-- Tabel KRS Detail (Mata Kuliah yang Diambil) -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-body fw-semibold d-flex justify-content-between align-items-center">
            <span>Daftar Mata Kuliah</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">No.</th>
                            <th>Kode Mata Kuliah</th>
                            <th>Nama Mata Kuliah</th>
                            <th class="text-center" style="width: 100px;">SKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($krs->matakuliah as $index => $mk)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $mk->kode_mk }}</td>
                                <td>{{ $mk->nama_mk }}</td>
                                <td class="text-center">{{ $mk->sks }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Belum ada mata kuliah yang dipilih.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold table-light">
                            <td colspan="3" class="text-end">Total SKS Diambil:</td>
                            <td class="text-center">{{ $krs->matakuliah->sum('sks') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <a href="{{ route('krs.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            @if (Auth::user()->role === 'admin')
                <a href="{{ route('krs.edit', $krs) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Ubah
                </a>
            @endif  
        </div>
    </div>
@endsection