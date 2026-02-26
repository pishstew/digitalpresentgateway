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
    Schema::create('mapel', function (Blueprint $table) {
    // Kode mapel → PRIMARY KEY
    // contoh: MTK01, IND02
    $table->string('kode_mapel')->primary();

    // Nama mata pelajaran
    $table->string('nama_mapel');

    // waktu dibuat & update
    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapels');
    }
};
