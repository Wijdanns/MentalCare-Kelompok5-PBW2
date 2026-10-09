<?php

namespace App\Filament\Resources\Konsultasis\Schemas;

use App\Models\JadwalPsikolog;
use App\Models\Psikolog;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class KonsultasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('id_user')
                ->label('Pasien')
                ->relationship('user', 'nama', fn (Builder $query) => $query->where('role', 'pasien'))
                ->searchable()
                ->preload()
                ->required(),

            Select::make('id_psikolog')
                ->label('Psikolog')
                ->relationship('psikolog', 'nama')
                ->searchable()
                ->preload()
                ->required()
                ->live()
                ->afterStateUpdated(function (Set $set, $state) {
                    // Ganti psikolog: reset jadwal, isi biaya otomatis
                    $set('id_jadwal', null);
                    $set('total_biaya', $state ? Psikolog::find($state)?->biaya : null);
                }),

            Select::make('id_jadwal')
                ->label('Jadwal')
                ->options(function (Get $get, ?Model $record) {
                    $idPsikolog = $get('id_psikolog');

                    if (! $idPsikolog) {
                        return [];
                    }

                    return JadwalPsikolog::query()
                        ->where('id_psikolog', $idPsikolog)
                        ->where(function (Builder $query) use ($record) {
                            // Slot yang masih kosong dan belum lewat...
                            $query->where(fn (Builder $q) => $q
                                ->where('status', 'Tersedia')
                                ->whereDate('tanggal', '>=', today()));

                            // ...ditambah jadwal yang sedang dipakai konsultasi ini (saat edit)
                            if ($record) {
                                $query->orWhere('id', $record->id_jadwal);
                            }
                        })
                        ->orderBy('tanggal')
                        ->orderBy('jam_mulai')
                        ->get()
                        ->mapWithKeys(fn (JadwalPsikolog $jadwal) => [
                            $jadwal->id => $jadwal->tanggal->format('d M Y')
                                . ', ' . substr($jadwal->jam_mulai, 0, 5)
                                . ' - ' . substr($jadwal->jam_selesai, 0, 5),
                        ]);
                })
                ->placeholder(fn (Get $get) => $get('id_psikolog')
                    ? 'Pilih jadwal tersedia'
                    : 'Pilih psikolog terlebih dahulu')
                ->disabled(fn (Get $get) => ! $get('id_psikolog'))
                ->searchable()
                ->required(),

            Select::make('metode')
                ->label('Metode')
                ->options([
                    'Online' => 'Online',
                    'Offline' => 'Offline',
                ])
                ->required(),

            TextInput::make('total_biaya')
                ->label('Total Biaya')
                ->numeric()
                ->prefix('Rp')
                ->readOnly()
                ->helperText('Terisi otomatis dari biaya psikolog.')
                ->required(),

            Select::make('status_konsultasi')
                ->label('Status')
                ->options([
                    'Menunggu Pembayaran' => 'Menunggu Pembayaran',
                    'Dikonfirmasi' => 'Dikonfirmasi',
                    'Selesai' => 'Selesai',
                    'Batal' => 'Batal',
                ])
                ->default('Menunggu Pembayaran')
                ->required(),
        ])->columns(2);
    }
}