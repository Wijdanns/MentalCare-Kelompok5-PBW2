<?php

namespace App\Http\Controllers;

use App\Models\JadwalPsikolog;
use App\Models\Konsultasi;
use App\Models\Pembayaran;
use App\Models\Psikolog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KonsultasiController extends Controller
{
    public function index()
    {
        $psikologs = Psikolog::query()
            ->with(['jadwalTersedia' => function ($q) {
                $q->orderBy('tanggal')->orderBy('jam_mulai');
            }])
            ->get()
            ->each(function ($p) {
                // Dipakai di view: ->tersedia
                $p->tersedia = $p->jadwalTersedia->isNotEmpty();
            });

        return view('konsultasi.index', compact('psikologs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_psikolog'       => ['required', 'exists:psikolog,id'],
            'id_jadwal'         => ['required', 'exists:jadwal_psikolog,id'],
            'metode'            => ['nullable', 'in:Online,Offline'],
            'nama'              => ['required', 'string', 'max:255'],
            'alamat'            => ['nullable', 'string'],
            'email'             => ['required', 'email'],
            'jenis_kelamin'     => ['nullable', 'in:Laki-laki,Perempuan'],
            'usia'              => ['nullable', 'integer', 'min:1', 'max:150'],
            'metode_pembayaran' => ['required', 'in:Transfer Bank,E-Wallet'],
        ]);

        $psikolog = Psikolog::findOrFail($data['id_psikolog']);

        $jadwal = JadwalPsikolog::where('id', $data['id_jadwal'])
            ->where('id_psikolog', $psikolog->id)
            ->where('status', 'Tersedia')
            ->firstOrFail();

        $konsultasi = DB::transaction(function () use ($data, $psikolog, $jadwal) {
            $konsultasi = Konsultasi::create([
                'id_user'           => Auth::id(),
                'id_psikolog'       => $psikolog->id,
                'id_jadwal'         => $jadwal->id,
                'status_konsultasi' => 'Menunggu Pembayaran',
                'total_biaya'       => $psikolog->biaya,
            ]);

            Pembayaran::create([
                'id_konsultasi'     => $konsultasi->id,
                'metode_pembayaran' => $data['metode_pembayaran'],
                'status_pembayaran' => 'Pending',
            ]);

            // Tandai jadwal sudah diambil
            $jadwal->update(['status' => 'Tidak Tersedia']);

            return $konsultasi;
        });

        if ($request->wantsJson()) {
            return response()->json([
                'success'  => true,
                'id'       => $konsultasi->id,
                'redirect' => route('konsultasi.konfirmasi', $konsultasi),
            ]);
        }

        return redirect()
            ->route('konsultasi.konfirmasi', $konsultasi)
            ->with('success', 'Konsultasi berhasil dibuat. Lanjutkan pembayaran.');
    }

    public function konfirmasi(Konsultasi $konsultasi)
    {
        abort_unless($konsultasi->id_user === Auth::id(), 403);

        $konsultasi->load(['psikolog', 'jadwal', 'pembayaran']);

        return view('konsultasi.konfirmasi', compact('konsultasi'));
    }

    public function dashboardPasien()
    {
        // Ambil riwayat konsultasi milik pasien yang sedang login lengkap dengan psikolog dan ulasannya
        $riwayatKonsultasi = Konsultasi::where('id_user', Auth::id())
            ->with(['psikolog', 'reviewPsikolog', 'pembayaran'])
            ->latest()
            ->get();

        return view('pasien.dashboard', compact('riwayatKonsultasi'));
    }
}