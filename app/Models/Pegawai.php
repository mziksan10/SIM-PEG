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

    // Static jenis status
    private static $status = ['1', '2'];
    public static function data_status(){
        return self::$status;
    }

    // Static jenis jenjang
    private static $pendidikan = ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3', 'Lainnya'];
    public static function data_pendidikan(){
        return self::$pendidikan;
    }

    // Static jenis kelamin
    private static $jenis_kelamin = ['Laki-laki', 'Perempuan'];
    public static function data_jenis_kelamin(){
        return self::$jenis_kelamin;
    }
    
    // Static jenis berkas
    private static $jenis_berkas = ['KTP', 'KK', 'Ijazah', 'Transkrip', 'Sertifikat', 'Lainnya'];
    public static function data_jenis_berkas(){
        return self::$jenis_berkas;
    }

    // Filter
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

    public function golongan(){
        return $this->belongsTo(Golongan::class);
    }

    public function riwayatJabatan(){
        return $this->hasOne(RiwayatJabatan::class)->latestOfMany();
    }

    public function riwayatJabatan_(){
        return $this->hasMany(RiwayatJabatan::class);
    }

    public function riwayatPendidikan(){
        return $this->hasOne(RiwayatPendidikan::class)->latestOfMany();
    }

    public function riwayatPendidikan_(){
        return $this->hasMany(RiwayatPendidikan::class);
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
