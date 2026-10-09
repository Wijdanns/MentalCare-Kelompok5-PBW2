<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'id_konsultasi', 'metode_pembayaran',
        'waktu_pembayaran', 'status_pembayaran',
    ];

    protected $casts = [
        'waktu_pembayaran' => 'datetime',
    ];

    protected static function booted(): void
    {
        // Pembayaran berhasil tanpa waktu: isi otomatis dengan waktu sekarang
        static::saving(function (Pembayaran $pembayaran) {
            if ($pembayaran->status_pembayaran === 'Berhasil' && ! $pembayaran->waktu_pembayaran) {
                $pembayaran->waktu_pembayaran = now();
            }
        });

        // Pembayaran berhasil: konsultasi yang menunggu jadi Dikonfirmasi
        static::saved(function (Pembayaran $pembayaran) {
            if ($pembayaran->status_pembayaran === 'Berhasil') {
                $pembayaran->konsultasi()
                    ->where('status_konsultasi', 'Menunggu Pembayaran')
                    ->update(['status_konsultasi' => 'Dikonfirmasi']);
            }
        });
    }

    public function konsultasi() { return $this->belongsTo(Konsultasi::class, 'id_konsultasi'); }
}