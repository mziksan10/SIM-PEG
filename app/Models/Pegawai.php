<?php

namespace App\Models;

use App\Models\Berkas;
use App\Models\Bidang;
use App\Models\Jabatan;
use App\Models\Golongan;
use App\Models\Desa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Static jenis status
    private static $status = ['1', '2', '0'];
    public static function status(){
        return self::$status;
    }

    // Status pernikahan
    private static $statusPernikahan = ['Lajang', 'Menikah'];
    public static function statusPernikahan(){
        return self::$statusPernikahan;
    }

    // Static jenis jenjang
    private static $statusJenjang = ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3', 'Lainnya'];
    public static function statusJenjang(){
        return self::$statusJenjang;
    }

    // Static jenis kelamin
    private static $jenisKelamin = ['Laki-laki', 'Perempuan'];
    public static function jenisKelamin(){
        return self::$jenisKelamin;
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

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function subdistricts(){
        return $this->hasOne(Desa::class, 'subdis_id', 'desa');
    }

    public function provinces(){
        return $this->hasOne(Provinsi::class, 'prov_id', 'provinsi');
    }
    
    public function cities(){
        return $this->hasOne(Kota::class, 'city_id', 'kab_kota');
    }

    public function districts(){
        return $this->hasOne(Kecamatan::class, 'dis_id', 'kecamatan');
    }

    public function tempatLahir(){
        return $this->hasOne(Kota::class, 'city_id', 'tempat_lahir');
    }

}
