<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    protected $table = 'jadwal_pelajaran';
    protected $primaryKey = 'kode_jam_pelajaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_jam_pelajaran',
        'hari',
        'jam_ke',
        'kode_mapel',
        'nip',
        'kelas'
    ];

    // relasi ke mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'kode_mapel', 'kode_mapel');
    }

    // relasi ke guru
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'nip', 'nip');
    }

    // relasi ke presensi
    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'kode_jam_pelajaran', 'kode_jam_pelajaran');
    }
}