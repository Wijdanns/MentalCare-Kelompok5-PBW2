<?php

namespace App\Filament\Resources\Psikologs\Pages;

use App\Filament\Resources\Psikologs\PsikologResource;
use App\Models\Psikolog;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreatePsikolog extends CreateRecord
{
    protected static string $resource = PsikologResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            // 1. buat akun login
            $user = User::create([
                'nama'     => $data['nama'],
                'email'    => $data['email'],
                'password' => $data['password'], 
                'role'     => 'psikolog',
            ]);

            // 2. buat profil psikolog, lalu sambungkan ke user
            unset($data['password']); // kolom ini tidak ada di tabel psikolog
            return Psikolog::create($data + ['id_user' => $user->id]);
        });
    }
}