<?php

/*
 * Nama : Rian Firmansyah
 * NIM  : 3202416045
 * Deskripsi : Mengisi method up() dan down()
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Mengakses tabel dosen untuk mengubah atau menambah kolom
        Schema::table('dosen', function (Blueprint $table) {
            $table->string('jabatan_fungsional')->nullable()->after('alamat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Mengakses tabel dosen untuk mengembalikan struktur ke kondisi semula
        Schema::table('dosen', function (Blueprint $table) {
            $table->dropColumn('jabatan_fungsional');
        });
    }
};
