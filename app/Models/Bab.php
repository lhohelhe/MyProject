<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bab extends Model
{
    protected $table = 'bab';
    protected $primaryKey = 'id_bab';

    protected $fillable = [
        'id_buku',
        'nomor_bab',
        'judul_bab'
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    public function subab()
    {
        return $this->hasMany(Subab::class,'id_bab','id_bab')
                    ->orderBy('nomor_subbab');
    }

    public function quiz()
    {
        return $this->hasMany(Quiz::class, 'id_bab', 'id_bab');
    }

    public function userQuizProgress()
    {
        return $this->hasMany(UserQuizProgress::class, 'id_bab', 'id_bab');
    }
}