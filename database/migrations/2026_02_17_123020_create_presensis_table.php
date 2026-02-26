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
    Schema::create('presensi', function (Blueprint $table) {
    // Kode presensi → PRIMARY KEY
    // identitas unik tiap absensi
    $table->string('kode_presensi')->primary();

    // Tanggal presensi
    $table->date('tanggal');

    // Jam siswa masuk
    $table->time('jam_masuk');

    // Status kehadiran (hadir / izin / alpha)
    $table->string('status');

    // NIS siswa yang presensi
    $table->string('nis');

    // Jadwal pelajaran yang diikuti
    $table->string('kode_jam_pelajaran');

    // FOREIGN KEY → ke tabel siswa
    $table->foreign('nis')
          ->references('nis')
          ->on('siswa')
          ->onDelete('cascade');

    // FOREIGN KEY → ke tabel jadwal
    $table->foreign('kode_jam_pelajaran')
          ->references('kode_jam_pelajaran')
          ->on('jadwal_pelajaran')
          ->onDelete('cascade');

    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
