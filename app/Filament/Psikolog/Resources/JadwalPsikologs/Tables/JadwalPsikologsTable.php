<?php

namespace App\Filament\Psikolog\Resources\JadwalPsikologs\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class JadwalPsikologsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal')->label('Tanggal')->date('d M Y')->sortable(),
                TextColumn::make('jam_mulai')->label('Mulai')->time('H:i'),
                TextColumn::make('jam_selesai')->label('Selesai')->time('H:i'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Tersedia' => 'success',
                        'Tidak Tersedia' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('konsultasi.user.nama')
                    ->label('Dipesan oleh')
                    ->placeholder('-'),
            ])
            ->defaultSort('tanggal', 'desc')
            ->filters([
                SelectFilter::make('status')->options([
                    'Tersedia' => 'Tersedia',
                    'Tidak Tersedia' => 'Tidak Tersedia',
                ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}