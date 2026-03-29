<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{

    protected $table = 'materi';

    protected $primaryKey = 'id_materi';

    protected $fillable = [
        'judul_materi',
        'isi',
        'gambar',
        'id_subbab'
    ];

    public function subab()
    {
        return $this->belongsTo(Subab::class,'id_subbab','id_subbab');
    }

}