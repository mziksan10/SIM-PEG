<?php

namespace App\Exports;

use App\Models\Bidang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BidangsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Bidang::get();
    }

    public function map($bidang) : array{
        return[
            $bidang->kode_bidang,
            $bidang->nama_bidang,
        ];
    }

    public function headings() : array{
        return [
            'Kode Bidang',
            'Nama Bidang',
        ];
    }
}
