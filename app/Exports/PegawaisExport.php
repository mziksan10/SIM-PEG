<?php

namespace App\Exports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PegawaisExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pegawai::get();
    }

    public function map($pegawai) : array{
        if($pegawai->riwayatJabatan){
            $bidang = $pegawai->riwayatJabatan->bidang->nama_bidang;
            $jabatan = $pegawai->riwayatJabatan->jabatan->nama_jabatan;
            $golongan = $pegawai->riwayatJabatan->golongan->golongan;   
        }else{
            $bidang = '';
            $jabatan = '';
            $golongan = ''; 
        }
        
        if($pegawai->status == 'Aktif'){
            $pegawai->status = 'Aktif';
        }elseif($pegawai->status == 'Non Aktif'){
            $pegawai->status = 'Non Aktif';
        }
        return[
            "'" . $pegawai->nip,
            "'" . $pegawai->nik,
            $pegawai->nama,
            $pegawai->tempat_lahir,
            $pegawai->tanggal_lahir,
            $pegawai->jenis_kelamin,
            $pegawai->alamat,
            $pegawai->desa,
            $pegawai->kecamatan,
            $pegawai->kab_kota,
            $pegawai->provinsi,
            $pegawai->kode_pos,
            $pegawai->no_hp,
            $pegawai->email,
            $pegawai->pendidikan,
            $pegawai->jurusan,
            $bidang,
            $jabatan,
            $golongan,
            $pegawai->bank,
            $pegawai->no_rekening,
            $pegawai->tanggal_masuk,
            $pegawai->status,
        ];
    }

    public function headings() : array{
        return [
            'NIP',
            'Nama',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Alamat',
            'Desa',
            'Kecamatan',
            'Kabupaten/Kota',
            'Provinsi',
            'Kode Pos',
            'No. Handphone',
            'Email',
            'Pendidikan',
            'Jurusan',
            'Bidang',
            'Jabatan',
            'Golongan',
            'Bank',
            'No Rekening',
            'Tanggal Masuk',
            'Status',
        ];
    }
}
