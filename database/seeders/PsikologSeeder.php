<?php

namespace Database\Seeders;

use App\Models\Psikolog;
use Illuminate\Database\Seeder;

class PsikologSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Dr. Ani Wijaya, M.Psi.',
                'email' => 'ani.wijaya@mentalcare.test',
                'spesialis' => 'Spesialis Kecemasan & Depresi',
                'deskripsi_psikolog' => 'Membantu klien mengenali dan mengelola kecemasan serta suasana hati yang menurun, '
                    . 'dengan pendekatan yang tenang dan terstruktur.',
                'biaya' => 150000,
            ],
            [
                'nama' => 'Budi Santoso, S.Psi., M.Psi.',
                'email' => 'budi.santoso@mentalcare.test',
                'spesialis' => 'Konselor Karir & Pengembangan Diri',
                'deskripsi_psikolog' => 'Mendampingi klien yang bingung menentukan arah karier, menghadapi tekanan kerja, '
                    . 'dan ingin berkembang dengan lebih percaya diri.',
                'biaya' => 175000,
            ],
            [
                'nama' => 'Citra Lestari, M.Psi.',
                'email' => 'citra.lestari@mentalcare.test',
                'spesialis' => 'Psikolog Keluarga & Relasi',
                'deskripsi_psikolog' => 'Menemani individu dan pasangan memahami pola komunikasi, '
                    . 'menyelesaikan konflik, dan membangun hubungan yang lebih sehat.',
                'biaya' => 200000,
            ],
        ];

        Psikolog::unguarded(function () use ($data) {
            foreach ($data as $item) {
                Psikolog::updateOrCreate(['email' => $item['email']], $item);
            }
        });
    }
}