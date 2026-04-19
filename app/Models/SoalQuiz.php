<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SoalQuiz extends Model
{
    use HasFactory;

    protected $table = 'soal_quiz';
    protected $primaryKey = 'id_soal_quiz';
    public $timestamps = true;

    protected $fillable = [
        'id_quiz',
        'pertanyaan',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'kunci_jawaban',
        'pembahasan',
        'difficulty'
    ];

    protected $casts = [
        'kunci_jawaban' => 'string',
        'difficulty' => 'string',
    ];

    // Relasi
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'id_quiz', 'id_quiz');
    }
}
