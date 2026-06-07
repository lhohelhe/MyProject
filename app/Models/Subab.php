<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subab extends Model
{
    use HasFactory;

    protected $table = 'subbab';

    protected $primaryKey = 'id_subbab';

    protected $fillable = [
        'id_bab',
        'nomor_subbab',
        'judul_subbab'
    ];

    public function bab()
    {
        return $this->belongsTo(Bab::class,'id_bab','id_bab');
    }

    public function flashcard()
    {
        return $this->hasMany(Flashcard::class, 'id_subbab', 'id_subbab');
    }

    public function materi()
    {
        return $this->hasMany(Materi::class, 'id_subbab', 'id_subbab')->orderBy('id_materi');
    }
}