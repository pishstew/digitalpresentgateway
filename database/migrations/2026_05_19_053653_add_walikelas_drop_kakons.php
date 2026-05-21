<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── 1. Tambah kolom walikelas ke tabel users ───────────────────────
        Schema::table('users', function (Blueprint $table) {
            $table->string('walikelas')->nullable()->after('is_active');
            // nilai: 'XI SIJA 1', 'XI SIJA 2', atau NULL
        });

        // ── 2. Hapus tabel kakons (sudah tidak dipakai) ─────────────────────
        Schema::dropIfExists('kakons');
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('walikelas');
        });

        // Recreate kakons jika rollback
        Schema::create('kakons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nip')->unique()->nullable();
            $table->string('nama_kakon');
            $table->string('no_hp')->nullable();
            $table->timestamps();
        });
    }
};