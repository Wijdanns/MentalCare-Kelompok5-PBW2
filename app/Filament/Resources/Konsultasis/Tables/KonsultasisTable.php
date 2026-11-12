<?php

namespace App\Filament\Resources\Konsultasis\Tables;

use App\Models\Konsultasi;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class KonsultasisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->formatStateUsing(fn ($state) => "#{$state}")
                    ->sortable(),
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
                    ->label('Jam Sesi')
                    ->formatStateUsing(fn (Konsultasi $record) => $record->jadwal
                        ? substr($record->jadwal->jam_mulai, 0, 5) . ' - ' . substr($record->jadwal->jam_selesai, 0, 5)
                        : '-'),
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
                    })
                    ->description(fn (Konsultasi $record): ?string => match (true) {
                        $record->pembayaran?->status_pembayaran === 'Berhasil' => $record->pembayaran?->metode_pembayaran,
                        filled($record->pembayaran?->bukti_pembayaran) => 'Bukti sudah diunggah',
                        default => 'Belum upload bukti',
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
                    ->label('Status Konsultasi')
                    ->options([
                        'Menunggu Pembayaran' => 'Menunggu Pembayaran',
                        'Dikonfirmasi' => 'Dikonfirmasi',
                        'Selesai' => 'Selesai',
                        'Batal' => 'Batal',
                    ]),
                SelectFilter::make('id_psikolog')
                    ->label('Psikolog')
                    ->relationship('psikolog', 'nama'),
            ])
            ->recordActions([
                Action::make('lihatBukti')
                    ->label('Lihat Bukti')
                    ->icon('heroicon-o-document-magnifying-glass')
                    ->color('info')
                    ->visible(fn (Konsultasi $record) => filled($record->pembayaran?->bukti_pembayaran))
                    ->url(fn (Konsultasi $record) => route('bukti-pembayaran', basename($record->pembayaran->bukti_pembayaran)), shouldOpenInNewTab: true),
                    
                Action::make('tandaiSelesai')
                    ->label('Selesai')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Selesaikan Sesi Konsultasi')
                    ->modalDescription('Tandai sesi konsultasi ini telah selesai dilaksanakan?')
                    ->visible(fn (Konsultasi $record) => $record->status_konsultasi === 'Dikonfirmasi')
                    ->action(fn (Konsultasi $record) => $record->update([
                        'status_konsultasi' => 'Selesai',
                    ])),

                EditAction::make()->label('Ubah Status'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}