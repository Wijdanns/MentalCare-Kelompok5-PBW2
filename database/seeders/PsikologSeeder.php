<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Psikolog;

class PsikologSeeder extends Seeder
{
    public function run(): void
    {
        Psikolog::create([
            'nama' => 'Dr. Ani Wijaya, M.Psi.',
            'spesialisasi' => 'Spesialis Kecemasan & Depresi',
            'kategori' => 'kecemasan',
            'pengalaman_tahun' => 5,
            'is_available' => true,
        ]);

        Psikolog::create([
            'nama' => 'Budi Santoso, S.Psi., M.Psi.',
            'spesialisasi' => 'Konselor Karir & Pengembangan Diri',
            'kategori' => 'karier',
            'pengalaman_tahun' => 3,
            'is_available' => true,
        ]);

        Psikolog::create([
            'nama' => 'Citra Lestari, M.Psi.',
            'spesialisasi' => 'Psikolog Keluarga & Relasi',
            'kategori' => 'relasi',
            'pengalaman_tahun' => 7,
            'is_available' => true,
        ]);
    }
}