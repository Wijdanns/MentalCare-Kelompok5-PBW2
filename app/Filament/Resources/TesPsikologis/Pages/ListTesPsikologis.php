<?php

namespace App\Filament\Resources\TesPsikologis\Pages;

use App\Filament\Resources\TesPsikologis\TesPsikologisResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTesPsikologis extends ListRecords
{
    protected static string $resource = TesPsikologisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
