<?php

namespace App\Filament\Resources\HasilTes\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class HasilTesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.nama')
                    ->label('Pasien')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tesPsikologis.nama_tes')
                    ->label('Tes')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('total_poin')
                    ->label('Total Poin')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Waktu Mengerjakan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('id_tes')
                    ->label('Tes')
                    ->relationship('tesPsikologis', 'nama_tes'),
            ])
            ->recordActions([
                ViewAction::make()->label('Lihat Rincian'),
            ]);
    }
}