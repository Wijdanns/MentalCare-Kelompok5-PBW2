<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artikel extends Model
{
    protected $table = 'artikel';

    protected $fillable = [
        'id_user', 'id_kategori', 'judul',
        'isi', 'tanggal_publikasi', 'thumbnail',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'date',
    ];

    // Hanya artikel yang sudah waktunya terbit
    public function scopeTerbit(Builder $query): Builder
    {
        return $query->whereDate('tanggal_publikasi', '<=', today());
    }

    public function user()     { return $this->belongsTo(User::class, 'id_user'); }
    public function kategori() { return $this->belongsTo(KategoriArtikel::class, 'id_kategori'); }

    // URL thumbnail (null kalau belum ada, view yang menentukan placeholder)
    protected function gambar(): Attribute
    {
        return Attribute::get(fn () => $this->thumbnail
            ? asset('storage/' . $this->thumbnail)
            : null);
    }

    // Cuplikan teks polos dari isi (isi berupa HTML dari rich editor)
    protected function ringkasan(): Attribute
    {
        return Attribute::get(fn () => Str::limit(
            trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($this->isi)))),
            140
        ));
    }

    // Perkiraan waktu baca dalam menit (200 kata per menit)
    protected function waktuBaca(): Attribute
    {
        return Attribute::get(fn () => max(1, (int) ceil(
            str_word_count(strip_tags($this->isi)) / 200
        )));
    }
}