<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Static jenis berkas
    private static $jenisBerkas = ['Asli', 'Fotokopi '];
    public static function jenisBerkas(){
        return self::$jenisBerkas;
    }

    // Filter
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
