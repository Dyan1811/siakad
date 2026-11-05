<!-- 
NAME: Rian Firmansyah
NIM: 3202416045
DATE: 4/11/2026
-->

<div class="mb-3">
    <x-form-input label="NIDN" name="nidn" :value="$dosen->nidn" maxlength="20" required autofocus />
</div>

<div class="mb-3">
    <x-form-input label="Nama Dosen" name="nama" :value="$dosen->nama" maxlength="120" required />
</div>

<div class="mb-3">
    <x-form-input label="Email" name="email" type="email" :value="$dosen->email" maxlength="120" required />
</div>

<div class="mb-3">
    <x-form-input label="Telepon" name="telepon" :value="$dosen->telepon" maxlength="20" />
</div>

<div class="mb-3">
    <label for="alamat" class="form-label">Alamat</label>
    <textarea id="alamat" name="alamat" rows="3" maxlength="500"
            @class(['form-control', 'is-invalid' => $errors->has('alamat')])
    >{{ old('alamat', $dosen->alamat) }}</textarea>
    @error('alamat')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="jabatan_fungsional" class="form-label">Jabatan Fungsional</label>
    <select id="jabatan_fungsional" name="jabatan_fungsional" class="form-select @error('jabatan_fungsional') is-invalid @enderror" required>
        <option value="">-- Pilih Jabatan Fungsional --</option>
        @foreach (['Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar'] as $jf)
            <option value="{{ $jf }}" {{ old('jabatan_fungsional', $dosen->jabatan_fungsional) === $jf ? 'selected' : '' }}>
                {{ $jf }}
            </option>
        @endforeach
    </select>
    @error('jabatan_fungsional')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>