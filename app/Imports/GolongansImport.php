<?php

namespace App\Imports;

use App\Models\Golongan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GolongansImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Golongan([
            'golongan' => $row['golongan'],
            'jenjang' => $row['jenjang'],
            'min_masa_kerja' => $row['min_masa_kerja'],
            'max_masa_kerja' => $row['max_masa_kerja'],
            'gaji_pokok' => $row['gaji_pokok'],
            'status' => $row['status'],
        ]);
    }
}
