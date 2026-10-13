<?php

namespace App\Filament\Widgets;

use App\Models\Konsultasi;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class KonsultasiMendatang extends TableWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Konsultasi Mendatang')
            ->query(fn (): Builder => Konsultasi::query()
                ->select('konsultasi.*')
                ->join('jadwal_psikolog', 'jadwal_psikolog.id', '=', 'konsultasi.id_jadwal')
                ->whereDate('jadwal_psikolog.tanggal', '>=', today())
                ->whereIn('konsultasi.status_konsultasi', ['Menunggu Pembayaran', 'Dikonfirmasi'])
                ->orderBy('jadwal_psikolog.tanggal')
                ->orderBy('jadwal_psikolog.jam_mulai')
                ->with(['user', 'psikolog', 'jadwal'])
            )
            ->columns([
                TextColumn::make('jadwal.tanggal')
                    ->label('Tanggal')
                    ->date('d M Y'),
                TextColumn::make('jadwal.jam_mulai')
                    ->label('Jam')
                    ->time('H:i'),
                TextColumn::make('user.nama')
                    ->label('Pasien'),
                TextColumn::make('psikolog.nama')
                    ->label('Psikolog'),
                TextColumn::make('metode')
                    ->label('Metode')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'Online' ? 'info' : 'gray'),
                TextColumn::make('status_konsultasi')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Menunggu Pembayaran' => 'warning',
                        'Dikonfirmasi' => 'info',
                        default => 'gray',
                    }),
            ])
            ->paginated([5, 10])
            ->defaultPaginationPageOption(5);
    }
}