<?php

namespace App\Exports;

use App\Models\Konsultasi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Builder;

class KonsultasiExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    private int $no = 0;

    public function __construct(private ?int $userId = null)
    {
    }

    public function query(): Builder
    {
        return Konsultasi::query()
            ->with(['psikolog', 'jadwal', 'pembayaran'])
            ->when($this->userId, fn ($q) => $q->where('id_user', $this->userId))
            ->orderByDesc('id');
    }

    public function headings(): array
    {
        return [
            'No',
            'Psikolog',
            'Tanggal',
            'Jam Mulai',
            'Metode Pembayaran',
            'Status Pembayaran',
            'Status Konsultasi',
            'Total Biaya',
        ];
    }

    public function map($k): array
    {
        return [
            ++$this->no,
            $k->psikolog->nama ?? '-',
            $k->jadwal?->tanggal ? Carbon::parse($k->jadwal->tanggal)->format('d-m-Y') : '-',
            $k->jadwal->jam_mulai ?? '-',
            $k->pembayaran->metode_pembayaran ?? '-',
            $k->pembayaran->status_pembayaran ?? '-',
            $k->status_konsultasi,
            $k->total_biaya,
        ];
    }
}