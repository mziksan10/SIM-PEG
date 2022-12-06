<?php

namespace App\Exports;

use App\Models\Presensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;


class PresensisExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $rekapPresensi = Presensi::whereBetween('tanggal', [request()->fromDate, request()->toDate]);
        return $rekapPresensi->get();
    }

    public function map($presensi) : array{
            return[
                "'" . $presensi->pegawai->nip,
                $presensi->pegawai->nama,
                $presensi->tanggal,
                $presensi->jam_masuk,
                $presensi->jam_keluar,
                $presensi->sesi,
                $presensi->status,
                $presensi->keterangan,
            ];
    }

    public function headings() : array{
        return [
            'NIP',
            'Nama',
            'Tanggal',
            'Jam Masuk',
            'Jam Keluar',
            'Sesi',
            'Status',
            'Keterangan',
        ];
    }
    
}
