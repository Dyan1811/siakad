<?php

/**
 * NAME: Rian Firmansyah
 * NIM: 3202416045
 * DATE: 3/11/2026
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class PenggunaController extends Controller
{
    public function index(): View
    {
        $kolom = [
            'name' => 'Nama', 'email' => 'Email', 'role' => 'Peran', 'last_login_at' => 'Terakhir Login'
        ];

        // password tidak ikut diambil dari database
        $pengguna = User::orderBy('name')
            ->get(['name', 'email', 'role', 'last_login_at'])
            ->map(function ($item) {
                return [
                    'name' => $item->name,
                    'email' => $item->email,
                    'role' => $item->role,
                    'last_login_at' => $item->last_login_at 
                        ? $item->last_login_at->translatedFormat('d F Y H:i') 
                        : 'Belum Pernah Login',
                ];
            })
            ->toArray();

        return view('pengguna.index', compact('kolom', 'pengguna'));
    }
}