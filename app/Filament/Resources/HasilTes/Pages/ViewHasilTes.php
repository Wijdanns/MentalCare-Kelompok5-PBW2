<?php

namespace App\Filament\Resources\HasilTes\Pages;

use App\Filament\Resources\HasilTes\HasilTesResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewHasilTes extends ViewRecord
{
    protected static string $resource = HasilTesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
