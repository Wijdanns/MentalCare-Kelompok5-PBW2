<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profil')
                    ->label('Foto')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'admin' ? 'danger' : 'info')
                    ->sortable(),
                TextColumn::make('hasil_tes_count')
                    ->label('Tes Dikerjakan')
                    ->counts('hasilTes')
                    ->sortable(),
                TextColumn::make('konsultasi_count')
                    ->label('Konsultasi')
                    ->counts('konsultasi')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'pasien' => 'Pasien',
                        'admin' => 'Admin',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    // Admin tidak boleh menghapus akunnya sendiri
                    ->hidden(fn (User $record): bool => $record->id === Auth::id()),
            ]);
    }
}