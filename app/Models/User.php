<?php

namespace App\Models;

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
    'kelas',
    'foto',
    'email_verified_at',
    ];

    protected $hidden = [
        // 'password', // ← COMMENT INI (agar password terlihat)
        'remember_token',
    ];

    protected function casts(): array
    {
    return [
            'email_verified_at' => 'datetime',
        ];
    }
}