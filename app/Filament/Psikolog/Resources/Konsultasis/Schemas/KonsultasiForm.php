<?php

namespace App\Filament\Psikolog\Resources\Konsultasis\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KonsultasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id_user')
                    ->required()
                    ->numeric(),
                TextInput::make('id_psikolog')
                    ->required()
                    ->numeric(),
                TextInput::make('id_jadwal')
                    ->required()
                    ->numeric(),
                Select::make('status_konsultasi')
                    ->options([
            'Menunggu Pembayaran' => 'Menunggu pembayaran',
            'Dikonfirmasi' => 'Dikonfirmasi',
            'Selesai' => 'Selesai',
            'Batal' => 'Batal',
        ])
                    ->default('Menunggu Pembayaran')
                    ->required(),
                TextInput::make('total_biaya')
                    ->required()
                    ->numeric(),
            ]);
    }
}
