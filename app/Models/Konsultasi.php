<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    protected $table = 'konsultasi';

    protected $fillable = [
        'id_user', 'id_psikolog', 'id_jadwal',
        'metode', 'status_konsultasi', 'total_biaya',
    ];

    protected static function booted(): void
    {
        // Booking baru: kunci slot jadwal + buat tagihan pembayaran
        static::created(function (Konsultasi $konsultasi) {
            $konsultasi->jadwal()->update(['status' => 'Tidak Tersedia']);
            $konsultasi->pembayaran()->create(['status_pembayaran' => 'Pending']);
        });

        static::updated(function (Konsultasi $konsultasi) {
            // Jadwal diganti: bebaskan slot lama, kunci slot baru
            if ($konsultasi->wasChanged('id_jadwal')) {
                JadwalPsikolog::where('id', $konsultasi->getOriginal('id_jadwal'))
                    ->update(['status' => 'Tersedia']);
                $konsultasi->jadwal()->update(['status' => 'Tidak Tersedia']);
            }

            // Dibatalkan: bebaskan slot
            if ($konsultasi->wasChanged('status_konsultasi')
                && $konsultasi->status_konsultasi === 'Batal') {
                $konsultasi->jadwal()->update(['status' => 'Tersedia']);
            }
        });

        // Dihapus: bebaskan slot
        static::deleted(function (Konsultasi $konsultasi) {
            $konsultasi->jadwal()->update(['status' => 'Tersedia']);
        });
    }

    public function user()       { return $this->belongsTo(User::class, 'id_user'); }
    public function psikolog()   { return $this->belongsTo(Psikolog::class, 'id_psikolog'); }
    public function jadwal()     { return $this->belongsTo(JadwalPsikolog::class, 'id_jadwal'); }
    public function pembayaran() { return $this->hasOne(Pembayaran::class, 'id_konsultasi'); }
}