<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMateriXpClaim extends Model
{
    public $timestamps = false;

    protected $table = 'user_materi_xp_claims';

    protected $fillable = [
        'user_id',
        'id_materi',
        'xp_claimed_at',
    ];

    protected $casts = [
        'xp_claimed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi', 'id_materi');
    }
}
