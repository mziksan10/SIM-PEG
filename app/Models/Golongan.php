<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    private static $status = ['Kontrak', 'Tetap'];

    private static $pendidikan = ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3', 'Lainnya'];

    public static function data_pendidikan(){
        return self::$pendidikan;
    }

    public static function data_status(){
        return self::$status;
    }

    public function scopeFilter($query, array $filters){
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('golongan', 'like', '%' . $search . '%')
            ->orWhere('pendidikan', 'like', '%' . $search . '%');  
        });
    }
}
