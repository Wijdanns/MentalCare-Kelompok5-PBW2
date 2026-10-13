<?php

namespace App\Filament\Resources\Pembayarans\Tables;

use App\Models\Pembayaran;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PembayaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_konsultasi')
                    ->label('Konsultasi')
                    ->formatStateUsing(fn ($state) => "#{$state}")
                    ->sortable(),
                TextColumn::make('konsultasi.user.nama')
                    ->label('Pasien')
                    ->searchable(),
                TextColumn::make('konsultasi.psikolog.nama')
                    ->label('Psikolog')
                    ->searchable(),
                TextColumn::make('konsultasi.total_biaya')
                    ->label('Jumlah')
                    ->money('IDR', locale: 'id'),
                TextColumn::make('metode_pembayaran')
                    ->label('Metode')
                    ->placeholder('-'),
                TextColumn::make('waktu_pembayaran')
                    ->label('Waktu Bayar')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('status_pembayaran')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Berhasil' => 'success',
                        'Pending' => 'warning',
                        'Gagal' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status_pembayaran')
                    ->label('Status')
                    ->options([
                        'Pending' => 'Pending',
                        'Berhasil' => 'Berhasil',
                        'Gagal' => 'Gagal',
                    ]),
            ])
            ->recordActions([
                Action::make('tandaiBerhasil')
                    ->label('Tandai Berhasil')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Pembayaran $record) => $record->status_pembayaran === 'Pending')
                    ->action(fn (Pembayaran $record) => $record->update([
                        'status_pembayaran' => 'Berhasil',
                    ])),
                EditAction::make(),
            ]);
    }
}