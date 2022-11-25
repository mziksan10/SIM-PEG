<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jabatan = [
            [
                'kode_jabatan'=>'DIR',
                'nama_jabatan'=>'DIREKTUR',
            ],
            [
                'kode_jabatan'=>'WADIR',
                'nama_jabatan'=>'WAKIL DIREKTUR',
            ],
            [
                'kode_jabatan'=>'KABAG',
                'nama_jabatan'=>'KEPALA BAGIAN',
            ],
            [
                'kode_jabatan'=>'KASUBAG',
                'nama_jabatan'=>'KEPALA SUB BAGIAN',
            ],
            [
                'kode_jabatan'=>'ST',
                'nama_jabatan'=>'STAFF',
            ],
            [
                'kode_jabatan'=>'CS',
                'nama_jabatan'=>'CLEANING SERVICE',
            ],
            [
                'kode_jabatan'=>'SAT',
                'nama_jabatan'=>'SATPAM',
            ],
            [
                'kode_jabatan'=>'SOP',
                'nama_jabatan'=>'SOPIR',
            ],
            [
                'kode_jabatan'=>'DIR',
                'nama_jabatan'=>'DIREKTUR',
            ],
        ];
        foreach ($jabatan as $key => $value) {
            Jabatan::create($value);
        }
    }
}
