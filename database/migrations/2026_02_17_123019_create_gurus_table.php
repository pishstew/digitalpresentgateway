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
    Schema::create('guru', function (Blueprint $table) {

    // NIP → PRIMARY KEY guru
    $table->string('nip')->primary();

    // Nama guru
    $table->string('nama_guru');

    // Kolom untuk menyimpan kode mapel yang diajar guru
    $table->string('kode_mapel');

    // FOREIGN KEY → relasi ke tabel mapel
    // artinya guru harus punya mapel
    $table->foreign('kode_mapel')
          ->references('kode_mapel') // kolom di tabel mapel
          ->on('mapel')              // tabel tujuan
          ->onDelete('cascade');     // kalau mapel dihapus → guru ikut terhapus

    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
