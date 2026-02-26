<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapel';
    protected $primaryKey = 'kode_mapel';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_mapel',
        'nama_mapel'
    ];

    // mapel punya banyak guru
    public function guru()
    {
        return $this->hasMany(Guru::class, 'kode_mapel', 'kode_mapel');
    }

    // mapel punya banyak jadwal
    public function jadwal()
    {
        return $this->hasMany(JadwalPelajaran::class, 'kode_mapel', 'kode_mapel');
    }
}