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
    public function subab()
    {
        return $this->hasMany(Subab::class,'id_bab','id_bab')
                    ->orderBy('nomor_subbab');
    }
}