<?php

namespace App\Http\Controllers;

use App\Models\Psikolog;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // 3 psikolog pilihan: yang punya jadwal dulu, lalu yang terbaru
        $psikologs = Psikolog::query()
            ->withExists('jadwalTersedia as tersedia')
            ->orderByDesc('tersedia')
            ->latest()
            ->take(3)
            ->get();

        return view('home', compact('psikologs'));
    }
}