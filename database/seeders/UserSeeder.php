<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ─── ADMIN ───────────────────────────────────────
        User::create([
            'name'     => 'Admin Sekolah',
            'email'    => 'admin@sekolah.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'nip'      => null,
        ]);

        // ─── GURU ────────────────────────────────────────
        // Buat mapel dulu (karena guru butuh kode_mapel)
        Mapel::firstOrCreate(
            ['kode_mapel' => 'MTK01'],
            ['nama_mapel' => 'Matematika']
        );

        Guru::firstOrCreate(
            ['nip' => '198501012010011001'],
            [
                'nama_guru'  => 'Budi Santoso',
                'kode_mapel' => 'MTK01',
            ]
        );

        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'guru@sekolah.com',
            'password' => Hash::make('password'),
            'role'     => 'guru',
            'nip'      => '198501012010011001',
        ]);

        // ─── SISWA ───────────────────────────────────────
        User::create([
            'name'     => 'Siswa Test',
            'email'    => 'siswa@sekolah.com',
            'password' => Hash::make('password'),
            'role'     => 'siswa',
            'nip'      => null,
        ]);
    }
}