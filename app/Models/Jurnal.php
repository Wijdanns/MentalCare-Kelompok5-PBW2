<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Jurnal extends Model
{
    protected $table = 'jurnal';

    public const MOOD = [
        'Senang' => '😊',
        'Tenang' => '😌',
        'Biasa'  => '😐',
        'Sedih'  => '😢',
        'Cemas'  => '😟',
        'Marah'  => '😠',
    ];
    
    protected $fillable = ['judul', 'isi', 'mood', 'tanggal'];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'judul' => 'encrypted',   
            'isi' => 'encrypted',
        ];
    }

    public function user() { return $this->belongsTo(User::class, 'id_user'); }

    protected function emoji(): Attribute
    {
        return Attribute::get(fn () => self::MOOD[$this->mood] ?? null);
    }

    protected function ringkasan(): Attribute
    {
        return Attribute::get(fn () => Str::limit(
            trim(preg_replace('/\s+/', ' ', $this->isi)),
            150
        ));
    }
}