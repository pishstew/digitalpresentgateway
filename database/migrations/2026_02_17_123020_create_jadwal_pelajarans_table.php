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
    Schema::create('jadwal_pelajaran', function (Blueprint $table) {
    // Kode jam pelajaran → PRIMARY KEY
    // contoh: J001
    $table->string('kode_jam_pelajaran')->primary();

    // Hari pelajaran
    $table->string('hari');

    // Jam ke berapa (1,2,3,4 dst)
    $table->integer('jam_ke');

    // Kelas yang mengikuti
    $table->string('kelas');

    // Kode mapel yang diajarkan
    $table->string('kode_mapel');

    // Guru pengajar
    $table->string('nip');

    // FOREIGN KEY → ke tabel mapel
    $table->foreign('kode_mapel')
          ->references('kode_mapel')
          ->on('mapel')
          ->onDelete('cascade');

    // FOREIGN KEY → ke tabel guru
    $table->foreign('nip')
          ->references('nip')
          ->on('guru')
          ->onDelete('cascade');

    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_pelajarans');
    }
};
