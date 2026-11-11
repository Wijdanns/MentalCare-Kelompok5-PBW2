<?php

namespace App\Filament\Resources\Konsultasis\Pages;

use App\Filament\Resources\Konsultasis\KonsultasiResource;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListKonsultasis extends ListRecords
{
    protected static string $resource = KonsultasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
             Action::make('exportExcel')
                ->label('Unduh Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->url(route('konsultasi.export')),
        ];
    }
}
