<?php

namespace App\Filament\Resources\JadwalPsikologs\Pages;

use App\Filament\Resources\JadwalPsikologs\JadwalPsikologResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJadwalPsikolog extends EditRecord
{
    protected static string $resource = JadwalPsikologResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
