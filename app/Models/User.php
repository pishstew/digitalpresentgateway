<?php

namespace App\Models;

use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',       // admin | guru | walikelas | kakon | siswa
        'nip',        // relasi ke tabel guru (nullable)
        'is_active',  // 1 = aktif, 0 = nonaktif
        'walikelas', // hanya diisi jika role = walikelas: 'XI SIJA 1' / 'XI SIJA 2'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // Relasi ke tabel guru via NIP
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'nip', 'nip');
    }
}