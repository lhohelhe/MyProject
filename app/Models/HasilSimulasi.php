<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilSimulasi extends Model
{
    use HasFactory;

    protected $table = 'hasil_simulasi';
    protected $primaryKey = 'id_hasil';
    public $timestamps = true;

    protected $fillable = [
        'id_simulasi',
        'user_id',
        'skor',
        'jumlah_benar',
        'jumlah_salah',
        'jumlah_kosong',
        'lulus',
        'waktu_mulai',
        'waktu_selesai'
    ];

    protected $casts = [
        'skor' => 'decimal:2',
        'lulus' => 'boolean',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    // Relasi
    public function simulasi()
    {
        return $this->belongsTo(Simulasi::class, 'id_simulasi', 'id_simulasi');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
