<!-- 
NAME :Rian Firmansyah
NIM  :3202416045
DATE :10/112026
-->

<div class="btn-group btn-group-sm" role="group">
    <a href="{{ route('krs.show', $krs) }}" class="btn btn-outline-info"
       title="Detail" aria-label="Detail {{ $krs->mahasiswa->nama }}">
        <i class="bi bi-eye"></i>
    </a>
    @if (Auth::user()->role === 'admin')
        <a href="{{ route('krs.edit', $krs) }}" class="btn btn-outline-warning"
           title="Ubah" aria-label="Ubah {{ $krs->mahasiswa->nama }}">
            <i class="bi bi-pencil-square"></i>
        </a>
        <button type="button" class="btn btn-outline-danger btn-hapus"
                data-url="{{ route('krs.destroy', $krs, false) }}"
                data-nama="{{ $krs->mahasiswa->nama }}" title="Hapus"
                aria-label="Hapus {{ $krs->mahasiswa->nama }}">
            <i class="bi bi-trash"></i>
        </button>
    @endif
</div>