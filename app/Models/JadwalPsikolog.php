<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPsikolog extends Model
{
    protected $table = 'jadwal_psikolog';

    protected $fillable = [
        'id_psikolog',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    public function psikolog()
    {
        return $this->belongsTo(Psikolog::class, 'id_psikolog');
    }

    public function konsultasi()
    {
        return $this->hasOne(Konsultasi::class, 'id_jadwal');
    }
}
