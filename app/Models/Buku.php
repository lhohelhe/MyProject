<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\KategoriMapel;

class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id_buku';

    protected $fillable = [
        'id_kategori',
        'judul_buku',
        'gambar',
        'semester',
        'kelas'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriMapel::class, 'id_kategori', 'id_kategori');
    }
}