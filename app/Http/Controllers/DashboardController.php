<?php
/**
 * NAME: Rian Firmansyah
 * NIM: 3202416045
 * DATE: 10/11/2026
 */
namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Matakuliah;
use App\Models\Krs;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Hitung Total Data Ringkasan
        $totalMahasiswa  = Mahasiswa::count();
        $totalDosen      = class_exists(Dosen::class) ? Dosen::count() : 0;
        $totalMatakuliah = Matakuliah::count();
        $totalKrs        = Krs::count();
        $totalKrsAktif   = Krs::where('status', 'disetujui')->count();

        // 2. Rata-rata SKS per KRS
        $totalSksAll   = DB::table('krs_detail')
                            ->join('mata_kuliah', 'krs_detail.mata_kuliah_id', '=', 'mata_kuliah.id')
                            ->sum('mata_kuliah.sks');
                            
        $avgSks = $totalKrs > 0 ? round($totalSksAll / $totalKrs) : 0;

        // KRS Terbaru (5 Data Terakhir)
        $krsTerbaru = Krs::with(['mahasiswa', 'matakuliah'])
            ->latest()
            ->take(5)
            ->get();

        // Perhitungan Persentase Status KRS
        $draftCount = Krs::where('status', 'draft')->count();
        $diajukanCount  = Krs::where('status', 'diajukan')->count();
        $disetujuiCount = Krs::where('status', 'disetujui')->count();
        $ditolakCount   = Krs::where('status', 'ditolak')->count();

        $persenDraft = $totalKrs > 0 ? round(($draftCount / $totalKrs) * 100) : 0;
        $persenDiajukan  = $totalKrs > 0 ? round(($diajukanCount / $totalKrs) * 100) : 0;
        $persenDisetujui = $totalKrs > 0 ? round(($disetujuiCount / $totalKrs) * 100) : 0;
        $persenDitolak   = $totalKrs > 0 ? round(($ditolakCount / $totalKrs) * 100) : 0;

        return view('dashboard', compact(
            'totalMahasiswa',
            'totalDosen',
            'totalMatakuliah',
            'totalKrs',
            'totalKrsAktif',
            'avgSks',
            'krsTerbaru',
            'persenDraft',
            'persenDiajukan',
            'persenDisetujui',
            'persenDitolak'
        ));
    }
}