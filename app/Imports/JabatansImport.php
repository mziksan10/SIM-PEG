<?php

namespace App\Imports;

use App\Models\Jabatan;
use App\Models\Bidang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class JabatansImport implements ToModel, WithHeadingRow
{
    private $bidangs;
    public function __construct(){
        $this->bidangs = Bidang::select('id', 'nama_bidang')->get();
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $bidang = $this->bidangs->where('nama_bidang', $row['nama_bidang'])->first();
        return new Jabatan([
            'kode_jabatan' => $row['kode_jabatan'],
            'nama_jabatan' => $row['nama_jabatan'],
            'bidang_id' => $bidang->id ?? null,
        ]);
    }
}
