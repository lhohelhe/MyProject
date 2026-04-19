<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilQuiz extends Model
{
    use HasFactory;

    protected $table = 'hasil_quiz';
    protected $primaryKey = 'id_hasil_quiz';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'id_quiz',
        'skor',
        'jumlah_benar',
        'total_soal',
        'difficulty_saat_ini',
        'xp_didapat'
    ];

    protected $casts = [
        'difficulty_saat_ini' => 'string',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'id_quiz', 'id_quiz');
    }
}
