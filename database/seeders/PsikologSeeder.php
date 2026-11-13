<?php

namespace Database\Seeders;

use App\Models\Psikolog;
use App\Models\User;
use Illuminate\Database\Seeder;

class PsikologSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Dr. Ani Wijaya, M.Psi.',
                'email' => 'ani.wijaya@mentalcare',
                'spesialis' => 'Spesialis Kecemasan & Depresi',
                'deskripsi_psikolog' => 'Membantu klien mengenali dan mengelola kecemasan serta suasana hati yang menurun, '
                    . 'dengan pendekatan yang tenang dan terstruktur.',
                'biaya' => 150000,
            ],
            [
                'nama' => 'Budi Santoso, S.Psi., M.Psi.',
                'email' => 'budi.santoso@mentalcare',
                'spesialis' => 'Konselor Karir & Pengembangan Diri',
                'deskripsi_psikolog' => 'Mendampingi klien yang bingung menentukan arah karier, menghadapi tekanan kerja, '
                    . 'dan ingin berkembang dengan lebih percaya diri.',
                'biaya' => 175000,
            ],
            [
                'nama' => 'Citra Lestari, M.Psi.',
                'email' => 'citra.lestari@mentalcare',
                'spesialis' => 'Psikolog Keluarga & Relasi',
                'deskripsi_psikolog' => 'Menemani individu dan pasangan memahami pola komunikasi, '
                    . 'menyelesaikan konflik, dan membangun hubungan yang lebih sehat.',
                'biaya' => 200000,
            ],
        ];

        foreach ($data as $item) {
            // 1. Akun login psikolog (password di-hash otomatis oleh cast 'hashed' di model User)
            $user = User::updateOrCreate(
                ['email' => $item['email']],
                [
                    'nama'     => $item['nama'],
                    'password' => 'psikolog123',
                    'role'     => 'psikolog',
                ]
            );

            // 2. Profil psikolog yang terhubung ke akun tersebut
            Psikolog::unguarded(function () use ($item, $user) {
                Psikolog::updateOrCreate(
                    ['email' => $item['email']],
                    $item + ['id_user' => $user->id]
                );
            });
        }
    }
}