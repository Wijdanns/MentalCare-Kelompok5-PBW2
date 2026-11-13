<?php

namespace App\Filament\Psikolog\Resources\JadwalPsikologs\Pages;

use App\Filament\Psikolog\Resources\JadwalPsikologs\JadwalPsikologResource;
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
