<?php

namespace App\Filament\Resources\TesPsikologis\Pages;

use App\Filament\Resources\TesPsikologis\TesPsikologisResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTesPsikologis extends EditRecord
{
    protected static string $resource = TesPsikologisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
