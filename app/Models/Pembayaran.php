<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'id_konsultasi',
        'metode_pembayaran',
        'waktu_pembayaran',
        'bukti_pembayaran',
        'status_pembayaran',
    ];

    protected $casts = [
        'waktu_pembayaran' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::updating(function (Pembayaran $pembayaran) {
            if ($pembayaran->isDirty('status_pembayaran') && $pembayaran->status_pembayaran === 'Berhasil') {
                $pembayaran->waktu_pembayaran ??= now();
            }
        });

        static::updated(function (Pembayaran $pembayaran) {
            if ($pembayaran->wasChanged('status_pembayaran') && $pembayaran->status_pembayaran === 'Berhasil') {
                $pembayaran->konsultasi()->update([
                    'status_konsultasi' => 'Dikonfirmasi',
                ]);
            }
        });
    }

    public function konsultasi()
    {
        return $this->belongsTo(Konsultasi::class, 'id_konsultasi');
    }
}