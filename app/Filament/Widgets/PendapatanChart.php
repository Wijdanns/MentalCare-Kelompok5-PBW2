<?php

namespace App\Filament\Widgets;

use App\Models\Pembayaran;
use Filament\Widgets\ChartWidget;

class PendapatanChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $heading = 'Pendapatan 6 Bulan Terakhir';

    protected ?string $description = 'Dalam rupiah, dari pembayaran berstatus Berhasil.';

    protected function getData(): array
    {
        $labels = [];
        $data = [];

        foreach (range(5, 0) as $i) {
            $bulan = now()->startOfMonth()->subMonths($i);

            $labels[] = $bulan->format('M Y');
            $data[] = (float) Pembayaran::query()
                ->join('konsultasi', 'konsultasi.id', '=', 'pembayaran.id_konsultasi')
                ->where('pembayaran.status_pembayaran', 'Berhasil')
                ->whereBetween('pembayaran.waktu_pembayaran', [
                    $bulan->copy()->startOfMonth(),
                    $bulan->copy()->endOfMonth(),
                ])
                ->sum('konsultasi.total_biaya');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan (Rp)',
                    'data' => $data,
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}