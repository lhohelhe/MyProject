<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserFlashcard extends Model
{
    use HasFactory;

    protected $table = 'user_flashcard';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'id_flashcard',
        'status'
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function flashcard()
    {
        return $this->belongsTo(Flashcard::class, 'id_flashcard', 'id_flashcard');
    }
}
