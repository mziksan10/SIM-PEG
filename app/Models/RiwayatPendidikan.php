<?php

namespace App\Models;

use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPendidikan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Static Jenjang
    private static $jenjang = ['SMA/SMK', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3', 'Lainnya'];
    public static function jenjang(){
        return self::$jenjang;
    }

    public function pegawai(){
        return $this->belongsTo(Pegawai::class);
    }
}
