<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewPsikolog extends Model
{
    use HasFactory;

    protected $table = 'review_psikolog';

    protected $fillable = [
        'id_konsultasi',
        'id_user',
        'id_psikolog',
        'rating',
        'ulasan',
    ];

    public function konsultassi()
    {
        return $this->belongsTo(konsultasi::class, 'id_konsultasi');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function psikolog()
    {
        return $this->belongsTo(Psikolog::class, 'id_psikolog');
    }


}
