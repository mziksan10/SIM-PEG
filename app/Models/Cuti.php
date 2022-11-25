<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    private static $jenis_cuti = ['Cuti menikah', 'Cuti hamil & melahirkan', 'Cuti sakit' , 'Cuti besar' , 'Cuti penting'];

    public static function data_jenis_cuti(){
        return self::$jenis_cuti;
    }

    public function scopeFilter($query, array $filters){
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('nip', 'like', '%' . $search . '%');  
        });
    }

    public function pegawai(){
        return $this->belongsTo(Pegawai::class);
    }

}
