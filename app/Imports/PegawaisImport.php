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
        return new Pegawai([
            'nip' => $row['nip'],
            'nama' => $row['nama'],
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir' => $row['tanggal_lahir'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'alamat' => $row['alamat'],
            'desa' => $row['desa'],
            'kecamatan' => $row['kecamatan'],
            'kab_kota' => $row['kab_kota'],
            'provinsi' => $row['provinsi'],
            'kode_pos' => $row['kode_pos'],
            'no_hp' => $row['no_hp'],
            'email' => $row['email'],
            'pendidikan' => $row['pendidikan'],
            'jurusan' => $row['jurusan'],
            'bank' => $row['bank'],
            'no_rekening' => $row['no_rekening'],
            'tanggal_masuk' => $row['tanggal_masuk'],
            'status' => $row['status'],
        ]);
    }
}
