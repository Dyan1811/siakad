<!-- 
NAME: Rian Firmansyah
NIM: 3202416045
DATE: 10/11/2025
-->

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold mb-1">Dashboard</h3>
    <p class="text-muted">Ringkasan data akademik sistem SIAKAD.</p>
</div>

<!-- KARTU STATISTIK RINGKASAN -->
<div class="row g-3 mb-4">
    <!-- Total Mahasiswa -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 fs-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">Mahasiswa</div>
                    <div class="fs-3 fw-bold text-dark">{{ number_format($totalMahasiswa, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Dosen -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 fs-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">Dosen</div>
                    <div class="fs-3 fw-bold text-dark">{{ number_format($totalDosen, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Mata Kuliah -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3 fs-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-book-fill"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">Mata Kuliah</div>
                    <div class="fs-3 fw-bold text-dark">{{ number_format($totalMatakuliah, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total KRS Terdaftar -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-dark bg-opacity-10 text-dark p-3 rounded-3 fs-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">Total KRS Terdaftar</div>
                    <div class="fs-3 fw-bold text-dark">{{ number_format($totalKrs, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- KRS Aktif -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-info bg-opacity-10 text-info p-3 rounded-3 fs-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-journal-check"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">KRS Aktif</div>
                    <div class="fs-3 fw-bold text-dark">{{ number_format($totalKrsAktif, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rata-rata SKS per KRS -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-secondary bg-opacity-10 text-secondary p-3 rounded-3 fs-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-calculator"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">Rata-rata SKS per KRS</div>
                    <div class="fs-3 fw-bold text-dark">{{ $avgSks }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TABEL 5 KRS TERBARU -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-body fw-semibold py-3">
        KRS Terbaru
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>SKS</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($krsTerbaru as $index => $krs)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <a href="{{ route('krs.show', $krs) }}" class="text-decoration-none fw-semibold">
                                    {{ $krs->mahasiswa->nim ?? '-' }}
                                </a>
                            </td>
                            <td>{{ $krs->mahasiswa->nama ?? '-' }}</td>
                            <td>{{ $krs->matakuliah->sum('sks') }}</td>
                            <td>
                                @if($krs->status === 'draft')
                                    <span class="badge bg-secondary px-3 py-2 rounded-pill">Draft</span>
                                @elseif($krs->status === 'diajukan')
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Diajukan</span>
                                @elseif($krs->status === 'disetujui')
                                    <span class="badge bg-success px-3 py-2 rounded-pill">Disetujui</span>
                                @else
                                    <span class="badge bg-danger px-3 py-2 rounded-pill">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">Belum ada data KRS terbaru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- PROGRESS BAR STATUS KRS -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-body fw-semibold py-3">
        Status KRS
    </div>
    <div class="card-body">
        <!-- Draft -->
        <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
                <span class="small fw-semibold">Draft</span>
                <span class="small text-muted">{{ $persenDraft }}%</span>
            </div>
            <div class="progress" style="height: 10px;">
                <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $persenDraft }}%" aria-valuenow="{{ $persenDraft }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <!-- Diajukan -->
        <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
                <span class="small fw-semibold">Diajukan</span>
                <span class="small text-muted">{{ $persenDiajukan }}%</span>
            </div>
            <div class="progress" style="height: 10px;">
                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $persenDiajukan }}%" aria-valuenow="{{ $persenDiajukan }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <!-- Disetujui -->
        <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
                <span class="small fw-semibold">Disetujui</span>
                <span class="small text-muted">{{ $persenDisetujui }}%</span>
            </div>
            <div class="progress" style="height: 10px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $persenDisetujui }}%" aria-valuenow="{{ $persenDisetujui }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <!-- Ditolak -->
        <div>
            <div class="d-flex justify-content-between mb-1">
                <span class="small fw-semibold">Ditolak</span>
                <span class="small text-muted">{{ $persenDitolak }}%</span>
            </div>
            <div class="progress" style="height: 10px;">
                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $persenDitolak }}%" aria-valuenow="{{ $persenDitolak }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</div>
@endsection