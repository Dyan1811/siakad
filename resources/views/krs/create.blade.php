<!-- 
NAME: Rian Firmansyah
NIM: 3202416045
DATE: 10/11/2026 
-->

@extends('layouts.app')

@section('title', 'Tambah KRS (Kartu Rencana Studi)')

@section('content')
<x-page-header judul="Tambah KRS (Kartu Rencana Studi"
    deskripsi="Isi data KRS baru. Pilih Mata Kuliah yang ingin diambil." />

<div class="card border-0 shadow-sm">
    <div class="card-header bg-body fw-semibold">Form Tambah KRS</div>
    <div class="card-body">
        <form method="POST" action="{{ route('krs.store') }}" novalidate>
            @csrf
            @include('krs._form')

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="{{ route('krs.index') }}"
                class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.check-mk');
    const badgeTotalSks = document.getElementById('badge-total-sks');
    const maxSks = 24;

    function hitungTotalSks() {
        let total = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) {
                total += parseInt(cb.getAttribute('data-sks')) || 0;
            }
        });

        badgeTotalSks.textContent = `Total: ${total} / ${maxSks} SKS`;

        // Ubah warna badge jika melebihi batas
        if (total > maxSks) {
            badgeTotalSks.className = 'badge bg-danger fs-6';
        } else {
            badgeTotalSks.className = 'badge bg-primary fs-6';
        }
    }

    // Jalankan penghitungan saat awal muat (untuk form edit)
    hitungTotalSks();

    // Hitung ulang setiap kali checkbox diubah
    checkboxes.forEach(cb => {
        cb.addEventListener('change', hitungTotalSks);
    });
});
</script>
@endpush