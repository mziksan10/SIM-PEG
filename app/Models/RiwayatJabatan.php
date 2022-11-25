<?php

namespace App\Models;

use App\Models\Jabatan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatJabatan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function scopeFilter($query, array $filters){
        return $query->when($filters['search'] ?? false, function($query, $search){
            $query->where('nip', 'like', '%' . $search . '%')->orWhereHas('jabatan', function($query) use($search){
                $query->where('nama_jabatan', 'like', '%' . $search . '%');
            })->orWhereHas('bidang', function($query) use($search){
                $query->where('nama_bidang', 'like', '%' . $search . '%');
            });
        });
    }

    public function pegawai(){
        return $this->belongsTo(Pegawai::class);
    }

    public function bidang(){
        return $this->belongsTo(Bidang::class);
    }

    public function jabatan(){
        return $this->belongsTo(Jabatan::class);
    }

    public function golongan(){
        return $this->belongsTo(Golongan::class);
    }
}
