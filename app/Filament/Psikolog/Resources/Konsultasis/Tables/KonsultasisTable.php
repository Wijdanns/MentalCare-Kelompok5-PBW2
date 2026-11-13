<?php

namespace App\Filament\Psikolog\Resources\Konsultasis\Tables;

use App\Models\Konsultasi;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class KonsultasisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('jadwal.tanggal')->label('Tanggal')->date('d M Y')->sortable(),
                TextColumn::make('jadwal.jam_mulai')
                    ->label('Jam Sesi')
                    ->formatStateUsing(fn (Konsultasi $record) => $record->jadwal
                        ? substr($record->jadwal->jam_mulai, 0, 5) . ' - ' . substr($record->jadwal->jam_selesai, 0, 5)
                        : '-'),
                TextColumn::make('user.nama')->label('Pasien')->searchable(),
                TextColumn::make('user.email')->label('Email')->searchable(),
                TextColumn::make('status_konsultasi')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Dikonfirmasi' => 'info',
                        'Selesai' => 'success',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status_konsultasi')->options([
                    'Dikonfirmasi' => 'Dikonfirmasi',
                    'Selesai' => 'Selesai',
                ]),
            ])
            ->recordActions([
                Action::make('tandaiSelesai')
                    ->label('Tandai Selesai')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Selesaikan Sesi Konsultasi')
                    ->visible(fn (Konsultasi $record) => $record->status_konsultasi === 'Dikonfirmasi')
                    ->action(fn (Konsultasi $record) => $record->update([
                        'status_konsultasi' => 'Selesai',
                    ])),
            ]);
    }
}