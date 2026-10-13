<?php

namespace App\Filament\Widgets;

use App\Models\Konsultasi;
use App\Models\Pembayaran;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Pasien
        $totalPasien = User::where('role', 'pasien')->count();
        $pasienBaru = User::where('role', 'pasien')
            ->whereBetween('created_at', [now()->startOfMonth(), now()])
            ->count();

        // Konsultasi hari ini (berdasarkan tanggal jadwal, selain yang batal)
        $konsultasiHariIni = Konsultasi::query()
            ->where('status_konsultasi', '!=', 'Batal')
            ->whereHas('jadwal', fn ($q) => $q->whereDate('tanggal', today()))
            ->count();

        // Pendapatan bulan ini vs bulan lalu
        $bulanIni = $this->pendapatan(now()->startOfMonth(), now()->endOfMonth());
        $bulanLalu = $this->pendapatan(
            now()->subMonthNoOverflow()->startOfMonth(),
            now()->subMonthNoOverflow()->endOfMonth()
        );

        if ($bulanLalu > 0) {
            $persen = round((($bulanIni - $bulanLalu) / $bulanLalu) * 100);
            $deskripsiPendapatan = ($persen >= 0 ? '+' : '') . $persen . '% dari bulan lalu';
            $naik = $persen >= 0;
        } else {
            $deskripsiPendapatan = 'Belum ada data bulan lalu';
            $naik = true;
        }

        // Menunggu pembayaran
        $menunggu = Konsultasi::where('status_konsultasi', 'Menunggu Pembayaran')->count();

        return [
            Stat::make('Total Pasien', number_format($totalPasien, 0, ',', '.'))
                ->description($pasienBaru . ' pasien baru bulan ini')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('info'),

            Stat::make('Konsultasi Hari Ini', $konsultasiHariIni)
                ->description('Jadwal tanggal ' . today()->format('d M Y'))
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),

            Stat::make('Pendapatan Bulan Ini', 'Rp ' . number_format($bulanIni, 0, ',', '.'))
                ->description($deskripsiPendapatan)
                ->descriptionIcon($naik ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($naik ? 'success' : 'danger'),

            Stat::make('Menunggu Pembayaran', $menunggu)
                ->description('Konsultasi belum dibayar')
                ->descriptionIcon('heroicon-m-clock')
                ->color($menunggu > 0 ? 'warning' : 'gray'),
        ];
    }

    private function pendapatan(Carbon $dari, Carbon $sampai): float
    {
        return (float) Pembayaran::query()
            ->join('konsultasi', 'konsultasi.id', '=', 'pembayaran.id_konsultasi')
            ->where('pembayaran.status_pembayaran', 'Berhasil')
            ->whereBetween('pembayaran.waktu_pembayaran', [$dari, $sampai])
            ->sum('konsultasi.total_biaya');
    }
}