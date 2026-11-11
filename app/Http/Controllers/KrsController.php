<?php
 /**
  * NAME: Rian Firmansyah
  * NIM: 3202416045
  * DATE: 10/11/2026
  */
namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class KrsController extends Controller
{
    /**
     * Menyediakan data dummy mahasiswa
     */
    public function index(): View
    {
        return view('krs.index');
    }

    public function data(): JsonResponse
    {
        // Menggunakan relasi mahasiswa() dari model Krs.php
        $query = Krs::with('mahasiswa')->select('krs.*');

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('nama_mahasiswa', function (Krs $krs) {
                // Tampilkan Nama Mahasiswa
                if ($krs->mahasiswa) {
                    return $krs->mahasiswa->nama;
                }
                return '-';
            })
            ->addColumn('aksi', function (Krs $krs) {
                return view('krs._aksi', compact('krs'))->render();
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function create(): View
    {
        return view('krs.create', [
            'krs' => new Krs(),
            'mahasiswa' => Mahasiswa::all(), // Data Dropdown Mahasiswa
            'matakuliah' => Matakuliah::all(), // Data Checkbox Mata Kuliah
            'selectedMatakuliah' =>[]
        ]);
    }

    Public function store(Request $request): RedirectResponse
    {
        // Validasi Input Data
        $validated = $this->validated($request);

        // Validasi Batas SKS (Maksimal 24 SKS)
        $selectedMkIds = $request->input('mata_kuliah_ids', []);
        $totalSks = Matakuliah::whereIn('id', $selectedMkIds)->sum('sks');
        $maxSks = 24;

        if ($totalSks > $maxSks) {
            return back()
                ->withInput()
                ->withErrors([
                    'mata_kuliah_ids' => "Total SKS yang dipilih ({$totalSks} SKS) melebihi batas maksimal yang diperbolehkan ({$maxSks} SKS)."
                ]);
        }

        // Simpan Header data KRS
        $krs = Krs::create($validated);

        // Simpan Relasi Pivot Detail KRS
        if (!empty($selectedMkIds)) {
            $krs->matakuliah()->attach($selectedMkIds);
        }

        return redirect()
            ->route('krs.index')
            ->with('success', 'Data KRS ' . $krs->mahasiswa->nama . ' berhasil ditambahkan.');
    }

    public function show(Krs $krs): View
    {
        // Eager load relasi Mahasiswa dan Matakuliah
        $krs->load(['mahasiswa', 'matakuliah']);
        return view('krs.show', compact('krs'));
    }

    public function edit(Krs $krs): View
    {
            return view('krs.edit', [
                'krs' => $krs,
                'mahasiswa' => Mahasiswa::all(),
                'matakuliah' => Matakuliah::all(),
                // Ambil array ID mata kuliah yang sudah terpilih di DB
                'selectedMatakuliah' => $krs->matakuliah->pluck('id')->toArray()
            ]);
    }

    public function update(Request $request, Krs $krs): RedirectResponse
    {
        // Validasi Input Dasar
        $validated = $this->validated($request, $krs);

        // Validasi Batas SKS (Maksimal 24 SKS)
        $selectedMkIds = $request->input('mata_kuliah_ids', []);
        $totalSks = Matakuliah::whereIn('id', $selectedMkIds)->sum('sks');
        $maxSks = 24;

        if ($totalSks > $maxSks) {
            return back()
                ->withInput()
                ->withErrors([
                    'mata_kuliah_ids' => "Total SKS yang dipilih ({$totalSks} SKS) melebihi batas maksimal yang diperbolehkan ({$maxSks} SKS)."
                ]);
        }

        // Update header data KRS
        $krs->update($validated);

        // Sync Relasi Pivot Detail KRS
        $krs->mataKuliah()->sync($selectedMkIds);

        return redirect()
            ->route('krs.index')
            ->with('success', 'Data KRS ' . $krs->mahasiswa->nama . ' berhasil diperbarui.');
    }

    public function destroy(Krs $krs): JsonResponse
    {
        try {
            $krs->delete();
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Data KRS '. $krs->mahasiswa->nama . ' tidak dapat dihapus: masih dipakai data lain.',
            ], 409);
        }

        return response()->json([
            'message' => 'Data KRS ' . $krs->mahasiswa->nama . ' berhasil dihapus.',
        ]);
    }

    /** Aturan validasi bersama untuk store dan update. */
    private function validated(Request $request, ?Krs $krs = null): array
    {
        return $request->validate([
            'mahasiswa_id' => ['required', 'exists:mahasiswa,id',
                Rule::unique('krs')->where(function ($query) use ($request) {
                    return $query->where('tahun_akademik', $request->tahun_akademik)
                                 ->where('semester', $request->semester);
                })->ignore($krs?->id),
            ],
            'tahun_akademik' => ['required', 'string', 'max:9'],
            'semester' => ['required', 'string', 'max:6'],
            'status' => ['required', 'string', 'max:10'],
            'mata_kuliah_ids' => ['nullable', 'array'],
            'mata_kuliah_ids.*' => ['exists:mata_kuliah,id'], 
        ], [
            'mahasiswa_id.unique' => 'Mahasiswa tersebut sudah memiliki data KRS pada Tahun Akademik dan Semester ini.',
            'mahasiswa_id.exists' => 'Data Mahasiswa tidak ditemukan di database.',
            'mahasiswa_id.required' => 'ID Mahasiswa wajib diisi.',
            'mahasiswa_id.max' => 'ID Maksimal 100 karakter.',
            'tahun_akademik.required' => 'Tahun Akademik wajib diisi.',
            'Tahun_akademik.max' => 'Tahun Akademik maksimal 9 karakter.',
            'semester.required' => 'Semester harus diisi.',
            'semester.max' => 'Semester maksimal 6 karakter.',
            'status.required' => 'Status wajib diisi.',
            'status.max' => 'Status maksimal 10 karakter.',
        ]);
    }
}