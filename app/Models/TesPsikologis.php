<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TesPsikologis extends Model
{
    protected $table = 'tes_psikologis';

    protected $fillable = [
    'nama_tes',
    'deskripsi',
    ];

    public function pertanyaan()
    {
        return $this->hasMany(PertanyaanPsikologis::class, 'id_tes');
    }

    public function hasilTes()
    {
        return $this->hasMany(HasilTes::class, 'id_tes');
    }
}
