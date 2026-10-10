<?php

namespace App\Filament\Resources\TesPsikologis\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PertanyaanRelationManager extends RelationManager
{
    protected static string $relationship = 'pertanyaan';

    protected static ?string $title = 'Daftar Pertanyaan';
    protected static ?string $modelLabel = 'Pertanyaan';
    protected static ?string $pluralModelLabel = 'Pertanyaan';
    protected static ?string $recordTitleAttribute = 'pertanyaan';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Textarea::make('pertanyaan')
                ->label('Pertanyaan')
                ->rows(3)
                ->required()
                ->columnSpanFull(),

            Repeater::make('jawabanPsikologis')
                ->relationship()
                ->label('Pilihan Jawaban dan Poin')
                ->helperText('Poin diatur per jawaban, jadi tiap pertanyaan boleh punya skor berbeda.')
                ->schema([
                    TextInput::make('jawaban')
                        ->label('Jawaban')
                        ->placeholder('Contoh: Setuju')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('poin')
                        ->label('Poin')
                        ->numeric()
                        ->integer()
                        ->required(),
                ])
                ->columns(2)
                ->minItems(2)
                ->defaultItems(5)
                ->addActionLabel('Tambah pilihan jawaban')
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('pertanyaan')
            ->columns([
                TextColumn::make('pertanyaan')
                    ->label('Pertanyaan')
                    ->searchable()
                    ->wrap()
                    ->limit(100),
                TextColumn::make('jawaban_psikologis_count')
                    ->label('Jumlah Jawaban')
                    ->counts('jawabanPsikologis')
                    ->badge(),
            ])
            ->defaultSort('id')
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}