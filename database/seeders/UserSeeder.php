<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Presensi;
use App\Models\JadwalPelajaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ─── ADMIN ───────────────────────────────────────
        User::firstOrCreate(
            ['email'    => 'admin@sekolah.com'],
            [
                'name'     => 'Admin Sekolah',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'nip'      => null,
            ]
        );

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

        User::firstOrCreate(
            ['email'    => 'guru@sekolah.com'],
            [
                'name'     => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role'     => 'guru',
                'nip'      => '198501012010011001',
            ]
        );

        // ─── SISWA ───────────────────────────────────────
        \App\Models\Siswa::firstOrCreate(
            ['nis' => '12345'],
            [
                'nama_siswa' => 'Siswa Test',
                'kelas'      => 'X RPL 1',
            ]
        );

        User::firstOrCreate(
            ['email'    => 'siswa.12345@sija.sch.id'],
            [
                'name'     => 'Siswa Test',
                'password' => Hash::make('password'),
                'role'     => 'siswa',
                'nip'      => null,
            ]
        );

        // ─── JADWAL PELAJARAN (Semua Hari) ───
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        foreach ($days as $index => $day) {
            \App\Models\JadwalPelajaran::updateOrCreate(
                ['kode_jam_pelajaran' => 'JDW0' . ($index + 1)],
                [
                    'kode_mapel' => 'MTK01',
                    'nip' => '198501012010011001',
                    'kelas' => 'X RPL 1',
                    'hari' => $day,
                    'jam_ke' => '1',
                ]
            );
        }

        // ─── PRESENSI (Dummy History) ───
        Presensi::firstOrCreate(
            ['kode_presensi' => 'PR-DUMMY-01'],
            [
                'tanggal' => date('Y-m-d', strtotime('-1 day')),
                'kode_jam_pelajaran' => 'JDW07', // Minggu
                'jam_masuk' => '07:30:00',
                'status' => 'Hadir',
                'nis' => '12345',
                'token' => '1234'
            ]
        );

        Presensi::firstOrCreate(
            ['kode_presensi' => 'PR-DUMMY-02'],
            [
                'tanggal' => date('Y-m-d', strtotime('-2 days')),
                'kode_jam_pelajaran' => 'JDW06', // Sabtu
                'jam_masuk' => '08:00:00',
                'status' => 'Hadir',
                'nis' => '12345',
                'token' => '5678'
            ]
        );
    }
}