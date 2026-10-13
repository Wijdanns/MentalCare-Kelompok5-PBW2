<?php

namespace App\Filament\Resources\JadwalPsikologs;

use App\Filament\Resources\JadwalPsikologs\Pages\CreateJadwalPsikolog;
use App\Filament\Resources\JadwalPsikologs\Pages\EditJadwalPsikolog;
use App\Filament\Resources\JadwalPsikologs\Pages\ListJadwalPsikologs;
use App\Filament\Resources\JadwalPsikologs\Schemas\JadwalPsikologForm;
use App\Filament\Resources\JadwalPsikologs\Tables\JadwalPsikologsTable;
use App\Models\JadwalPsikolog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class JadwalPsikologResource extends Resource
{
    protected static ?string $model = JadwalPsikolog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;
    protected static string|UnitEnum|null $navigationGroup = 'Konsultasi';
    protected static ?string $navigationLabel = 'Jadwal Psikolog';
    protected static ?string $modelLabel = 'Jadwal Psikolog';
    protected static ?string $pluralModelLabel = 'Jadwal Psikolog';

    public static function form(Schema $schema): Schema
    {
        return JadwalPsikologForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JadwalPsikologsTable::configure($table);
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
            'index' => ListJadwalPsikologs::route('/'),
            'create' => CreateJadwalPsikolog::route('/create'),
            'edit' => EditJadwalPsikolog::route('/{record}/edit'),
        ];
    }
}
