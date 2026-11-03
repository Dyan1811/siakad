<?php

/*
 * Nama : Rian Firmansyah
 * NIM  : 3202416045
 * Deskripsi : Isi agar KrsSeeder mengambil 10 Mahasiswa pertama, masing-masing memilih 5 mata kuliah acak
 *             dan menghubungkan mata kuliah secara acak ke KRS  
 */
namespace Database\Seeders;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil 10 Mahasiswa pertama
        $mahasiswa = Mahasiswa::take(10)->get();

        foreach ($mahasiswa as $mhs) {
            // Buat data KRS
            $krs = Krs::firstOrCreate([
                'mahasiswa_id' => $mhs->id,
                'tahun_akademik' => '2026/2027',
                'semester' => 'Ganjil',
            ]);

            // Ambil 5 ID mata kuliah secara acak
            $ids = MataKuliah::inRandomOrder()->limit(5)->pluck('id');

            // Hubungkan mata kuliah secara acak ke KRS
            $krs->mataKuliah()->attach($ids);
        }
    }
}
