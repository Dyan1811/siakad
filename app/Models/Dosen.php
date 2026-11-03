<?php

/*
 * Nama : Rian Firmansyah
 * NIM  : 3202416045
 * Deskripsi : Menambahkan jabatan_fungsional kedalam fillable setelah alamat.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    /** @use HasFactory<\Database\Factories\DosenFactory> */
    use HasFactory;

    protected $table = 'dosen';

    protected $fillable = [
        'nidn',
        'nama',
        'email',
        'telepon',
        'alamat',
        'jabatan_fungsional',
    ];
}
