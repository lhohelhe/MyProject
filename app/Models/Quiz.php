<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quiz';
    protected $primaryKey = 'id_quiz';
    public $timestamps = true;

    protected $fillable = [
        'id_bab',
        'judul_quiz',
        'difficulty'
    ];

    protected $casts = [
        'difficulty' => 'string',
    ];

    // Relasi
    public function bab()
    {
        return $this->belongsTo(Bab::class, 'id_bab', 'id_bab');
    }

    public function soalQuiz()
    {
        return $this->hasMany(SoalQuiz::class, 'id_quiz', 'id_quiz');
    }

    public function hasilQuiz()
    {
        return $this->hasMany(HasilQuiz::class, 'id_quiz', 'id_quiz');
    }
}
