<?php

namespace App\Http\Controllers;

use App\Models\Psikolog;
use App\Models\Ulasan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UlasanController extends Controller
{
    /**
     * READ: Menampilkan daftar ulasan, form tulis, dan rata-rata rating.
     */
    public function index(): View
    {
        $ulasans = Ulasan::with(['user', 'psikolog'])->latest()->paginate(5);

        $jumlahUlasan = Ulasan::count();
        $rataRata = $jumlahUlasan > 0 ? round(Ulasan::avg('rating'), 1) : null;

        $psikologs = Psikolog::query()
            ->when(Auth::check(), fn ($q) => $q->whereNotIn(
                'id', Ulasan::where('id_user', Auth::id())->select('id_psikolog')
            ))
            ->orderBy('nama')
            ->get(['id', 'nama']);

        return view('ulasan.index', compact('ulasans', 'jumlahUlasan', 'rataRata', 'psikologs'));
    }

    /**
     * CREATE: Simpan ulasan baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id_psikolog' => [
                'required', 
                'exists:psikolog,id',
                Rule::unique('ulasan', 'id_psikolog')->where('id_user', Auth::id())
            ],
            'rating' => ['required', 'integer', 'between:1,5'],
            'komentar' => ['required', 'string', 'min:10', 'max:500'],
        ], [
            'id_psikolog.required' => 'Pilih psikolog yang ingin kamu ulas.',
            'id_psikolog.unique' => 'Kamu sudah memberi ulasan untuk psikolog ini.',
            'rating.required' => 'Pilih rating dari 1 sampai 5 bintang.',
            'komentar.required' => 'Komentar wajib diisi.',
            'komentar.min' => 'Komentar minimal 10 karakter.',
            'komentar.max' => 'Komentar maksimal 500 karakter.',
        ]);

        Ulasan::create([
            'id_user' => Auth::id(),
            'id_psikolog' => $data['id_psikolog'],
            'rating' => $data['rating'],
            'komentar' => $data['komentar'],
        ]);

        return redirect()->route('ulasan.index')->with('success', 'Ulasan berhasil dikirim. Terima kasih!');
    }

    /**
     * UPDATE (Tampilan): Buka form edit.
     */
    public function edit(Ulasan $ulasan): View
    {
        $this->pastikanPemilik($ulasan);
        $ulasan->load('psikolog');

        return view('ulasan.edit', compact('ulasan'));
    }

    /**
     * UPDATE (Proses): Simpan perubahan.
     */
    public function update(Request $request, Ulasan $ulasan): RedirectResponse
    {
        $this->pastikanPemilik($ulasan);

        $data = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'komentar' => ['required', 'string', 'min:10', 'max:500'],
        ], [
            'rating.required' => 'Pilih rating dari 1 sampai 5 bintang.',
            'komentar.required' => 'Komentar wajib diisi.',
            'komentar.min' => 'Komentar minimal 10 karakter.',
            'komentar.max' => 'Komentar maksimal 500 karakter.',
        ]);

        $ulasan->update($data);

        return redirect()->route('ulasan.index')->with('success', 'Ulasan berhasil diperbarui.');
    }

    /**
     * DELETE: Hapus ulasan.
     */
    public function destroy(Ulasan $ulasan): RedirectResponse
    {
        $this->pastikanPemilik($ulasan);
        $ulasan->delete();

        return redirect()->route('ulasan.index')->with('success', 'Ulasan berhasil dihapus.');
    }

    /**
     * Helper: Memastikan hanya pemilik ulasan yang bisa Edit/Hapus.
     */
    private function pastikanPemilik(Ulasan $ulasan): void
    {
        abort_unless((int) $ulasan->id_user === (int) Auth::id(), 403);
    }
}