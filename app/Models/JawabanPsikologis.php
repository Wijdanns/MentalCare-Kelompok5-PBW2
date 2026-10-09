<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanPsikologis extends Model
{
    protected $table = 'jawaban_psikologis';

    protected $fillable = [
        'id_pertanyaan', 
        'jawaban', 
        'poin'
        ];

    public function pertanyaanPsikologis()
    {
        return $this->belongsTo(PertanyaanPsikologis::class, 'id_pertanyaan');
    }
}