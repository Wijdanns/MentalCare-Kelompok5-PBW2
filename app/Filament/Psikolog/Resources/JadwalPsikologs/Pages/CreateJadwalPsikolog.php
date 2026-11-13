<?php

namespace App\Filament\Psikolog\Resources\JadwalPsikologs\Pages;

use App\Filament\Psikolog\Resources\JadwalPsikologs\JadwalPsikologResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateJadwalPsikolog extends CreateRecord
{
    protected static string $resource = JadwalPsikologResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_psikolog'] = Auth::user()->psikolog->id;

        return $data;
    }
}


