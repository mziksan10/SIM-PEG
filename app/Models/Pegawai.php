<?php

namespace App\Models;

use App\Models\Berkas;
use App\Models\Bidang;
use App\Models\Jabatan;
use App\Models\Golongan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    private static $jenis_kelamin = ['L', 'P'];

    private static $status = ['Aktif', 'Non Aktif'];
    
    private static $pendidikan = ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3', 'Lainnya'];

    private static $jenis_berkas = ['KTP', 'KK', 'Ijazah', 'Transkrip', 'Sertifikat', 'Lainnya'];


    public static function data_status(){
        return self::$status;
    }

    public static function data_pendidikan(){
        return self::$pendidikan;
    }

    public static function data_jenis_kelamin(){
        return self::$jenis_kelamin;
    }

    public static function data_jenis_berkas(){
        return self::$jenis_berkas;
    }

    public function scopeFilter($query, array $filters){
        return $query->when($filters['search'] ?? false, function($query, $search){
            $query->where('nip', 'like', '%' . $search . '%')->orWhere('nama', 'like', '%' . $search . '%');
        });

        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->whereHas('berkas', function($query) use($search){
                $query->where('jenis_berkas', 'like', '%' . $search . '%');
            });
        });
    }

    public function riwayatJabatan(){
        return $this->hasOne(RiwayatJabatan::class)->latestOfMany();
    }

    public function berkas(){
        return $this->hasMany(Berkas::class);
    }

    public function cuti(){
        return $this->hasMany(Cuti::class)->latestOfMany();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
