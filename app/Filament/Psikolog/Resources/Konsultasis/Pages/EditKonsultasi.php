<?php

namespace App\Filament\Psikolog\Resources\Konsultasis\Pages;

use App\Filament\Psikolog\Resources\Konsultasis\KonsultasiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKonsultasi extends EditRecord
{
    protected static string $resource = KonsultasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
