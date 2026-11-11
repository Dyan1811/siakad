<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MahasiswaController extends Controller
{
    /**
     * Menyediakan data dummy mahasiswa
     */
    private function getMahasiswaData(): array
    {
        return [
            ['nim' => '2401001', 'nama' => 'Ahmad Dahlan', 'angkatan' => '2024',
             'email' => 'ahmad@example.com', 'status' => 'Aktif',],
            ['nim' => '2401002', 'nama' => 'Budi Santoso', 'angkatan' => '2024',
             'email' => 'budi@example.com', 'status' => 'Aktif',],
            ['nim' => '2401003', 'nama' => 'Citra Dewi', 'angkatan' => '2024',
             'email' => 'citra@example.com', 'status' => 'Cuti',],
            ['nim' => '2401004', 'nama' => 'Deni Pratama', 'angkatan' => '2023',
             'email' => 'deni@example.com', 'status' => 'Ditolak',],
        ];
    }

    public function index(): View
    {
        $kolom = [
            'nim' => 'NIM','nama' => 'Nama Lengkap',
            'angkatan' => 'Angkatan', 'email' => 'Email',
            'status' => 'Status',
        ];

        $mahasiswa = $this->getMahasiswaData();

        return view('mahasiswa.index', compact('kolom', 'mahasiswa'));
    }

    public function show(string $nim): View
    {
        $mahasiswaList = $this->getMahasiswaData();
        $mahasiswa = collect($mahasiswaList)->firstWhere('nim', $nim);

        if (!$mahasiswa) {
            abort(404);
        }

        return view('mahasiswa.show', compact('mahasiswa'));
    }
}