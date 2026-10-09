<?php

namespace App\Filament\Resources\Konsultasis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class KonsultasisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.nama')
                    ->label('Pasien')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('psikolog.nama')
                    ->label('Psikolog')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jadwal.tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('jadwal.jam_mulai')
                    ->label('Jam')
                    ->time('H:i'),
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
                        'Selesai' => 'success',
                        'Batal' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('pembayaran.status_pembayaran')
                    ->label('Pembayaran')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'Berhasil' => 'success',
                        'Pending' => 'warning',
                        'Gagal' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('total_biaya')
                    ->label('Biaya')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status_konsultasi')
                    ->label('Status')
                    ->options([
                        'Menunggu Pembayaran' => 'Menunggu Pembayaran',
                        'Dikonfirmasi' => 'Dikonfirmasi',
                        'Selesai' => 'Selesai',
                        'Batal' => 'Batal',
                    ]),
                SelectFilter::make('metode')
                    ->options(['Online' => 'Online', 'Offline' => 'Offline']),
                SelectFilter::make('id_psikolog')
                    ->label('Psikolog')
                    ->relationship('psikolog', 'nama'),
            ])
            ->recordActions([
                EditAction::make()->label('Ubah Status'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}