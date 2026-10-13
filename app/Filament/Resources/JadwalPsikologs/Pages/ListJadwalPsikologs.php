<?php

namespace App\Filament\Resources\JadwalPsikologs\Pages;

use App\Filament\Resources\JadwalPsikologs\JadwalPsikologResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJadwalPsikologs extends ListRecords
{
    protected static string $resource = JadwalPsikologResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
