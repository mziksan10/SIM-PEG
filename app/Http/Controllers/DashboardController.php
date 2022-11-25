<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Bidang;
use App\Models\RiwayatJabatan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(){
        $bidang = Bidang::all();
        $bidang_id = RiwayatJabatan::select('bidang_id')->groupBy('bidang_id')->get();
        $series = [];
        foreach($bidang_id as $item){
        $test = RiwayatJabatan::select('pegawai_id')->groupBy('pegawai_id')->where('bidang_id', '=' , $item->bidang_id)->get();
        $series[] = $test->count();
        }
        $categories = [];
        foreach($bidang_id as $item){
            $item->bidang_id;
            foreach($bidang as $b){
                if($b->id == $item->bidang_id){
                    $categories[] = $b->nama_bidang;
                }
    
            }
        }
        return view('index', [
            "title" => "Dashboard",
            "photo" => "logo_piksi.png",
            "data_pegawai_aktif" => Pegawai::where('status', '=' , 'Aktif')->count(),
            "data_pegawai_nonaktif" => Pegawai::where('status', '=' , 'Non Aktif')->count(),
            "data_pegawai_cuti" => Pegawai::where('status', '=' , 'Cuti')->count(),
            "data_pegawai_total" => Pegawai::all()->count(),
            'categories' => $categories,
            'series' => $series,
        ]);
    }
}
