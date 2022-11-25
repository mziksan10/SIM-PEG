<?php

namespace App\Exports;

use App\Models\Golongan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GolongansExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Golongan::get();
    }

    public function map($golongan) : array{
        if($golongan->status == 'Kontrak'){
            $golongan->status = 'Kontrak';
        }elseif($golongan->status == 'Tetap'){
            $golongan->status = 'Tetap';
        }
        return[
            $golongan->id,
            $golongan->golongan,
            $golongan->pendidikan,
            $golongan->masa_kerja,
            'Rp. '. number_format($golongan->gaji_pokok, 2,',','.') . ',-',
            $golongan->status,
        ];
    }

    public function headings() : array{
        return [
            'Id',
            'Golongan',
            'Pendidikan',
            'Masa Kerja',
            'Gaji Pokok',
            'Status',
        ];
    }
}
