<?php

namespace App\Filament\Resources\JadwalPsikologs\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class JadwalPsikologForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id_psikolog')
                ->label('Psikolog')
                ->relationship('psikolog', 'nama')
                ->searchable()
                ->preload()
                ->required()
                ->columnSpanFull(),

            DatePicker::make('tanggal')
                ->label('Tanggal')
                ->minDate(now()->startOfDay())
                ->required(),

            Select::make('status')
                ->label('Status')
                ->options([
                    'Tersedia' => 'Tersedia',
                    'Tidak Tersedia' => 'Tidak Tersedia',
                ])
                ->default('Tersedia')
                ->required(),

            TimePicker::make('jam_mulai')
                ->label('Jam Mulai')
                ->seconds(false)
                ->required(),

            TimePicker::make('jam_selesai')
                ->label('Jam Selesai')
                ->seconds(false)
                ->after('jam_mulai')
                ->required(),
        ])->columns(2);
    }
}
