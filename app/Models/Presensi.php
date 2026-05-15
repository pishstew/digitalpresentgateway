<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensi';
    protected $primaryKey = 'kode_presensi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_presensi',
        'tanggal',
        'kode_jam_pelajaran',
        'jam_masuk',
        'status',
        'nis',
        'token'
    ];

    // relasi ke siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }

    // relasi ke jadwal
    public function jadwal()
    {
        return $this->belongsTo(JadwalPelajaran::class, 'kode_jam_pelajaran', 'kode_jam_pelajaran');
    }
}