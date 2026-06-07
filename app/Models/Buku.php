<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    public $timestamps = true;

    protected $fillable = [
        'id_kategori',
        'judul_buku',
        'gambar',
        'semester',
        'kelas',
        'deskripsi',
        'penulis',
        'penerbit',
        'isbn',
        'edisi'
    ];

    // Relasi
    public function kategori()
    {
        return $this->belongsTo(KategoriMapel::class, 'id_kategori', 'id_kategori');
    }

    public function bab()
    {
        return $this->hasMany(Bab::class, 'id_buku', 'id_buku');
    }

    public function simulasi()
    {
        return $this->hasMany(Simulasi::class, 'id_buku', 'id_buku');
    }
}