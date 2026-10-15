<?php

namespace Database\Seeders;

use App\Models\PertanyaanPsikologis;
use App\Models\TesPsikologis;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * 1 tes: Tes Tingkat Stres (5 pertanyaan, tiap pertanyaan 5 pilihan jawaban + poin).
 *
 * Jalankan: php artisan db:seed --class=TesPsikologisSeeder
 * Aman diulang: tes dicocokkan lewat nama, pertanyaan lewat teksnya.
 */
class TesPsikologisSeeder extends Seeder
{
    public function run(): void
    {
        // Pilihan jawaban sama untuk semua pertanyaan: label => poin
        $opsi = [
            'Sangat Setuju' => 4,
            'Setuju' => 3,
            'Netral' => 2,
            'Kurang Setuju' => 1,
            'Tidak Setuju' => 0,
        ];

        $pertanyaan = [
            'Saya merasa kewalahan oleh tanggung jawab sehari-hari.',
            'Saya sulit tidur karena banyak pikiran.',
            'Saya mudah tersinggung atau marah tanpa sebab yang jelas.',
            'Saya merasa tidak mampu mengendalikan hal-hal penting dalam hidup saya.',
            'Saya merasa lelah meski sudah cukup beristirahat.',
        ];

        // unguarded: seeder tidak bergantung pada isi $fillable di model
        Model::unguarded(function () use ($opsi, $pertanyaan) {
            $tes = TesPsikologis::updateOrCreate(
                ['nama_tes' => 'Tes Tingkat Stres'],
                ['deskripsi' => 'Gambaran singkat tingkat stresmu dalam satu bulan terakhir. Jawab sesuai yang kamu rasakan.']
            );

            foreach ($pertanyaan as $teks) {
                $p = PertanyaanPsikologis::firstOrCreate([
                    'id_tes' => $tes->id,
                    'pertanyaan' => $teks,
                ]);

                // Isi pilihan jawaban hanya kalau pertanyaan ini belum punya
                if ($p->jawabanPsikologis()->doesntExist()) {
                    foreach ($opsi as $label => $poin) {
                        $p->jawabanPsikologis()->create([
                            'jawaban' => $label,
                            'poin' => $poin,
                        ]);
                    }
                }
            }
        });
    }
}
