<!-- 
NAME :Rian Firmansyah
NIM  :3202416045
DATE :10/112026
-->
<div class="mb-3">
    <x-form-input label="Kode Mata Kuliah" name="kode_mk" :value="$matakuliah->kode_mk" maxlength="10" required autofocus />
</div>

<div class="mb-3">
    <x-form-input label="Nama Mata Kuliah" name="nama_mk" :value="$matakuliah->nama_mk" maxlength="100" required />
</div>

<div class="mb-3">
    <x-form-input label="SKS" name="sks" :value="$matakuliah->sks" maxlength="10" required/>
</div>