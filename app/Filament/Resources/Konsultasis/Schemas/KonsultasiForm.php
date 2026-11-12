<?php

namespace App\Filament\Resources\Konsultasis\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KonsultasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('pasien_display')
                ->label('Pasien')
                ->formatStateUsing(fn ($record) => $record?->user?->nama ?? '-')
                ->disabled()
                ->dehydrated(false),

            TextInput::make('psikolog_display')
                ->label('Psikolog')
                ->formatStateUsing(fn ($record) => $record?->psikolog?->nama ?? '-')
                ->disabled()
                ->dehydrated(false),

            TextInput::make('tanggal_display')
                ->label('Tanggal')
                ->formatStateUsing(fn ($record) => $record?->jadwal?->tanggal
                    ? \Carbon\Carbon::parse($record->jadwal->tanggal)->format('d M Y')
                    : '-')
                ->disabled()
                ->dehydrated(false),

            TextInput::make('jam_display')
                ->label('Jam Sesi')
                ->formatStateUsing(fn ($record) => $record?->jadwal
                    ? substr($record->jadwal->jam_mulai, 0, 5) . ' - ' . substr($record->jadwal->jam_selesai, 0, 5)
                    : '-')
                ->disabled()
                ->dehydrated(false),

            TextInput::make('total_biaya')
                ->label('Total Biaya')
                ->prefix('Rp')
                ->disabled()
                ->dehydrated(false),

            TextInput::make('status_pembayaran_display')
                ->label('Status Pembayaran')
                ->formatStateUsing(fn ($record) => $record?->pembayaran
                    ? "{$record->pembayaran->status_pembayaran} ({$record->pembayaran->metode_pembayaran})"
                    : '-')
                ->disabled()
                ->dehydrated(false),

            Select::make('status_konsultasi')
                ->label('Status Konsultasi')
                ->options([
                    'Menunggu Pembayaran' => 'Menunggu Pembayaran',
                    'Dikonfirmasi' => 'Dikonfirmasi',
                    'Selesai' => 'Selesai',
                    'Batal' => 'Batal',
                ])
                ->required()
                ->columnSpanFull(),
        ])->columns(2);
    }
}