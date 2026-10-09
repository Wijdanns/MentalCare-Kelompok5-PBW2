<?php

namespace App\Filament\Resources\TesPsikologis\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TesPsikologisForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama_tes')
                ->label('Nama Tes')
                ->placeholder('Contoh: Tes Tingkat Stres')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            Textarea::make('deskripsi')
                ->label('Deskripsi')
                ->rows(5)
                ->columnSpanFull(),
        ]);
    }
}