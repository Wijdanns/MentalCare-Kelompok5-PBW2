<?php

namespace App\Filament\Resources\HasilTes\Pages;

use App\Filament\Resources\HasilTes\HasilTesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHasilTes extends ListRecords
{
    protected static string $resource = HasilTesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
