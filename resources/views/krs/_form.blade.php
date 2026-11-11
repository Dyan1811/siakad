<!-- 
NAME :Rian Firmansyah
NIM  :3202416045
DATE :10/112026
-->

<!-- Pilihan Mahasiswa dari Database (Bukan Input Manual) -->
<div class="mb-3">
    <label for="mahasiswa_id" class="form-label">Mahasiswa</label>
    <select id="mahasiswa_id" name="mahasiswa_id" class="form-select @error('mahasiswa_id') is-invalid @enderror" required>
        <option value="">-- Pilih Mahasiswa --</option>
        @foreach ($mahasiswa as $m)
            <option value="{{ $m->id }}" {{ old('mahasiswa_id', $krs->mahasiswa_id) == $m->id ? 'selected' : '' }}>
                {{ $m->nim }} - {{ $m->nama }}
            </option>
        @endforeach
    </select>
    @error('mahasiswa_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Input Tahun Akademik -->
<div class="mb-3">
    <label for="tahun_akademik" class="form-label fw-semibold">Tahun Akademik</label>
    <input type="text" name="tahun_akademik" class="form-control @error('tahun_akademik') is-invalid @enderror" 
          value="{{ old('tahun_akademik', $krs->tahun_akademik) }}" placeholder="2026/2027" required>
    @error('tahun_akademik')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Dropdown Semester -->
<div class="mb-3">
    <label for="semester" class="form-label fw-semibold">Semester</label>
    <select id="semester" name="semester" class="form-select @error('semester') is-invalid @enderror" required>
        <option value="">-- Pilih Semester --</option>
        @foreach (['Ganjil', 'Genap'] as $s)
            <option value="{{ $s }}" {{ old('semester', $krs->semester) === $s ? 'selected' : '' }}>
                {{ $s }}
            </option>
        @endforeach
    </select>
    @error('semester')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Dropdown Status -->
<div class="mb-3">
    <label for="status" class="form-label fw-semibold">Status</label>
    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
        <option value="">-- Pilih Status --</option>
        @foreach (['draft', 'diajukan', 'disetujui', 'ditolak'] as $st)
            <option value="{{ $st }}" {{ old('status', $krs->status) === $st ? 'selected' : '' }}>
                {{ $st }}
            </option>
        @endforeach
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Pilihan Mata Kuliah dengan Counter SKS -->
<div class="mb-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <label class="form-label fw-bold mb-0">Pilih Mata Kuliah</label>
        <!-- Indikator Total SKS Real-time -->
        <span class="badge bg-primary fs-6" id="badge-total-sks">Total: 0 / 24 SKS</span>
    </div>

    <div class="border rounded p-3 bg-light @error('mata_kuliah_ids') border-danger @enderror" style="max-height: 250px; overflow-y: auto;">
        @forelse ($matakuliah as $mk)
            @php
                $selected = old('mata_kuliah_ids', $selectedMatakuliah ?? []);
                $checked = in_array($mk->id, (array) $selected);
            @endphp
            <div class="form-check mb-2">
                <input class="form-check-input check-mk" 
                       type="checkbox" 
                       name="mata_kuliah_ids[]" 
                       value="{{ $mk->id }}" 
                       data-sks="{{ $mk->sks }}" 
                       id="mk_{{ $mk->id }}" 
                       {{ $checked ? 'checked' : '' }}>
                <label class="form-check-label" for="mk_{{ $mk->id }}">
                    <strong>{{ $mk->kode_mk }}</strong> - {{ $mk->nama_mk }} ({{ $mk->sks }} SKS)
                </label>
            </div>
        @empty
            <p class="text-muted mb-0">Belum ada data Mata Kuliah.</p>
        @endforelse
    </div>

    <!-- Pesan Error Validasi dari Controller -->
    @error('mata_kuliah_ids')
        <div class="text-danger small mt-1 fw-semibold">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ $message }}
        </div>
    @enderror
</div>

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