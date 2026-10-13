<?php

namespace App\Http\Controllers;

use App\Models\HasilTes;
use App\Models\TesPsikologis;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TesController extends Controller
{
    /**
     * Daftar tes yang bisa dikerjakan (hanya tes yang sudah punya pertanyaan).
     */
    public function index(): View
    {
        $daftarTes = TesPsikologis::query()
            ->withCount('pertanyaan')
            ->has('pertanyaan')
            ->orderBy('nama_tes')
            ->get();

        return view('pasien.tes.index', compact('daftarTes'));
    }

    /**
     * Halaman pengerjaan: semua pertanyaan beserta pilihan jawabannya.
     * Kolom `poin` sengaja TIDAK dimuat, supaya skor tidak terlihat oleh pasien.
     */
    public function show(TesPsikologis $tes): View|RedirectResponse
    {
        $tes->load([
            'pertanyaan' => fn ($q) => $q->orderBy('id'),
            'pertanyaan.jawabanPsikologis' => fn ($q) => $q
                ->select('id', 'id_pertanyaan', 'jawaban')
                ->orderBy('id'),
        ]);

        if ($tes->pertanyaan->isEmpty()) {
            return redirect()
                ->route('tes.index')
                ->with('error', 'Tes ini belum memiliki pertanyaan.');
        }

        return view('pasien.tes.show', compact('tes'));
    }

    /**
     * Simpan jawaban, hitung total poin, lalu arahkan ke halaman hasil.
     * Input yang diharapkan: jawaban[id_pertanyaan] = id_jawaban
     */
    public function submit(Request $request, TesPsikologis $tes): RedirectResponse
    {
        $request->validate([
            'jawaban' => ['required', 'array'],
        ], [
            'jawaban.required' => 'Jawab semua pertanyaan terlebih dahulu.',
        ]);

        $pertanyaan = $tes->pertanyaan()
            ->with('jawabanPsikologis')
            ->orderBy('id')
            ->get();

        abort_if($pertanyaan->isEmpty(), 404);

        $pilihan = $request->input('jawaban', []);
        $rows = [];
        $total = 0;

        // Validasi: tiap pertanyaan harus terjawab, dan jawabannya harus
        // benar-benar milik pertanyaan itu (mencegah data kiriman dipalsukan).
        foreach ($pertanyaan as $i => $p) {
            $jawaban = $p->jawabanPsikologis->firstWhere('id', (int) ($pilihan[$p->id] ?? 0));

            if (! $jawaban) {
                throw ValidationException::withMessages([
                    'jawaban' => 'Pertanyaan nomor ' . ($i + 1) . ' belum dijawab.',
                ]);
            }

            $rows[] = [
                'id_pertanyaan' => $p->id,
                'id_jawaban' => $jawaban->id,
                'poin' => $jawaban->poin, // salinan poin saat dijawab
            ];
            $total += $jawaban->poin;
        }

        $hasil = DB::transaction(function () use ($tes, $rows, $total) {
            $hasil = HasilTes::create([
                'id_user' => Auth::id(),
                'id_tes' => $tes->id,
                'total_poin' => $total,
            ]);

            $hasil->jawabanUser()->createMany($rows);

            return $hasil;
        });

        return redirect()->route('tes.hasil', $hasil);
    }

    /**
     * Halaman hasil: total poin dan rincian jawaban.
     * Pasien hanya boleh melihat hasil miliknya sendiri.
     */
    public function hasil(HasilTes $hasil): View
    {
        abort_unless((int) $hasil->id_user === (int) Auth::id(), 403);

        $hasil->load([
            'tesPsikologis',
            'jawabanUser.pertanyaanPsikologis',
            'jawabanUser.jawabanPsikologis',
        ]);

        // Poin maksimal tes = jumlah poin tertinggi tiap pertanyaan
        $poinMaks = $hasil->tesPsikologis
            ->pertanyaan()
            ->with('jawabanPsikologis')
            ->get()
            ->sum(fn ($p) => (int) $p->jawabanPsikologis->max('poin'));

        return view('pasien.tes.hasil', compact('hasil', 'poinMaks'));
    }

    /**
     * Riwayat tes milik pasien yang sedang login.
     */
    public function riwayat(): View
    {
        $riwayat = HasilTes::query()
            ->with('tesPsikologis')
            ->where('id_user', Auth::id())
            ->latest()
            ->paginate(10);

        return view('pasien.tes.riwayat', compact('riwayat'));
    }
}