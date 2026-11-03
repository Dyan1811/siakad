<?php

/**
 * NAME: Rian Firmansyah
 * NIM: 3202416045
 * DATE: 2/11/2026
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class PenggunaController extends Controller
{
    public function index(): View
    {
        $kolom = [
            'name' => 'Nama', 'email' => 'Email', 'role' => 'Peran',
        ];

        // password tidak ikut diambil dari database
        $pengguna = User::orderBy('name')
            ->get(['name', 'email', 'role'])
            ->toArray();

        return view('pengguna.index', compact('kolom', 'pengguna'));
    }
}