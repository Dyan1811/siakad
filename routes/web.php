<?php

 /**
  * NAME: Rian Firmansyah
  * NIM: 3202416045
  * DATE: 29/10/2026
  */
    
    use App\Http\Controllers\Auth\LoginController;
    use App\Http\Controllers\BerandaController; 
    use App\Http\Controllers\DashboardController;  
    use App\Http\Controllers\DosenController; 
    use App\Http\Controllers\KrsController; 
    use App\Http\Controllers\MahasiswaController;
    use App\Http\Controllers\MatakuliahController;
    use App\Http\Controllers\PenggunaController; 
    use Illuminate\Support\Facades\Route; 

    
    // Halaman untuk tamu: hanya bisa dibuka bila BELUM login
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'authenticate'])->name('login.attempt');
    });

    // Halaman internal: hanya bisa dibuka bila SUDAH login
    Route::middleware('auth')->group(function () {
        // Halaman awal diarahkan ke dashboard (dari Jobsheet 08)
        Route::get('/', fn () => redirect()->route('dashboard'));
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index']) -> name('dashboard');
        Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        Route::get('/dosen', [DosenController::class, 'index'])->name('dosen.index');
        Route::get('/matakuliah', [MatakuliahController::class, 'index'])->name('matakuliah.index');
        Route::get('/krs', [KrsController::class, 'index'])->name('krs.index');

        // Dari Jobsheet 07: menampilkan versi PHP/Mysql dan nama database, jadi dilindungi
        Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
        Route::get('/pengguna', [PenggunaController::class, 'index'])->middleware('role:admin')->name('pengguna.index');

        Route::get('/mahasiswa/{nim}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
    });
