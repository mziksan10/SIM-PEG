<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $guarded =['id'];

    public function scopeFilter($query, array $filters){
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('kode_bidang', 'like', '%' . $search . '%')
            ->orWhere('nama_bidang', 'like', '%' . $search . '%');  
        });
    }

    public function jabatan(){
        return $this->hasMany(Jabatan::class);
    }
}
