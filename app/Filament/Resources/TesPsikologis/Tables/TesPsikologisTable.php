<?php

namespace App\Filament\Resources\TesPsikologis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TesPsikologisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_tes')
                    ->label('Nama Tes')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(60)
                    ->toggleable(),
                TextColumn::make('pertanyaan_count')
                    ->label('Jumlah Pertanyaan')
                    ->counts('pertanyaan')
                    ->badge()
                    ->sortable(),
                TextColumn::make('hasil_tes_count')
                    ->label('Dikerjakan')
                    ->counts('hasilTes')
                    ->suffix(' kali')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('nama_tes')
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