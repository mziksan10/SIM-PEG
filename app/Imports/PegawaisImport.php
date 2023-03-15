<?php

namespace App\Imports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class PegawaisImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row['status'] == 'TETAP'){
            $row['status'] = 1;
        }elseif($row['status'] == 'KONTRAK'){
            $row['status'] = 2;
        }elseif($row['status'] == 'MAGANG'){
            $row['status'] = 3;
        }
        return new Pegawai([
            'nip' => str_replace("'", "", $row['nip']),
            'nik' => str_replace("'", "", $row['nik']),
            'nama' => $row['nama'],
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir']),
            'jenis_kelamin' => $row['jenis_kelamin'],
            'status_pernikahan' => $row['status_pernikahan'],
            'alamat' => $row['alamat'],
            'desa' => $row['desa'],
            'kecamatan' => $row['kecamatan'],
            'kab_kota' => $row['kab_kota'],
            'provinsi' => $row['provinsi'],
            'kode_pos' => $row['kode_pos'],
            'no_hp' => str_replace("'", "", $row['no_hp']),
            'email' => $row['email'],
            'tanggal_masuk' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_masuk']),
            'status' => $row['status'],
        ]);
    }
}
