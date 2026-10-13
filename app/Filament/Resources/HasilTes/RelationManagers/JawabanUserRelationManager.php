<?php

namespace App\Filament\Resources\HasilTes\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class JawabanUserRelationManager extends RelationManager
{
    protected static string $relationship = 'jawabanUser';

    protected static ?string $title = 'Rincian Jawaban';
    protected static ?string $modelLabel = 'Jawaban';
    protected static ?string $pluralModelLabel = 'Jawaban';

    public function isReadOnly(): bool
    {
        return true;
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with([
                'pertanyaanPsikologis',
                'jawabanPsikologis',
            ]))
            ->columns([
                TextColumn::make('pertanyaanPsikologis.pertanyaan')
                    ->label('Pertanyaan')
                    ->wrap()
                    ->limit(120),
                TextColumn::make('jawabanPsikologis.jawaban')
                    ->label('Jawaban Dipilih')
                    ->badge(),
                TextColumn::make('poin')
                    ->label('Poin')
                    ->badge()
                    ->color('success'),
            ])
            ->defaultSort('id')
            ->paginated(false);
    }
}