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
            TextInput::make('user.nama')
                ->label('Pasien')
                ->disabled(),

            TextInput::make('psikolog.nama')
                ->label('Psikolog')
                ->disabled(),

            TextInput::make('jadwal.tanggal')
                ->label('Tanggal')
                ->formatStateUsing(fn ($state) => $state ? \Carbon\Carbon::parse($state)->format('d M Y') : null)
                ->disabled(),

            TextInput::make('jadwal.jam_mulai')
                ->label('Jam Mulai')
                ->formatStateUsing(fn ($state) => $state ? substr($state, 0, 5) : null)
                ->disabled(),

            TextInput::make('metode')
                ->label('Metode')
                ->disabled(),

            TextInput::make('total_biaya')
                ->label('Total Biaya')
                ->prefix('Rp')
                ->disabled(),

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