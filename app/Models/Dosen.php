<?php

/*
 * NAME : Rian Firmansyah
 * NIM  : 3202416045
 * DATE : 4/11/2026
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
