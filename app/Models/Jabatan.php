<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $guarded =['id'];

    public function scopeFilter($query, array $filters){
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('kode_jabatan', 'like', '%' . $search . '%')
            ->orWhere('nama_jabatan', 'like', '%' . $search . '%');  
        });
    }

    public function bidang(){
        return $this->belongsTo(Bidang::class);
    }
}
