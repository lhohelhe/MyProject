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
    'role',
    'email_verified_at',
    'xp',
    'level',
    'total_xp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
    return [
            'email_verified_at' => 'datetime',
            'xp' => 'integer',
            'level' => 'integer',
            'total_xp' => 'integer',
        ];
    }

    // Relasi
    public function hasilSimulasi()
    {
        return $this->hasMany(HasilSimulasi::class, 'user_id', 'id');
    }

    public function hasilQuiz()
    {
        return $this->hasMany(HasilQuiz::class, 'user_id', 'id');
    }

    public function userQuizProgress()
    {
        return $this->hasMany(UserQuizProgress::class, 'user_id', 'id');
    }

    public function userFlashcard()
    {
        return $this->hasMany(UserFlashcard::class, 'user_id', 'id');
    }
}