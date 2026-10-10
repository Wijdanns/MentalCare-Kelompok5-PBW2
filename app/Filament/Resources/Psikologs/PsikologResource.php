<?php

namespace App\Filament\Resources\Psikologs;

use App\Filament\Resources\Psikologs\Pages\CreatePsikolog;
use App\Filament\Resources\Psikologs\Pages\EditPsikolog;
use App\Filament\Resources\Psikologs\Pages\ListPsikologs;
use App\Filament\Resources\Psikologs\Schemas\PsikologForm;
use App\Filament\Resources\Psikologs\Tables\PsikologsTable;
use App\Models\Psikolog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
Use UnitEnum;

class PsikologResource extends Resource
{
    protected static ?string $model = Psikolog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;
    protected static string|UnitEnum|null $navigationGroup = 'Konsultasi';
    protected static ?string $navigationLabel = 'Psikolog';
    protected static ?string $modelLabel = 'Psikolog';
    protected static ?string $pluralModelLabel = 'Psikolog';
    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return PsikologForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PsikologsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPsikologs::route('/'),
            'create' => CreatePsikolog::route('/create'),
            'edit' => EditPsikolog::route('/{record}/edit'),
        ];
    }
}
