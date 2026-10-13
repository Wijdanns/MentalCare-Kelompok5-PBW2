<?php

namespace App\Filament\Resources\TesPsikologis;

use App\Filament\Resources\TesPsikologis\Pages\CreateTesPsikologis;
use App\Filament\Resources\TesPsikologis\Pages\EditTesPsikologis;
use App\Filament\Resources\TesPsikologis\Pages\ListTesPsikologis;
use App\Filament\Resources\TesPsikologis\RelationManagers\PertanyaanRelationManager;
use App\Filament\Resources\TesPsikologis\Schemas\TesPsikologisForm;
use App\Filament\Resources\TesPsikologis\Tables\TesPsikologisTable;
use App\Models\TesPsikologis;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TesPsikologisResource extends Resource
{
    protected static ?string $model = TesPsikologis::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;
    protected static string|UnitEnum|null $navigationGroup = 'Tes Psikologis';
    protected static ?string $navigationLabel = 'Tes Psikologis';
    protected static ?string $modelLabel = 'Tes Psikologis';
    protected static ?string $pluralModelLabel = 'Tes Psikologis';
    protected static ?string $recordTitleAttribute = 'nama_tes';

    public static function form(Schema $schema): Schema
    {
        return TesPsikologisForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TesPsikologisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            PertanyaanRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTesPsikologis::route('/'),
            'create' => CreateTesPsikologis::route('/create'),
            'edit' => EditTesPsikologis::route('/{record}/edit'),
        ];
    }
}