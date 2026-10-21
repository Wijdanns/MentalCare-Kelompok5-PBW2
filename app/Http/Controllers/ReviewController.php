<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\ReviewPsikolog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $id_konsultasi)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string|max:500',
        ]);

        $konsultasi = Konsultasi::findOrFail($id_konsultasi);

        ReviewPsikolog::create([
            'id_konsultasi' => $konsultasi->id,
            'id_user'       => Auth::id() ?? 1,
            'id_psikolog'   => $konsultasi->id_psikolog,
            'rating'        => $validated['rating'],
            'ulasan'        => $validated['ulasan'],
        ]);

        return back()->with('success', 'Terima kasih! Ulasan kamu berhasil dikirim.');
    }
}