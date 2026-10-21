<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JurnalController extends Controller
{
   
    public function index(Request $request): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $mood = in_array($request->query('mood'), array_keys(Jurnal::MOOD), true)
            ? $request->query('mood')
            : null;

        $jurnals = $user->jurnal()
            ->when($mood, fn ($q) => $q->where('mood', $mood))
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $total = $user->jurnal()->count();

        return view('pasien.jurnal.index', compact('jurnals', 'mood', 'total'));
    }

    public function create(): View
    {
        return view('pasien.jurnal.form', [
            'jurnal' => new Jurnal(['tanggal' => today()]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $jurnal = $user->jurnal()->create($this->validated($request));

        return redirect()
            ->route('jurnal.show', $jurnal)
            ->with('success', 'Jurnal tersimpan.');
    }

    public function show(Jurnal $jurnal): View
    {
        Gate::authorize('view', $jurnal);

        return view('pasien.jurnal.show', compact('jurnal'));
    }

    public function edit(Jurnal $jurnal): View
    {
        Gate::authorize('update', $jurnal);

        return view('pasien.jurnal.form', compact('jurnal'));
    }

    public function update(Request $request, Jurnal $jurnal): RedirectResponse
    {
        Gate::authorize('update', $jurnal);

        $jurnal->update($this->validated($request));

        return redirect()
            ->route('jurnal.show', $jurnal)
            ->with('success', 'Perubahan tersimpan.');
    }

    public function destroy(Jurnal $jurnal): RedirectResponse
    {
        Gate::authorize('delete', $jurnal);

        $jurnal->delete();

        return redirect()
            ->route('jurnal.index')
            ->with('success', 'Jurnal dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'judul' => ['nullable', 'string', 'max:255'],
            'isi' => ['required', 'string', 'max:20000'],
            'mood' => ['nullable', Rule::in(array_keys(Jurnal::MOOD))],
            'tanggal' => ['required', 'date', 'before_or_equal:today'],
        ], [
            'isi.required' => 'Tulis sesuatu dulu ya.',
            'tanggal.before_or_equal' => 'Tanggal tidak boleh di masa depan.',
        ]);
    }
}