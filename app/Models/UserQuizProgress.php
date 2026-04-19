<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserQuizProgress extends Model
{
    use HasFactory;

    protected $table = 'user_quiz_progress';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'id_bab',
        'difficulty_level',
        'streak_hari',
        'last_quiz_date'
    ];

    protected $casts = [
        'difficulty_level' => 'string',
        'last_quiz_date' => 'date',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bab()
    {
        return $this->belongsTo(Bab::class, 'id_bab', 'id_bab');
    }
}
