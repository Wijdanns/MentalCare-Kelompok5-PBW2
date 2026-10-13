<?php

namespace App\Filament\Resources\KategoriArtikels;

use App\Filament\Resources\KategoriArtikels\Pages\CreateKategoriArtikel;
use App\Filament\Resources\KategoriArtikels\Pages\EditKategoriArtikel;
use App\Filament\Resources\KategoriArtikels\Pages\ListKategoriArtikels;
use App\Filament\Resources\KategoriArtikels\Schemas\KategoriArtikelForm;
use App\Filament\Resources\KategoriArtikels\Tables\KategoriArtikelsTable;
use App\Models\KategoriArtikel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KategoriArtikelResource extends Resource
{
    protected static ?string $model = KategoriArtikel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;
    protected static string|UnitEnum|null $navigationGroup = 'Konten';
    protected static ?string $navigationLabel = 'Kategori Artikel';
    protected static ?string $modelLabel = 'Kategori Artikel';
    protected static ?string $pluralModelLabel = 'Kategori Artikel';
    protected static ?string $recordTitleAttribute = 'nama_kategori';

    public static function form(Schema $schema): Schema
    {
        return KategoriArtikelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KategoriArtikelsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKategoriArtikels::route('/'),
            'create' => CreateKategoriArtikel::route('/create'),
            'edit' => EditKategoriArtikel::route('/{record}/edit'),
        ];
    }
}