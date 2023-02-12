<?php

namespace App\Imports;

use App\Models\RiwayatJabatan;
use App\Models\Pegawai;
use App\Models\Golongan;
use App\Models\Bidang;
use App\Models\Jabatan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class RiwayatJabatansImport implements ToModel, WithHeadingRow
{
    private $pegawais;
    private $golongans;
    private $bidangs;
    private $jabatans;
    public function __construct(){
        $this->pegawais = Pegawai::select('id', 'nip')->get();
        $this->golongans = Golongan::select('id', 'golongan')->get();
        $this->bidangs = Bidang::select('id', 'nama_bidang')->get();
        $this->jabatans = Jabatan::select('id', 'nama_jabatan', 'bidang_id')->get();
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $pegawai = $this->pegawais->where('nip', str_replace("'", "", $row['nip']))->first();
        $golongan = $this->golongans->where('golongan', $row['golongan'])->first();
        $bidang = $this->bidangs->where('nama_bidang', $row['nama_bidang'])->first();
        $jabatan = $this->jabatans->where('nama_jabatan', $row['nama_jabatan'])->where('bidang_id', $bidang->id)->first();
        if($bidang->id == isset($jabatan['bidang_id'])){
            $jabatan = $this->jabatans->where('nama_jabatan', $row['nama_jabatan'])->where('bidang_id', $bidang->id)->first();
            $statusUpdate['status'] = 'Aktif';
            Pegawai::where('id', $pegawai->id)->update($statusUpdate);
            return new RiwayatJabatan([
                'pegawai_id' => $pegawai->id ?? null,
                'bidang_id' => $bidang->id ?? null,
                'jabatan_id' => $jabatan->id ?? null,
                'golongan_id' => $golongan->id ?? null,
                'no_sk' => $row['no_sk'],
                'tanggal_sk' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_sk']),
            ]);
        }
    }

}
