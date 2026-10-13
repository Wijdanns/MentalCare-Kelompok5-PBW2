<?php

namespace App\Filament\Resources\KategoriArtikels\Pages;

use App\Filament\Resources\KategoriArtikels\KategoriArtikelResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKategoriArtikel extends EditRecord
{
    protected static string $resource = KategoriArtikelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
