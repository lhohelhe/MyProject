<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SoalSimulasi extends Model
{
    use HasFactory;

    protected $table = 'soal_simulasi';
    protected $primaryKey = 'id_soal';
    public $timestamps = true;

    protected $fillable = [
        'id_simulasi',
        'pertanyaan',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'kunci_jawaban',
        'pembahasan'
    ];

    protected $casts = [
        'kunci_jawaban' => 'string',
    ];

    // Relasi
    public function simulasi()
    {
        return $this->belongsTo(Simulasi::class, 'id_simulasi', 'id_simulasi');
    }
}
