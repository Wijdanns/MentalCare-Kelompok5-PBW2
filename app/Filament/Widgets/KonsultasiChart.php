<?php

namespace App\Filament\Widgets;

use App\Models\Konsultasi;
use Filament\Widgets\ChartWidget;

class KonsultasiChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Konsultasi 6 Bulan Terakhir';

    protected ?string $description = 'Tidak termasuk konsultasi yang dibatalkan.';

    protected function getData(): array
    {
        $labels = [];
        $data = [];

        foreach (range(5, 0) as $i) {
            $bulan = now()->startOfMonth()->subMonths($i);

            $labels[] = $bulan->format('M Y');
            $data[] = Konsultasi::query()
                ->where('status_konsultasi', '!=', 'Batal')
                ->whereBetween('created_at', [$bulan->copy()->startOfMonth(), $bulan->copy()->endOfMonth()])
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Konsultasi',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}