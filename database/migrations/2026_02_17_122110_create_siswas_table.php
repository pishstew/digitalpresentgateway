<?php

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
  Schema::create('siswa', function (Blueprint $table) {

    // Kolom NIS → sebagai PRIMARY KEY (identitas unik siswa)
    $table->string('nis')->primary();

    // Nama siswa
    $table->string('nama_siswa');

    // Kelas siswa (contoh: X RPL 1)
    $table->string('kelas');

    // created_at & updated_at (otomatis dari Laravel)
    $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
