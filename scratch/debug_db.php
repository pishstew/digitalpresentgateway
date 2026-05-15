<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Presensi;
use App\Models\JadwalPelajaran;
use App\Models\Siswa;
use App\Models\User;

echo "--- USERS ---\n";
print_r(User::all(['name', 'email', 'role'])->toArray());

echo "\n--- SISWA ---\n";
print_r(Siswa::all()->toArray());

echo "\n--- JADWAL ---\n";
print_r(JadwalPelajaran::all()->toArray());

echo "\n--- PRESENSI ---\n";
print_r(Presensi::all()->toArray());
