<?php

namespace App\Filament\Resources\Pembayarans\Schemas;

use App\Models\Konsultasi;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class PembayaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('id_konsultasi')
                ->label('Konsultasi')
                ->options(fn () => Konsultasi::with(['user', 'psikolog'])->get()
                    ->mapWithKeys(fn (Konsultasi $k) => [
                        $k->id => "#{$k->id} - {$k->user?->nama} dengan {$k->psikolog?->nama}",
                    ]))
                ->disabled()
                ->dehydrated(false)
                ->columnSpanFull(),

            Select::make('metode_pembayaran')
                ->label('Metode Pembayaran')
                ->options([
                    'Transfer Bank' => 'Transfer Bank',
                    'QRIS' => 'QRIS',
                    'E-Wallet' => 'E-Wallet',
                    'Tunai' => 'Tunai',
                ]),

            Select::make('status_pembayaran')
                ->label('Status')
                ->options([
                    'Pending' => 'Pending',
                    'Berhasil' => 'Berhasil',
                    'Gagal' => 'Gagal',
                ])
                ->required(),

            DateTimePicker::make('waktu_pembayaran')
                ->label('Waktu Pembayaran')
                ->seconds(false)
                ->helperText('Kosongkan: terisi otomatis saat status diubah ke Berhasil.')
                ->columnSpanFull(),
        ])->columns(2);
    }
}