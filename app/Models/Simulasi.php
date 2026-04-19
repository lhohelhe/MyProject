<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Simulasi extends Model
{
    use HasFactory;

    protected $table = 'simulasi';
    protected $primaryKey = 'id_simulasi';
    public $timestamps = true;

    protected $fillable = [
        'id_buku',
        'judul_simulasi',
        'durasi_menit',
        'jumlah_soal',
        'status'
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relasi
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    public function soalSimulasi()
    {
        return $this->hasMany(SoalSimulasi::class, 'id_simulasi', 'id_simulasi');
    }

    public function hasilSimulasi()
    {
        return $this->hasMany(HasilSimulasi::class, 'id_simulasi', 'id_simulasi');
    }
}
