<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flashcard extends Model
{
    use HasFactory;

    protected $table = 'flashcard';
    protected $primaryKey = 'id_flashcard';
    public $timestamps = true;

    protected $fillable = [
        'id_subbab',
        'pertanyaan',
        'jawaban'
    ];

    // Relasi
    public function subab()
    {
        return $this->belongsTo(Subab::class, 'id_subbab', 'id_subbab');
    }

    public function userFlashcard()
    {
        return $this->hasMany(UserFlashcard::class, 'id_flashcard', 'id_flashcard');
    }
}
