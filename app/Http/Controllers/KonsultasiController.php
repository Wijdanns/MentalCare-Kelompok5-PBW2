<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\Psikolog;
use App\Models\JadwalPsikolog;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    /**
     * Menampilkan halaman konsultasi beserta daftar psikolog.
     */
    public function index(Request $request)
    {
        // Mengambil data psikolog untuk dikirim ke view blade
        $psikologs = Psikolog::all();

        return view('konsultasi', compact('psikologs'));
    }

    /**
     * Menyimpan data pemesanan konsultasi baru.
     */
    public function store(Request $request)
    {
        // Validasi fleksibel menyesuaikan form yang ada
        $validated =$request->validate([
            'id_psikolog' => 'nullable|exists:psikolog,id',
            'id_jadwal'   => 'nullable|exists:jadwal_psikolog,id',
            'metode'      => 'nullable|string',
            'total_biaya' => 'nullable|numeric',
        ]);

        // Jika data dikirim lengkap, simpan ke database menggunakan model buatan temanmu
        // (Otomatis mentrigger event `booted` untuk kunci jadwal & buat pembayaran)
        if (!empty($validated['id_psikolog']) && !empty($validated['id_jadwal'])) {$konsultasi = Konsultasi::create([
                'id_user'           => \Illuminate\Support\Facades\Auth::id() ?? 1,
                'id_psikolog'       => $validated['id_psikolog'],
                'id_jadwal'         => $validated['id_jadwal'],
                'metode'            => $validated['metode'] ?? 'Online',
                'status_konsultasi' => 'Menunggu Pembayaran',
                'total_biaya'       => $validated['total_biaya'] ?? 0,
            ]);

            return redirect()->route('konsultasi.konfirmasi', $konsultasi->id)
                             ->with('success', 'Pemesanan berhasil dibuat.');
        }

        return back()->with('success', 'Form berhasil diproses.');
    }

    /**
     * Halaman konfirmasi pemesanan.
     */
    public function konfirmasi($id)
    {
        $konsultasi = Konsultasi::with(['psikolog', 'jadwal', 'pembayaran'])->findOrFail($id);
        return view('konsultasi.konfirmasi', compact('konsultasi'));
    }
}