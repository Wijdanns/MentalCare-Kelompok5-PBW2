<?php

namespace App\Filament\Resources\Konsultasis;

use App\Filament\Resources\Konsultasis\Pages\CreateKonsultasi;
use App\Filament\Resources\Konsultasis\Pages\EditKonsultasi;
use App\Filament\Resources\Konsultasis\Pages\ListKonsultasis;
use App\Filament\Resources\Konsultasis\Schemas\KonsultasiForm;
use App\Filament\Resources\Konsultasis\Tables\KonsultasisTable;
use App\Models\Konsultasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KonsultasiResource extends Resource
{
    protected static ?string $model = Konsultasi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;
    protected static string|UnitEnum|null $navigationGroup = 'Konsultasi';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Konsultasi';
    protected static ?string $modelLabel = 'Konsultasi';
    protected static ?string $pluralModelLabel = 'Konsultasi';

    public static function form(Schema $schema): Schema
    {
        return KonsultasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KonsultasisTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKonsultasis::route('/'),
            'create' => CreateKonsultasi::route('/create'),
            'edit' => EditKonsultasi::route('/{record}/edit'),
        ];
    }
}