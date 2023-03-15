<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AturanPresensi;

class AturanPresensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aturanPresensi = [
            [
                'sesi' => '1',
                'jam_masuk' => '07:45',
                'batas_min' => '07:00',
                'batas_max' => '08:30',
                'late_1' => '08:00',
                'late_2' => '08:15',
                'late_3' => '08:30',
            ],[
                'sesi' => '2',
                'jam_masuk' => '11:00',
                'batas_min' => '10:15',
                'batas_max' => '11:45',
                'late_1' => '11:15',
                'late_2' => '11:30',
                'late_3' => '11:45',
            ]
        ];
        foreach ($aturanPresensi as $key => $value) {
            AturanPresensi::create($value);
        }
    }
}
