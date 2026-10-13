<?php

namespace App\Filament\Resources\Artikels\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ArtikelsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->square(),
                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->limit(50)
                    ->sortable(),
                TextColumn::make('kategori.nama_kategori')
                    ->label('Kategori')
                    ->badge()
                    ->sortable(),
                TextColumn::make('user.nama')
                    ->label('Penulis')
                    ->toggleable(),
                TextColumn::make('tanggal_publikasi')
                    ->label('Publikasi')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('tanggal_publikasi', 'desc')
            ->filters([
                SelectFilter::make('id_kategori')
                    ->label('Kategori')
                    ->relationship('kategori', 'nama_kategori'),
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