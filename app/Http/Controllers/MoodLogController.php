<?php

namespace App\Http\Controllers;

use App\Models\MoodLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoodLogController extends Controller
{
    private const MOODS = 'Sangat Baik,Baik,Biasa,Cemas,Sedih';

    // Ambil query yang SELALU dibatasi ke user yang login
    private function milikSaya()
    {
        return MoodLog::where('user_id', Auth::id());
    }

    // READ
    public function index()
    {
        $moods = $this->milikSaya()->latest()->get();

        return view('pasien.mood.index', compact('moods'));
    }

    // CREATE
    public function store(Request $request)
    {
        $request->validate([
            'mood'    => 'required|in:' . self::MOODS,
            'catatan' => 'nullable|string|max:255',
        ], [
            'mood.required' => 'Pilih suasana hati Anda hari ini!',
            'catatan.max'   => 'Catatan maksimal 255 karakter.',
        ]);

        MoodLog::create([
            'user_id' => Auth::id(),
            'mood'    => $request->mood,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('pasien.mood.index')->with('success', 'Mood harian berhasil dicatat!');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $mood = $this->milikSaya()->findOrFail($id);

        $request->validateWithBag('update_' . $mood->id, [
            'mood'    => 'required|in:' . self::MOODS,
            'catatan' => 'nullable|string|max:255',
        ], [
            'mood.required' => 'Pilih suasana hati Anda!',
            'catatan.max'   => 'Catatan maksimal 255 karakter.',
        ]);

        $mood->update([
            'mood'    => $request->mood,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('pasien.mood.index')->with('success', 'Catatan mood berhasil diperbarui!');
    }

    // DELETE
    public function destroy($id)
    {
        $this->milikSaya()->findOrFail($id)->delete();

        return redirect()->route('pasien.mood.index')->with('success', 'Catatan mood berhasil dihapus!');
    }
}