<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMateriProgress extends Model
{
    protected $table = 'user_materi_progress';

    protected $fillable = [
        'user_id',
        'id_bab',
        'max_subbab_index',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bab()
    {
        return $this->belongsTo(Bab::class, 'id_bab', 'id_bab');
    }
}
