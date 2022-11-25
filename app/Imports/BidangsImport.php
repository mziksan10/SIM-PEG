<?php

namespace App\Imports;

use App\Models\Bidang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class BidangsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Bidang([
            'kode_bidang' => $row['kode_bidang'],
            'nama_bidang' => $row['nama_bidang'],
        ]);
    }
}
