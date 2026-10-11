<?php

namespace App\Http\Controllers;

use App\Models\Psikolog;
use Illuminate\Http\Request;

class PsikologController extends Controller
{
    public function index()
    {
        // Ambil semua data psikolog dari database
        $psikologs = Psikolog::all();

        // Panggil file view tunggal buatan temanmu (resources/views/psikolog.blade.php)
        return view('psikolog', compact('psikologs'));
    }
}