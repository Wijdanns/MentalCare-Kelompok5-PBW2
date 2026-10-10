<?php

namespace App\Filament\Resources\Psikologs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class PsikologsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('spesialis')
                    ->label('Spesialisasi')
                    ->badge()
                    ->searchable(),
                ImageColumn::make('foto_profil')
                    ->label('Profil')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('biaya')
                    ->label('Biaya')
                    ->money('IDR', locale:'id')
                    ->sortable(),
                TextColumn::make('jadwal_count')
                    ->label('Jumlah Jadwal')
                    ->counts('jadwal')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
