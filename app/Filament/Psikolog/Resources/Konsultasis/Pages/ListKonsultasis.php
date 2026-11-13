<?php

namespace App\Filament\Psikolog\Resources\Konsultasis\Pages;

use App\Filament\Psikolog\Resources\Konsultasis\KonsultasiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKonsultasis extends ListRecords
{
    protected static string $resource = KonsultasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
