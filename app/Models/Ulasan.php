<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'ulasan';

    // Kolom yang boleh diisi lewat create() / update()
    protected $fillable = [
        'id_user',
        'id_psikolog',
        'rating',
        'komentar',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    // Ulasan ditulis oleh satu pasien
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Ulasan ditujukan untuk satu psikolog
    public function psikolog()
    {
        return $this->belongsTo(Psikolog::class, 'id_psikolog');
    }
}