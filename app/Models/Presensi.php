<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class);
    }
    
    public function scopeFilter($query, array $filters){
        return $query->when($filters['search'] ?? false, function($query, $search){
            $query->where('tanggal', 'like', '%' . $search . '%');
        });
    }
    
}
