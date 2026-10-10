<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')
                ->label('Nama')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->revealable()
                ->minLength(8)
                ->required(fn (string $operation): bool => $operation === 'create')
                ->dehydrated(fn ($state): bool => filled($state))
                ->helperText(fn (string $operation): ?string => $operation === 'edit'
                    ? 'Kosongkan jika tidak ingin mengubah password.'
                    : null),

            Select::make('role')
                ->label('Role')
                ->options([
                    'pasien' => 'Pasien',
                    'admin' => 'Admin',
                ])
                ->default('pasien')
                ->required(),

            FileUpload::make('profil')
                ->label('Foto Profil')
                ->image()
                ->avatar()
                ->disk('public')
                ->directory('profil')
                ->visibility('public')
                ->columnSpanFull(),
        ])->columns(2);
    }
}