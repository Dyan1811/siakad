<?php

 /**
  * NAME: Rian Firmansyah
  * NIM: 3202416045
  * DATE: 10/11/2026
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

    // gabungkan dibawah sini bersama auth
    Route::middleware('auth', 'prevent-back-history')->group(function () {
        // Halaman awal diarahkan ke dashboard (dari Jobsheet 08)
        Route::get('/', fn () => redirect()->route('dashboard'));
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index']) -> name('dashboard');
        Route::get('/dosen/data', [DosenController::class, 'data'])->name('dosen.data');
        Route::get('/mahasiswa/data', [MahasiswaController::class, 'data']) -> name('mahasiswa.data');
        Route::get('/matakuliah/data', [MatakuliahController::class, 'data']) -> name('matakuliah.data');
        Route::get('/krs/data', [KrsController::class, 'data']) -> name('krs.data');

        // Dari Jobsheet 07: menampilkan versi PHP/Mysql dan nama database, jadi dilindungi
        Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
        Route::get('/pengguna', [PenggunaController::class, 'index'])->middleware('role:admin')->name('pengguna.index');

    Route::middleware('role:admin')->group(function () {
        Route::resource('dosen', DosenController::class)
            ->except(['index', 'show']);
        Route::resource('mahasiswa', MahasiswaController::class)
            ->except(['index', 'show']);
        Route::resource('matakuliah', MatakuliahController::class)
            ->except(['index', 'show']);
        Route::resource('krs', KrsController::class)
        // Menambahkan Parameters agar Laravel me-bind parameter route sebagai {krs} bukan {kr}.
            ->parameters(['krs' => 'krs']) 
            ->except(['index', 'show']);
    });

    Route::resource('dosen', DosenController::class)
        ->only(['index', 'show']);
    Route::resource('mahasiswa', MahasiswaController::class)
        ->only(['index', 'show']);
    Route::resource('matakuliah', MatakuliahController::class)
        ->only(['index', 'show']);
    Route::resource('krs', KrsController::class)
        ->parameters(['krs' => 'krs']) 
        ->only(['index', 'show']);
    });
