<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Psikolog extends Model
{
    protected $table = 'psikolog';

    protected $fillable = [
        'nama', 'email', 'spesialis',
        'deskripsi_psikolog', 'foto_profil', 'biaya',
    ];

    protected $casts = [
        'biaya' => 'decimal:2',
    ];

    // Slot yang masih bisa dipesan: status Tersedia dan belum lewat
    public function jadwalTersedia()
    {
        return $this->hasMany(JadwalPsikolog::class, 'id_psikolog')
            ->where('status', 'Tersedia')
            ->where(function ($q) {
                $q->whereDate('tanggal', '>', today())
                  ->orWhere(fn ($q2) => $q2
                      ->whereDate('tanggal', today())
                      ->whereTime('jam_mulai', '>', now()->format('H:i:s')));
            })
            ->orderBy('tanggal')
            ->orderBy('jam_mulai');
    }

    public function jadwal()     { return $this->hasMany(JadwalPsikolog::class, 'id_psikolog'); }
    public function konsultasi() { return $this->hasMany(Konsultasi::class, 'id_psikolog'); }

    // ---- Alias nama field agar cocok dengan komponen FE ----

    protected function spesialisasi(): Attribute
    {
        return Attribute::get(fn () => $this->spesialis);
    }

    protected function tarif(): Attribute
    {
        return Attribute::get(fn () => (int) $this->biaya);
    }

    protected function foto(): Attribute
    {
        return Attribute::get(fn () => $this->foto_profil
            ? asset('storage/' . $this->foto_profil)
            : asset('images/default-psikolog.svg'));
    }
}