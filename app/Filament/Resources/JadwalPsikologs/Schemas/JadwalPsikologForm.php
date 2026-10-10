<?php

namespace App\Filament\Resources\JadwalPsikologs\Schemas;

use App\Models\JadwalPsikolog;
use Closure;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class JadwalPsikologForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('id_psikolog')
                ->label('Psikolog')
                ->relationship('psikolog', 'nama')
                ->searchable()
                ->preload()
                ->required()
                ->live()
                ->columnSpanFull(),

            DatePicker::make('tanggal')
                ->label('Tanggal')
                ->minDate(now()->startOfDay())
                ->required()
                ->live(),

            Select::make('status')
                ->label('Status')
                ->options([
                    'Tersedia' => 'Tersedia',
                    'Tidak Tersedia' => 'Tidak Tersedia',
                ])
                ->default('Tersedia')
                ->required(),

            TimePicker::make('jam_mulai')
                ->label('Jam Mulai')
                ->seconds(false)
                ->required()
                ->live(),

            TimePicker::make('jam_selesai')
                ->label('Jam Selesai')
                ->seconds(false)
                ->after('jam_mulai')
                ->required()
                ->rules([
                    fn (Get $get, ?Model $record): Closure => function (string $attribute, $value, Closure $fail) use ($get, $record) {
                        $idPsikolog = $get('id_psikolog');
                        $tanggal    = $get('tanggal');
                        $jamMulai   = $get('jam_mulai');

                        // Lewati pengecekan kalau data belum lengkap
                        if (! $idPsikolog || ! $tanggal || ! $jamMulai || ! $value) {
                            return;
                        }

                        $bentrok = JadwalPsikolog::query()
                            ->where('id_psikolog', $idPsikolog)
                            ->whereDate('tanggal', $tanggal)
                            ->when($record, fn ($q) => $q->where('id', '!=', $record->id))
                            ->where('jam_mulai', '<', $value)
                            ->where('jam_selesai', '>', $jamMulai)
                            ->first();

                        if ($bentrok) {
                            $mulai   = substr($bentrok->jam_mulai, 0, 5);
                            $selesai = substr($bentrok->jam_selesai, 0, 5);

                            $fail("Jadwal bentrok dengan jadwal lain pukul {$mulai} - {$selesai} di tanggal yang sama.");
                        }
                    },
                ]),
        ])->columns(2);
    }
}