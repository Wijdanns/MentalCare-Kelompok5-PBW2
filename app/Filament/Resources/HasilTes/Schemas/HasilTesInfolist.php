<?php

namespace App\Filament\Resources\HasilTes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class HasilTesInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('user.nama')
                ->label('Pasien'),

            TextEntry::make('tesPsikologis.nama_tes')
                ->label('Tes'),

            TextEntry::make('total_poin')
                ->label('Total Poin')
                ->badge()
                ->color('success'),

            TextEntry::make('jumlah_dijawab')
                ->label('Pertanyaan Dijawab')
                ->state(fn ($record) => $record->jawabanUser()->count()),

            TextEntry::make('created_at')
                ->label('Waktu Mengerjakan')
                ->dateTime('d M Y H:i'),
        ])->columns(2);
    }
}