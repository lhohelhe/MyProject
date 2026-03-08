<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriMapel extends Model
{
    protected $table = 'kategori_mapel';

    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori'
    ];
}