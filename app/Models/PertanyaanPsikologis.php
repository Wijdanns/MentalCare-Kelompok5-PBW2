<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PertanyaanPsikologis extends Model
{
    protected $table = 'pertanyaan_psikologis';

    protected $fillable = [
        'id_tes',
        'pertanyaan',
    ];

    public function tesPsikologis()
    {
        return $this->belongsTo(TesPsikologis::class, 'id_tes');
    }

    public function jawabanPsikologis()
    {
        return $this->hasMany(JawabanPsikologis::class, 'id_pertanyaan');
    }
}
