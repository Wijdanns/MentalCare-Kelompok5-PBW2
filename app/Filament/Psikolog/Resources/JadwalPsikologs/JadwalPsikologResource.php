<?php

namespace App\Filament\Psikolog\Resources\JadwalPsikologs;

use App\Filament\Psikolog\Resources\JadwalPsikologs\Pages\CreateJadwalPsikolog;
use App\Filament\Psikolog\Resources\JadwalPsikologs\Pages\EditJadwalPsikolog;
use App\Filament\Psikolog\Resources\JadwalPsikologs\Pages\ListJadwalPsikologs;
use App\Filament\Psikolog\Resources\JadwalPsikologs\Schemas\JadwalPsikologForm;
use App\Filament\Psikolog\Resources\JadwalPsikologs\Tables\JadwalPsikologsTable;
use App\Models\JadwalPsikolog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class JadwalPsikologResource extends Resource
{
    protected static ?string $model = JadwalPsikolog::class;
    protected static ?string $navigationLabel = 'Jadwal Saya';
    protected static ?string $modelLabel = 'Jadwal';
    protected static ?string $pluralModelLabel = 'Jadwal Saya';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return JadwalPsikologForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JadwalPsikologsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('id_psikolog', Auth::user()->psikolog->id);
    }

    public static function canEdit(Model $record): bool
    {
        return ! $record->konsultasi()->exists();
    }

    public static function canDelete(Model $record): bool
    {
        return ! $record->konsultasi()->exists();
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
