<?php

namespace App\Filament\Psikolog\Resources\Konsultasis;

use App\Filament\Psikolog\Resources\Konsultasis\Pages\CreateKonsultasi;
use App\Filament\Psikolog\Resources\Konsultasis\Pages\EditKonsultasi;
use App\Filament\Psikolog\Resources\Konsultasis\Pages\ListKonsultasis;
use App\Filament\Psikolog\Resources\Konsultasis\Schemas\KonsultasiForm;
use App\Filament\Psikolog\Resources\Konsultasis\Tables\KonsultasisTable;
use App\Models\Konsultasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class KonsultasiResource extends Resource
{
    protected static ?string $model = Konsultasi::class;
    protected static ?string $navigationLabel = 'Konsultasi Masuk';
    protected static ?string $modelLabel = 'Konsultasi';
    protected static ?string $pluralModelLabel = 'Konsultasi Masuk';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return KonsultasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KonsultasisTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('id_psikolog', Auth::user()->psikolog->id)
            ->whereIn('status_konsultasi', ['Dikonfirmasi', 'Selesai'])
            ->with(['user', 'jadwal']);
    }

    public static function canCreate(): bool { return false; }
    public static function canEdit(Model $record): bool { return false; }
    public static function canDelete(Model $record): bool { return false; }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKonsultasis::route('/'),
        ];
    }
}
