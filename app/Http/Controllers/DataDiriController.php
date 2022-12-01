<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Bidang;
use App\Models\Jabatan;
use App\Models\Golongan;


class DataDiriController extends Controller
{
    public function index(){
        $pegawai = Pegawai::select('*')->where('nip', auth()->user()->username)->get();

        return view('data-diri/index',[
            'title'  => 'Data Diri',
            'pegawai'  => $pegawai[0],
            'data_bidang' => Bidang::all(),
            'data_jabatan' => Jabatan::all(),
            'data_golongan' => Golongan::all(),
            'data_berkas' => Pegawai::find($pegawai[0]->id)->berkas()->filter(request(['search']))->paginate('5'),
            'data_riwayatJabatan' => Pegawai::find($pegawai[0]->id)->riwayatJabatan_()->get(),
            'jenis_berkas' => Pegawai::data_jenis_berkas(),
        ]);
    }
}
