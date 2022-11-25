<?php

namespace App\Models;

use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatJabatan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function scopeFilter($query, array $filters){
        return $query->when($filters['search'] ?? false, function($query, $search){
            $query->WhereHas('pegawai', function($query) use($search){
                $query->where('nip', 'like', '%' . $search . '%');
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
