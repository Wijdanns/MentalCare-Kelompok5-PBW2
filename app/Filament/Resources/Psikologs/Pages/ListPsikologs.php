<?php

namespace App\Filament\Resources\Psikologs\Pages;

use App\Filament\Resources\Psikologs\PsikologResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPsikologs extends ListRecords
{
    protected static string $resource = PsikologResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
