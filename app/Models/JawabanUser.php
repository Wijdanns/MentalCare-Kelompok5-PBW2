<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanUser extends Model
{
    protected $table = 'jawaban_user';

    protected $fillable = [
        'id_hasil', 
        'id_pertanyaan', 
        'id_jawaban', 
        'poin'
        ];

    public function hasilTes()
    {
        return $this->belongsTo(HasilTes::class, 'id_hasil');
    }

    public function pertanyaanPsikologis()
    {
        return $this->belongsTo(PertanyaanPsikologis::class, 'id_pertanyaan');
    }

    public function jawabanPsikologis()
    {
        return $this->belongsTo(JawabanPsikologis::class, 'id_jawaban');
    }
}