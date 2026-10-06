<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Psikolog extends Model
{
    protected $table = 'psikolog';

    protected $fillable = [
        'nama',
        'email',
        'spesalis',
        'deskripsi_psikolog',
        'foto_profil',
        'biaya'
    ];

    public function konsultasi()
    {
        return $this->hasMany(Konsultasi::class, 'id_psikolog');
    }
    
    public function jadwal()
    {
        return $this->hasMany(JadwalPsikolog::class, 'id_psikolog');
    }
}
