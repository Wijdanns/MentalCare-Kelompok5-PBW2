<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PertanyaanPsikologis extends Model
{
    protected $table = 'pertanyaan_psikologis';

    protected $fillable = [
        'id_tes',
        'pertanyaan',
        'jawaban',
        'bobot_nilai',
    ];

    public function tesPsikologis()
    {
        return $this->belongsTo(TesPsikologis::class, 'id_tes');
    }
}
