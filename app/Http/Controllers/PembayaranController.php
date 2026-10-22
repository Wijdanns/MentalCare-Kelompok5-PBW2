<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    /**
     * Pasien konfirmasi "Saya sudah bayar".
     */
    public function konfirmasi(Request $request, Konsultasi $konsultasi)
    {
        abort_unless((int) $konsultasi->id_user === (int) Auth::id(), 403);

        DB::transaction(function () use ($konsultasi) {
            $pembayaran = Pembayaran::firstOrCreate(
                ['id_konsultasi' => $konsultasi->id],
                ['status_pembayaran' => 'Pending']
            );

            $pembayaran->update([
                'status_pembayaran' => 'Berhasil',
                'waktu_pembayaran'  => now(),
            ]);

            $konsultasi->update([
                'status_konsultasi' => 'Dikonfirmasi',
            ]);
        });

        if ($request->wantsJson()) {
            return response()->json([
                'success'  => true,
                'redirect' => route('konsultasi.konfirmasi', $konsultasi),
            ]);
        }

        return redirect()
            ->route('konsultasi.konfirmasi', $konsultasi)
            ->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    /**
     * (Opsional) Admin/sistem menandai pembayaran gagal.
     */
    public function gagal(Request $request, Konsultasi $konsultasi)
    {
        abort_unless((int) $konsultasi->id_user === (int) Auth::id(), 403);

        $pembayaran = Pembayaran::where('id_konsultasi', $konsultasi->id)->firstOrFail();
        $pembayaran->update(['status_pembayaran' => 'Gagal']);

        return back()->with('error', 'Pembayaran ditandai gagal.');
    }
}