<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilTes extends Model
{
    protected $table = 'hasil_tes';

    protected $fillable = [
        'id_user',
        'id_tes',
        'total_poin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function tesPsikologis()
    {
        return $this->belongsTo(TesPsikologis::class, 'id_tes');
    }
}
