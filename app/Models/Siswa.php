<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'nis';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nis',
        'nama_siswa',
        'kelas'
    ];

    // relasi → siswa punya banyak presensi
    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'nis', 'nis');
    }
}