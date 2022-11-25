<?php

namespace App\Exports;

use App\Models\Jabatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class JabatansExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Jabatan::get();
    }

    public function map($jabatan) : array{
        return[
            $jabatan->kode_jabatan,
            $jabatan->nama_jabatan,
            $jabatan->bidang->nama_bidang,
        ];
    }

    public function headings() : array{
        return [
            'Kode jabatan',
            'Nama jabatan',
            'Nama Bidang',
        ];
    }
}
