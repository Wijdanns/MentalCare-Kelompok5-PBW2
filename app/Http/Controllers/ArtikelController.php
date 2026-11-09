<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\KategoriArtikel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArtikelController extends Controller
{
    /**
     * Daftar artikel, dengan pencarian dan filter kategori.
     * Query string: ?q=kata&kategori=ID
     */
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $kategoriId = $request->integer('kategori') ?: null;

        $artikels = Artikel::query()
            ->with(['kategori', 'user'])
            ->terbit()
            ->when($q !== '', fn ($query) => $query->where(function ($w) use ($q) {
                $w->where('judul', 'like', "%{$q}%")
                  ->orWhere('isi', 'like', "%{$q}%");
            }))
            ->when($kategoriId, fn ($query) => $query->where('id_kategori', $kategoriId))
            ->orderByDesc('tanggal_publikasi')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        // Kategori yang punya minimal satu artikel terbit, beserta jumlahnya
        $daftarKategori = KategoriArtikel::query()
            ->whereHas('artikel', fn ($query) => $query->terbit())
            ->withCount(['artikel' => fn ($query) => $query->terbit()])
            ->orderBy('nama_kategori')
            ->get();

        $kategoriAktif = $kategoriId
            ? $daftarKategori->firstWhere('id', $kategoriId)
            : null;

        return view('artikel.index', compact('artikels', 'daftarKategori', 'kategoriAktif', 'q'));
    }

    /**
     * Baca satu artikel, plus artikel terkait dari kategori yang sama.
     */
    public function show(Artikel $artikel): View
    {
        $this->pastikanSudahTerbit($artikel);

        $artikel->load(['kategori', 'user']);

        $terkait = Artikel::query()
            ->with('kategori')
            ->terbit()
            ->where('id_kategori', $artikel->id_kategori)
            ->whereKeyNot($artikel->id)
            ->orderByDesc('tanggal_publikasi')
            ->take(3)
            ->get();

        return view('artikel.show', compact('artikel', 'terkait'));
    }

    /**
     * Unduh satu artikel sebagai file PDF (DomPDF).
     */
    public function unduh(Artikel $artikel)
    {
        $this->pastikanSudahTerbit($artikel);

        $artikel->load(['kategori', 'user']);

        // Thumbnail disisipkan sebagai data base64 supaya pasti tampil di PDF
        $thumbnail = null;
        if ($artikel->thumbnail) {
            $path = storage_path('app/public/artikel/' . basename($artikel->thumbnail));

            if (is_file($path)) {
                $thumbnail = 'data:' . mime_content_type($path) . ';base64,' . base64_encode(file_get_contents($path));
            }
        }

        $pdf = Pdf::loadView('artikel.pdf', compact('artikel', 'thumbnail'))
            ->setPaper('a4', 'portrait');

        $namaFile = (Str::slug($artikel->judul) ?: 'artikel') . '.pdf';

        return $pdf->download($namaFile);
    }

    /**
     * Artikel yang belum waktunya terbit dianggap tidak ada (dipakai show() dan unduh()).
     */
    private function pastikanSudahTerbit(Artikel $artikel): void
    {
        abort_if($artikel->tanggal_publikasi->isFuture() && ! $artikel->tanggal_publikasi->isToday(), 404);
    }
}