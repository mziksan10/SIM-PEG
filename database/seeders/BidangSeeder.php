<?php

namespace Database\Seeders;

use App\Models\Bidang;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bidang = [
            [
                'kode_bidang'=>'AKD',
                'nama_bidang'=>'AKADEMIK',
             ],            [
                'kode_bidang'=>'DM',
                'nama_bidang'=>'DIGITAL MARKETING',
             ],            [
                'kode_bidang'=>'FO',
                'nama_bidang'=>'FRONT OFFICE',
             ],            [
                'kode_bidang'=>'HW',
                'nama_bidang'=>'HARDWARE',
             ],            [
                'kode_bidang'=>'HI',
                'nama_bidang'=>'HUBUNGAN INTERNASIONAL',
             ],            [
                'kode_bidang'=>'KMH',
                'nama_bidang'=>'KEMAHASISWAAN',
             ],            [
                'kode_bidang'=>'KEU',
                'nama_bidang'=>'KEUANGAN',
             ],            [
                'kode_bidang'=>'SI',
                'nama_bidang'=>'SISTEM INFORMASI',
             ],            [
                'kode_bidang'=>'SDM',
                'nama_bidang'=>'UMUM & SDM',
             ],
        ];
        foreach ($bidang as $key => $value) {
            Bidang::create($value);
        }
    }
}
