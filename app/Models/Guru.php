<?php

namespace App\Models;

use App\Models\User; // TAMBAH INI
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'nip',
        'nama_guru',
        'kode_mapel'
    ];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'kode_mapel', 'kode_mapel');
    }

    // RELASI KE USER
    public function user()
    {
        return $this->hasOne(User::class, 'nip', 'nip');
    }
}