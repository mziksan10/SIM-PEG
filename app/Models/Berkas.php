<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Jenis berkas
    private static $jenis_berkas = ['KTP', 'KK', 'Ijazah', 'Transkrip', 'Sertifikat', 'Lainnya'];
    public static function data_jenis_berkas(){
        return self::$jenis_berkas;
    }

    public function scopeFilter($query, array $filters){
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('jenis_berkas', 'like', '%' . $search . '%')
            ->orWhere('keterangan', 'like', '%' . $search . '%');  
        });
    }

    public function pegawai(){
        return $this->belongsTo(Pegawai::class);
    }   
}
