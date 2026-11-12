<?php

namespace App\Http\Controllers;

use App\Models\JadwalPsikolog;
use App\Models\Konsultasi;
use App\Models\Pembayaran;
use App\Models\Psikolog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Exports\KonsultasiExport;
use Maatwebsite\Excel\Facades\Excel;

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
            'metode_pembayaran' => ['required', 'in:Transfer Bank,E-Wallet'],
        ], [
            'id_psikolog.required'       => 'Pilih psikolog terlebih dahulu.',
            'id_psikolog.exists'         => 'Psikolog yang dipilih tidak valid.',
            'id_jadwal.required'         => 'Pilih jadwal konsultasi terlebih dahulu.',
            'id_jadwal.exists'           => 'Jadwal yang dipilih tidak valid.',
            'metode_pembayaran.required' => 'Pilih metode pembayaran terlebih dahulu.',
            'metode_pembayaran.in'       => 'Metode pembayaran tidak valid.',
        ]);

        $psikolog = Psikolog::findOrFail($data['id_psikolog']);

        $konsultasi = DB::transaction(function () use ($data, $psikolog) {
            $jadwal = JadwalPsikolog::where('id', $data['id_jadwal'])
                ->where('id_psikolog', $psikolog->id)
                ->where('status', 'Tersedia')
                ->lockForUpdate()
                ->firstOrFail();

            $konsultasi = Konsultasi::create([
                'id_user'           => Auth::id(),
                'id_psikolog'       => $psikolog->id,
                'id_jadwal'         => $jadwal->id,
                'status_konsultasi' => 'Menunggu Pembayaran',
                'total_biaya'       => $psikolog->biaya,
            ]);

            $konsultasi->pembayaran()->update([
                'metode_pembayaran' => $data['metode_pembayaran'],
            ]);

            return $konsultasi;
        });

        toast('Pemesanan berhasil! Silakan selesaikan pembayaran agar sesi konselingmu bisa segera dikonfirmasi.', 'success');

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

    public function bayar(Request $request, Konsultasi $konsultasi)
    {
        abort_unless($konsultasi->id_user === Auth::id(), 403);

        $request->validate([
            'bukti_pembayaran' => ['required', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:2048'],
        ], [
            'bukti_pembayaran.required' => 'Silakan unggah bukti pembayaran terlebih dahulu.',
            'bukti_pembayaran.mimes'    => 'Format file harus berupa JPG, PNG, atau PDF.',
            'bukti_pembayaran.max'      => 'Ukuran file bukti pembayaran maksimal 2MB.',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            
            $filename = time() . '_' . $konsultasi->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/bukti_pembayaran', $filename);

            $pembayaran = $konsultasi->pembayaran;
            if ($pembayaran->bukti_pembayaran && Storage::exists($pembayaran->bukti_pembayaran)) {
                Storage::delete($pembayaran->bukti_pembayaran);
            }

            $pembayaran->update([
                'bukti_pembayaran' => $path,
                'status_pembayaran' => 'Pending', 
                'waktu_pembayaran' => now(), 
            ]);
        }

        return redirect()->route('konsultasi.riwayat')->with('success', 'Bukti pembayaran berhasil diunggah! Mohon tunggu verifikasi dari admin.');
    }

    public function riwayat()
    {
        $konsultasi = Konsultasi::with(['psikolog', 'jadwal', 'pembayaran'])
            ->where('id_user', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('konsultasi.riwayat', compact('konsultasi'));
    }

    // EXPORT: unduh riwayat konsultasi 
    public function exportExcel()
    {
        return Excel::download(
            new KonsultasiExport,
            'laporan-konsultasi-' . now()->format('Ymd') . '.xlsx'
        );
    }
}