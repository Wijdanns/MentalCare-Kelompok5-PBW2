<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Mengambil riwayat konsultasi beserta data psikolog, jadwal, dan pembayarannya
        $riwayatKonsultasi = $user->konsultasi()
            ->with(['psikolog', 'jadwal', 'pembayaran'])
            ->latest()
            ->get();

        // Mengambil riwayat hasil tes beserta detail tes psikologisnya
        $riwayatTes = $user->hasilTes()
            ->with('tesPsikologis')
            ->latest()
            ->get();

        return view('profil.index', compact('user', 'riwayatKonsultasi', 'riwayatTes'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'nama'   => 'required|string|max:255',
            'profil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = ['nama' => $request->nama];

        if ($request->hasFile('profil')) {
            // Hapus foto lama jika ada
            if ($user->profil) {
                Storage::disk('public')->delete($user->profil);
            }
            $data['profil'] = $request->file('profil')->store('profil', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}