<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Bidang;
use App\Models\RiwayatJabatan;
use App\Models\Presensi;
use Illuminate\Http\Request;
use DateTime;

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
        
        $pegawai = Pegawai::all();
        $pegawaiBerulangTahun = [];
        $pegawaiNaikGolongan = [];
        foreach($pegawai->sortBy('tanggal_lahir') as $item):
            $tanggal_masuk = new DateTime("$item->tanggal_masuk");
            $sekarang = new DateTime("today");
            if ($tanggal_masuk > $sekarang) { 
            $thn = "0";
            $bln = "0";
            $tgl = "0";
            }
            $thn = $sekarang->diff($tanggal_masuk)->y;
            $bln = $sekarang->diff($tanggal_masuk)->m;
            $tgl = $sekarang->diff($tanggal_masuk)->d;
        {
            if(date('F', strtotime($item->tanggal_lahir)) == date('F', strtotime(now()))){
                $pegawaiBerulangTahun[] = $item;
            }
        }endforeach;
        foreach($pegawai as $item):
            $tanggal_masuk = new DateTime("$item->tanggal_masuk");
            $sekarang = new DateTime("today");
            if ($tanggal_masuk > $sekarang) { 
            $thn = "0";
            $bln = "0";
            $tgl = "0";
            }
            $thn = $sekarang->diff($tanggal_masuk)->y;
            $bln = $sekarang->diff($tanggal_masuk)->m;
            $tgl = $sekarang->diff($tanggal_masuk)->d;
        {
            if($item->riwayatJabatan != null){
                if($thn > $item->riwayatJabatan->golongan->min_masa_kerja && $thn != $item->riwayatJabatan->golongan->max_masa_kerja){
                    $pegawaiNaikGolongan[] = $item;
                }
            }
        }endforeach;
        return view('index', [
            'title' => 'Dashboard',
            'data_pegawai_tetap' => Pegawai::where('status', '=' , '1')->count(),
            'data_pegawai_kontrak' => Pegawai::where('status', '=' , '2')->count(),
            'data_pegawai_magang' => Pegawai::where('status', '=' , '3')->count(),
            'data_pegawai_total' => Pegawai::all()->count(),
            'categories' => $categories,
            'series' => $series,
            'pegawaiBerulangTahun' => $pegawaiBerulangTahun,
            'pegawaiNaikGolongan' => $pegawaiNaikGolongan,
            'jumlah_kehadiranBulanIni' => Presensi::wherePegawaiId(session()->get('pegawai_id'))->whereTanggal(date('m'))->count()
        ]);
    }
}
