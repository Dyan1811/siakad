<?php
/**
 * NAME: Rian Firmansyah
 * NIM: 3202416045
 * DATE: 10/11/2026
 */
namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class MatakuliahController extends Controller
{
    public function index(): View
    {
        return view('matakuliah.index');
    }

    public function data(): JsonResponse
    {
        $query = Matakuliah::query()->select(['id', 'kode_mk', 'nama_mk', 'sks']);

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('aksi', function (Matakuliah $matakuliah) {
                return view('matakuliah._aksi', compact('matakuliah'))->render();
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function create(): View
    {
        return view('matakuliah.create', ['matakuliah' => new Matakuliah()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $matakuliah = Matakuliah::create($this->validated($request));

        return redirect()
            ->route('matakuliah.index')
            ->with('success', 'Data Mata Kuliah ' . $matakuliah->nama_mk . ' berhasil ditambahkan.',);
    }

    public function show(Matakuliah $matakuliah): View
    {
        return view('matakuliah.show', compact('matakuliah'));
    }

    public function edit(Matakuliah $matakuliah): View
    {
        return view('matakuliah.edit', compact('matakuliah'));
    }

    public function update(Request $request, Matakuliah $matakuliah): RedirectResponse
    {
        $matakuliah->update($this->validated($request, $matakuliah));

        return redirect()
            ->route('matakuliah.index')
            ->with('success', 'Data Matakuliah ' . $matakuliah->nama_mk . ' berhasil diperbarui.');
    }

    public function destroy(Matakuliah $matakuliah): JsonResponse
    {
        try {
            $matakuliah->delete();
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Data matakuliah tidak dapat dihapus: masih dipakai data lain.',
            ], 409);
        }

        return response()->json([
            'message' => 'Data mata kuliah ' . $matakuliah->nama_mk . ' berhasil dihapus.',
        ]);
    }

    private function validated(Request $request, ?Matakuliah $matakuliah = null): array
    {
        return $request->validate([
            'kode_mk' => ['required', 'string', 'max:10',
                Rule::unique(Matakuliah::class, 'kode_mk')->ignore($matakuliah?->id)],
            'nama_mk' => ['required', 'string', 'max:100'],
            'sks' =>['required', 'string', 'max:10'],
        ], [
            'kode_mk.required' => 'Kode Mata Kuliah Wajib diisi.',
            'kode_mk.max' => 'Kode Mata Kuliah maksimal 10 karakter.',
            'kode_mk.unique' => 'Kode Mata Kuliah sudah dipakai matakuliah lain.',
            'nama_mk.required' => 'Nama Mata Kuliah wajib diisi.',
            'nama_mk.max' => 'Nama Mata Kuliah maksimal 100 karakter.',
            'sks.required' => 'SKS wajib diisi.',
            'sks.max' => 'SKS maksimal 10 karakter.', 
        ]);
    }
}