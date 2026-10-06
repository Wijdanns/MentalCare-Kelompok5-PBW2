<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    protected $table = 'konsultasi';

    protected $fillable = [
        'id_user',
        'id_psikolog',
        'id_jadwal',
        'metode',
        'status_konsultasi',
        'total_biaya',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function psikolog()
    {
        return $this->belongsTo(Psikolog::class, 'id_psikolog');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalPsikolog::class, 'id_jadwal');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_konsultasi');
    }
}
