<?php

namespace App\Filament\Resources\Psikologs\Pages;

use App\Filament\Resources\Psikologs\PsikologResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPsikolog extends EditRecord
{
    protected static string $resource = PsikologResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
