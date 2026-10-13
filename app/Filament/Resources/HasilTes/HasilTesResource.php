<?php

namespace App\Filament\Resources\HasilTes;

use App\Filament\Resources\HasilTes\Pages\ListHasilTes;
use App\Filament\Resources\HasilTes\Pages\ViewHasilTes;
use App\Filament\Resources\HasilTes\RelationManagers\JawabanUserRelationManager;
use App\Filament\Resources\HasilTes\Schemas\HasilTesInfolist;
use App\Filament\Resources\HasilTes\Tables\HasilTesTable;
use App\Models\HasilTes;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class HasilTesResource extends Resource
{
    protected static ?string $model = HasilTes::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;
    protected static string|UnitEnum|null $navigationGroup = 'Tes Psikologis';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Hasil Tes';
    protected static ?string $modelLabel = 'Hasil Tes';
    protected static ?string $pluralModelLabel = 'Hasil Tes';

    // Hasil tes dibuat oleh pasien, admin hanya memantau
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return HasilTesInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HasilTesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            JawabanUserRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHasilTes::route('/'),
            'view' => ViewHasilTes::route('/{record}'),
        ];
    }
}