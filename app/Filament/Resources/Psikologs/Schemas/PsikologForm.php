<?php

namespace App\Filament\Resources\Psikologs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PsikologForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->maxLength(255)
                    ->required(),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('spesialis')
                    ->label('Spesialisasi')
                    ->required()
                    ->maxLength(255),

                Textarea::make('deskripsi_psikolog')
                    ->label('Deskripsi')
                    ->rows(5)
                    ->columnSpanFull(),

                FileUpload::make('foto_profil')
                    ->label('Foto Profil')
                ->image()
                ->avatar()
                ->disk('public')
                ->directory('psikolog')
                ->visibility('public')
                ->imageEditor()
                ->columnSpanFull(),

                TextInput::make('biaya')
                    ->label('Biaya per Sesi')
                    ->numeric()
                    ->prefix('Rp')
                    ->minValue(0)
                    ->required(),
            ])->columns(2);
    }
}
